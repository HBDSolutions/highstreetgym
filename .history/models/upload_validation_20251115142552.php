<?php
// UPLOAD VALIDATION FUNCTIONS
// PURPOSE: VALIDATE FILE UPLOADS FOR SECURITY

function validate_xml_upload($file) {
    $maxFileSize = 5 * 1024 * 1024;
    $allowedMimeTypes = ['text/xml', 'application/xml'];
    $allowedExtension = 'xml';
    
    // Check if file exists
    if (!isset($file) || !is_array($file)) {
        return [
            'valid' => false,
            'error' => 'No file provided'
        ];
    }
    
    // Check upload error
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [
            'valid' => false,
            'error' => 'File upload failed'
        ];
    }
    
    // Get file properties
    $fileSize = $file['size'];
    $fileMime = $file['type'];
    $fileName = $file['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Validate file size
    if ($fileSize > $maxFileSize) {
        return [
            'valid' => false,
            'error' => 'File too large. Maximum size is 5MB'
        ];
    }
    
    // Validate file is not empty
    if ($fileSize === 0) {
        return [
            'valid' => false,
            'error' => 'File is empty'
        ];
    }
    
    // Validate file extension
    if ($fileExtension !== $allowedExtension) {
        return [
            'valid' => false,
            'error' => 'Invalid file type. Only .xml files are allowed'
        ];
    }
    
    // Validate MIME type
    if (!in_array($fileMime, $allowedMimeTypes, true)) {
        return [
            'valid' => false,
            'error' => 'Invalid file MIME type. Only XML files are allowed'
        ];
    }
    
    // Additional check: verify the file actually contains XML
    $tmpPath = $file['tmp_name'];
    if (file_exists($tmpPath)) {
        $fileHeader = file_get_contents($tmpPath, false, null, 0, 100);
        if ($fileHeader !== false && strpos($fileHeader, '<?xml') === false) {
            return [
                'valid' => false,
                'error' => 'File does not appear to be valid XML'
            ];
        }
    }
    
    // All checks passed
    return [
        'valid' => true,
        'error' => null
    ];
}

/**
 * Get upload configuration values
 * 
 * @return array Configuration settings
 */
function get_xml_upload_config() {
    return [
        'max_file_size' => 5 * 1024 * 1024,
        'max_file_size_readable' => '5MB',
        'allowed_mime_types' => ['text/xml', 'application/xml'],
        'allowed_extension' => 'xml'
    ];
}
?>