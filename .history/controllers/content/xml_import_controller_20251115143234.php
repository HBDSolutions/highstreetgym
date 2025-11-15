<?php
// XML IMPORT CONTROLLER

declare(strict_types=1);

require_once __DIR__ . '/../../models/upload_validation.php';

class XmlImportController {

    // GET IMPORT XML FILE
    public function showForm(): void
    {
        session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // ACCEPT PREFILL TYPE FROM ADMIN DASHBOARD
        $prefill = $_GET['prefill'] ?? '';
        if (!in_array($prefill, ['members','classes','schedules'], true)) {
            $prefill = '';
        }

        require __DIR__ . '/../../views/layouts/import_xml.php';
    }

    // POST IMPORT XML FILE
    public function handleUpload(): void
    {
        session_start();

        // CSRF CHECK
        if (
            !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], (string)($_POST['csrf_token'] ?? ''))
        ) {
            http_response_code(400);
            $error = 'Invalid CSRF token.';
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        // INPUTS
        $type = $_POST['import_type'] ?? '';
        $mode = $_POST['mode'] ?? 'insert';

        // VALIDATE UPLOADED FILE
        $validation = validate_xml_upload($_FILES['xml_file'] ?? null);
        if (!$validation['valid']) {
            http_response_code(400);
            $error = $validation['error'];
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        // PATHS
        $dtdDir = __DIR__ . '/../../public/xml/dtd';
        $tmpPath = $_FILES['xml_file']['tmp_name'];
        $originalName = basename($_FILES['xml_file']['name']);
        $workPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('hsg_', true) . '_' . $originalName;

        // MOVE FILE TO WORK PATH
        if (!move_uploaded_file($tmpPath, $workPath)) {
            $error = 'Could not move uploaded file.';
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        // SERVICE
        require_once __DIR__ . '/../../models/database.php';
        require_once __DIR__ . '/../../models/XmlImportService.php';
        $service = new XmlImportService($conn);

        // VALIDATE AGAINST DTD
        try {
            $dtdFile = $service->dtdFor($type, $dtdDir);
            $service->validateXml($workPath, $dtdFile);
        } catch (Throwable $e) {
            @unlink($workPath);
            $error = 'DTD validation failed: ' . $e->getMessage();
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        // COMMIT OR PREVIEW
        try {
            if ($mode === 'dry_run') {
                $preview = $service->preview($type, $workPath);
                @unlink($workPath);
                $report = [
                    'type'      => $type,
                    'mode'      => $mode,
                    'validated' => true,
                    'inserted'  => 0,
                    'updated'   => 0,
                    'skipped'   => 0,
                    'warnings'  => [],
                    'errors'    => [],
                    'preview'   => $preview,
                    'status'    => 'validated',
                ];
                require __DIR__ . '/../../views/layouts/import_result.php';
                return;
            }

            if ($type === 'members') {
                $result = $service->importMembers($workPath, $mode);
            } elseif ($type === 'classes') {
                $result = $service->importClasses($workPath, $mode);
            } elseif ($type === 'schedules') {
                $result = $service->importSchedules($workPath, $mode);
            } else {
                throw new InvalidArgumentException('Unknown import type.');
            }

            @unlink($workPath);
            $report = [
                'type'      => $type,
                'mode'      => $mode,
                'validated' => true,
                'inserted'  => $result['inserted'],
                'updated'   => $result['updated'],
                'skipped'   => $result['skipped'],
                'warnings'  => $result['warnings'],
                'errors'    => $result['errors'],
                'status'    => 'committed',
            ];
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;

        } catch (Throwable $e) {
            @unlink($workPath);
            $error = 'Import failed: ' . $e->getMessage();
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }
    }
}

// ENTRY POINT
$controller = new XmlImportController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleUpload();
} else {
    $controller->showForm();
}
