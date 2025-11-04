<?php
// XML IMPORT CONTROLLER

declare(strict_types=1);

class XmlImportController
{
    private PDO $db;
    private XmlImportService $service;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->service = new XmlImportService($db);
    }

    // GET IMPORT XML FILE
    public function showForm(): void
    {
        require __DIR__ . '/../views/admin/import_xml.php';
    }

    // POST IMPORT XML FILE
    public function handleUpload(): void
    {
        session_start();
        if (
            !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], (string)($_POST['csrf_token'] ?? ''))
        ) {
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
            require __DIR__ . '/../views/admin/impor
