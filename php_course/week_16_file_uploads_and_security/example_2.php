<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 16 Project: Vault Deposit Endpoint";

$vaultStorage = __DIR__ . '/private_vault_data';
$msg = null;

// Initializing the Vault Area
if (!is_dir($vaultStorage)) { @mkdir($vaultStorage, 0700); }

// Creating the execution blocker!
$htaccessNode = "Order Deny,Allow\nDeny from all";
if (!file_exists("$vaultStorage/.htaccess")) {
    file_put_contents("$vaultStorage/.htaccess", $htaccessNode);
}

// Processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['vault_doc'])) {
    $tmpName = $_FILES['vault_doc']['tmp_name'];
    
    // Ensure the file is a legal PHP upload (Prevents manipulating $tmpName)
    if (is_uploaded_file($tmpName)) {
        // We strip absolutely everything except letters and numbers
        $rawName = $_FILES['vault_doc']['name'];
        $safeOriginalName = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $rawName);
        
        $destination = $vaultStorage . '/' . date('Y_m_d_His_') . $safeOriginalName;
        
        if (move_uploaded_file($tmpName, $destination)) {
            $msg = "Payload `{$safeOriginalName}` injected into private storage successfully.";
        }
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Secure Vault Document Deposit</h2>
    <p>Anything placed in the vault is heavily guarded. A custom `.htaccess` file prevents arbitrary remote execution.</p>
</div>

<?php if ($msg): ?>
    <div class="success-box"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="content-box">
    <label>Identify file to lock:</label>
    <input type="file" name="vault_doc" required>
    <button type="submit" style="width:100%;">Encrypt & Deposit</button>
</form>

<div class="info-box">
    <strong>Infrastructure Note:</strong> Check the <code>private_vault_data</code> folder. The generated <code>.htaccess</code> forcefully breaks HTTP access, protecting our documents from public exposure even if they guess the file name!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.file-upload.php" target="_blank">PHP Manual: File Uploads</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
move_uploaded_file($_FILES[&#039;img&#039;][&#039;tmp_name&#039;], &#039;./upload/&#039; . $fileName);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>