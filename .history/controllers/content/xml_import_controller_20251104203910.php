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

        // UPLOAD CHECK
        if (!isset($_FILES['xml_file']) || $_FILES['xml_file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            $error = 'Upload failed or no file provided.';
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

        // PICK DTD FILE
        $dtdFile = '';
        if ($type === 'members') {
            $dtdFile = $dtdDir . '/memberAdd.dtd';
        } elseif ($type === 'classes') {
            $dtdFile = $dtdDir . '/classAdd.dtd';
        } elseif ($type === 'schedules') {
            $dtdFile = $dtdDir . '/scheduleAdd.dtd';
        } else {
            @unlink($workPath);
            $error = 'Unknown import type.';
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        // VALIDATE AGAINST DTD
        try {
            $this->validateDTD($workPath, $dtdFile);
        } catch (Throwable $e) {
            @unlink($workPath);
            $error = 'DTD validation failed: ' . $e->getMessage();
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        // BUILD PREVIEW
        try {
            $preview = $this->previewFromXml($type, $workPath);
        } catch (Throwable $e) {
            @unlink($workPath);
            $error = 'Failed to parse XML: ' . $e->getMessage();
            require __DIR__ . '/../../views/layouts/import_result.php';
            return;
        }

        // CLEANUP
        @unlink($workPath);

        // REPORT
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
    }

// VALIDATE DTD
private function validateDTD(string $xmlPath, string $dtdPath): void
{
    if (!is_file($dtdPath) || !is_readable($dtdPath)) {
        throw new RuntimeException('DTD not found: ' . $dtdPath);
    }

    $dom = new DOMDocument();
    $dom->resolveExternals = false;
    $dom->substituteEntities = false;
    $dom->load($xmlPath, LIBXML_NONET);

    $impl = new DOMImplementation();
    $rootName = $dom->documentElement->nodeName;

    $abs = realpath($dtdPath);
    if ($abs === false) {
        throw new RuntimeException('Could not resolve DTD path: ' . $dtdPath);
    }
    $abs = str_replace('\\', '/', $abs);

    $dtd = $impl->createDocumentType($rootName, '', $abs);
    $newDom = $impl->createDocument('', '', $dtd);
    $newDom->encoding = 'UTF-8';
    $newDom->resolveExternals = false;
    $newDom->substituteEntities = false;

    $newDom->appendChild($newDom->importNode($dom->documentElement, true));

    libxml_use_internal_errors(true);
    $ok = $newDom->validate();
    $errs = libxml_get_errors();
    libxml_clear_errors();
    libxml_use_internal_errors(false);

    if (!$ok) {
        $msgs = array_map(fn($e) => trim($e->message), $errs);
        throw new RuntimeException(implode(' | ', $msgs));
    }
}

    // PREVIEW BUILDER
    private function previewFromXml(string $type, string $xmlPath): array
    {
        $sx = simplexml_load_file($xmlPath, 'SimpleXMLElement', LIBXML_NONET);
        if ($sx === false) {
            throw new RuntimeException('Invalid XML.');
        }

        $out = [];

        if ($type === 'members') {
            $i = 0;
            foreach ($sx->member as $m) {
                $out[] = [
                    'first_name' => (string)$m->first_name,
                    'last_name'  => (string)$m->last_name,
                    'email'      => (string)$m->email,
                    'phone'      => (string)$m->phone,
                    'status'     => (string)$m->status,
                ];
                if (++$i >= 5) break;
            }
        } elseif ($type === 'classes') {
            $i = 0;
            foreach ($sx->class as $c) {
                $out[] = [
                    'class_name'       => (string)$c->class_name,
                    'description'      => (string)$c->description,
                    'duration'         => (string)$c->duration,
                    'difficulty_level' => (string)$c->difficulty_level,
                ];
                if (++$i >= 5) break;
            }
        } elseif ($type === 'schedules') {
            $i = 0;
            foreach ($sx->schedule as $s) {
                $out[] = [
                    'trainer_id'   => (string)$s->trainer_id,
                    'class_id'     => (string)$s->class_id,
                    'day_of_week'  => (string)$s->day_of_week,
                    'start_time'   => (string)$s->start_time,
                    'end_time'     => (string)$s->end_time,
                    'max_capacity' => (string)$s->max_capacity,
                ];
                if (++$i >= 5) break;
            }
        } else {
            throw new RuntimeException('Unsupported import type for preview.');
        }

        return $out;
    }
}

// ENTRY POINT
$controller = new XmlImportController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleUpload();
} else {
    $controller->showForm();
}