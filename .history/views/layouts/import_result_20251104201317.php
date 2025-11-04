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
            't
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
            't
