<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 29 Project: E-Commerce Registry";

$log = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'] ?? '';
    
    if (!$mail) {
        $log = "Validation Block: Malformed email structure identifier.";
    } elseif (strlen($pass) < 10) {
        $log = "Security Policy Block: Passphrase requires 10 characters absolute minimum length.";
    } else {
        // Generating the Hash!
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        
        $log = "SUCCESS: Registration algorithms passed.\nDatabase Insert Triggered:\nEmail: $mail\nHashed Node: $hashed";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Account Validation Endpoint</h2>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCCESS') ? 'success-box' : 'error-box' ?>">
        <?= nl2br(htmlspecialchars($log)) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identify Contact Origin (Email):</label>
    <input type="email" name="email" required autocomplete="off">
    
    <label>Cryptographic Passphrase Base:</label>
    <input type="password" name="password" required>
    
    <button type="submit" style="width:100%;">Create Account Node</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>