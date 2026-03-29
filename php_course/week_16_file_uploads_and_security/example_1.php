<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 16: File Upload Security Deep Dive";

$status = null;
$errorStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['payload'])) {
    
    $file = $_FILES['payload'];
    
    // 1. Base engine check
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorStatus = "Upload Engine Failure Code: " . $file['error'];
    } else {
        // 2. DO NOT TRUST THE EXTENSION OR THE CLIENT'S MIME TYPE! ($file['type'])
        // Use PHP's internal finfo_file to read the ACTUAL bytes of the file memory!
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowedType = 'application/pdf';

        if ($realMimeType !== $allowedType) {
            $errorStatus = "SECURITY CHECK FAILED: Expected PDF, but received [{$realMimeType}]. Payloads blocked.";
        } else {
            // 3. Cryptographic Renaming (Never use the user's name format!)
            $safeName = bin2hex(random_bytes(16)) . '.pdf';
            $uploadDir = __DIR__ . '/temp_secure/';
            @mkdir($uploadDir, 0755); // Suppress warning if exists
            
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
                $status = "File verified mathematically, renamed to [{$safeName}], and transferred to Vault.";
            } else {
                $errorStatus = "Internal System error moving the temporary file to persistent storage.";
            }
        }
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Impenetrable Upload Engine</h2>
    <p>File uploads are terrifying. An attacker can upload <code>shell.php</code> disguised as <code>image.png</code> and take over the server instantly. We must combat this deeply.</p>
</div>

<?php if ($status): ?>
    <div class="success-box"><?= htmlspecialchars($status) ?></div>
<?php endif; ?>
<?php if ($errorStatus): ?>
    <div class="error-box"><?= htmlspecialchars($errorStatus) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="content-box" style="background:var(--hover-bg);">
    <p style="margin-top:0;"><strong>Mandatory Format:</strong> Valid PDF Document Only.</p>
    
    <!-- Tell the browser the soft-limit (Doesn't override php.ini limits!) -->
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000"> 
    
    <label>Select Target Document:</label>
    <input type="file" name="payload" required>
    
    <button type="submit">Establish Secure Transfer</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>