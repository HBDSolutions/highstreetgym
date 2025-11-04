<?php
{
private PDO $db;
private XmlImportService $service;


public function __construct(PDO $db)
{
$this->db = $db;
$this->service = new XmlImportService($db);
}


/**
* Route: GET /admin/import-xml
*/
public function showForm(): void
{
// Render the form
require __DIR__ . '/../views/admin/import_xml.php';
}


/**
* Route: POST /admin/import-xml
*/
public function handleUpload(): void
{
session_start();
if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
http_response_code(400);
$error = 'Invalid CSRF token.';
require __DIR__ . '/../views/admin/import_result.php';
return;
}


$type = $_POST['import_type'] ?? '';
$mode = $_POST['mode'] ?? 'insert'; 


if (!isset($_FILES['xml_file']) || $_FILES['xml_file']['error'] !== UPLOAD_ERR_OK) {
http_response_code(400);
$error = 'Upload failed or no file provided.';
require __DIR__ . '/../views/admin/import_result.php';
return;
}


$tmpPath = $_FILES['xml_file']['tmp_name'];
$originalName = basename($_FILES['xml_file']['name']);


// Hard paths
$dtdDir = __DIR__ . '/../public/xml/dtd';
$workDir = sys_get_temp_dir();
$dest = $workDir . DIRECTORY_SEPARATOR . uniqid('hsg_', true) . '_' . $originalName;
if (!move_uploaded_file($tmpPath, $dest)) {
$error = 'Could not move uploaded file.';
require __DIR__ . '/../views/admin/import_result.php';
return;
}


try {
if ($type === 'members') {
$result = $this->service->importMembers($dest, $dtdDir . '/memberAdd.dtd', $mode);
} elseif ($type === 'timetable') {
$result = $this->service->importTimetable($dest, [
'class_dtd' => $dtdDir . '/classAdd.dtd',
'schedule_dtd' => $dtdDir . '/scheduleAdd.dtd',
], $mode);
} else {
throw new InvalidArgumentException('Unknown import type.');
}
} catch (Throwable $e) {
$error = 'Import failed: ' . $e->getMessage();
require __DIR__ . '/../views/admin/import_result.php';
return;
} finally {
if (is_file($dest)) @unlink($dest);
}


// $result is an ImportReport array
$report = $result;
require __DIR__ . '/../views/admin/import_result.php';
}
}