<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 40: CSRF Tokens & Final Polish";

session_start();

// 1. Generate CRSF Token securely if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$status = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    
    // 2. Validate token exactly via timing-attack safe comparison!
    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        http_response_code(403);
        $status = "FORBIDDEN: Security Token Mismatch. Suspected CSRF Hijack execution blocked.";
    } else {
        $status = "SUCCESS: Profile Updated securely.";
        // Reset the token so it cannot be reused!
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Cross-Site Request Forgery (CSRF) Mitigation</h2>
    <p>We inject a hidden token into EVERY form. If a malicious website tricks your browser into submitting a form to your server, they won't know the exact random token so the request fails validation natively!</p>
</div>

<?php if ($status): ?>
    <div class="<?= str_starts_with($status, 'SUCCESS') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($status) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <!-- HIDDEN CONSTANT INJECTION -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    
    <label>Modify Profile Node Setup:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="data" value="Some Secure Layout Data" autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Run Execution</button>
    </div>
    
    <div style="margin-top:10px; font-size:0.8em;">
        <strong>Hidden Injected Payload:</strong> <code><?= htmlspecialchars($_SESSION['csrf_token']) ?></code>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>