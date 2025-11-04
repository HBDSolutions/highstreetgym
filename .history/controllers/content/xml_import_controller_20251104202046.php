<?php
// XML IMPORT CONTROLLER

declare(strict_types=1);

class XmlImportController
{
    // GET IMPORT XML FILE
    public function showForm(): void
    {
        session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        require __DIR__ . '/../../views/layouts/import_xml.php';
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
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        $type = $_POST['import_type'] ?? '';
        $mode = $_POST['mode'] ?? 'insert';

        if (!isset($_FILES['xml_file']) || $_FILES['xml_file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            $error = 'Upload failed or no file provided.';
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        $dtdDir = __DIR__ . '/../../public/xml/dtd';

        $report = [
            'type'      => $type,
            'mode'      => $mode,
            'validated' => false,
            'inserted'  => 0,
            'updated'   => 0,
            'skipped'   => 0,
            'warnings'  => [],
            'errors'    => [],
            'paths'     => [
                'upload_tmp_name' => $_FILES['xml_file']['tmp_name'],
                'original_name'   => $_FILES['xml_file']['name'],
                'dtd_dir'         => $dtdDir,
            ],
            'status'    => 'stub',
        ];

        require __DIR__ . '/../../views/layouts/import_result.php';
    }
}

// ENTRY POINT
$controller = new XmlImportController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleUpload();
} else {
    $controller->showForm();
}
