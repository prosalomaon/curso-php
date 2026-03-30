<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 14 Project: The 'Remember Me' Vault Token";

session_start();

$validDatabaseToken = "7a4f9x1wB_secure_hash_string";
$msg = null;

// The Auto-Login Engine!
if (empty($_SESSION['vault_access']) && isset($_COOKIE['remember_me'])) {
    
    // DB Check simulation: SELECT user_id FROM tokens WHERE token = ?
    if ($_COOKIE['remember_me'] === $validDatabaseToken) {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = 'phantom_admin';
        $msg = "[AUTHD] Session fully reconstructed via cryptographic cookie payload.";
    } else {
        // Punish invalid tokens by invalidating them
        setcookie('remember_me', '', time() - 3600, '/');
    }
}

// Routes
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'home';

if ($page === 'set_cookie') {
    // Simulating checking the 'Remember Me' box
    setcookie('remember_me', $validDatabaseToken, time() + 3600, '/', '', false, true); // true = HttpOnly
    header("Location: ?page=home&status=cookie_set");
    exit;
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    setcookie('remember_me', '', time() - 3600, '/'); // Nuke the remember token too!
    header("Location: ?page=home");
    exit;
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Persistent Vault Authentication</h2>
</div>

<?php if ($msg): ?>
    <div class="success-box"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if (($_GET['status'] ?? '') === 'cookie_set'): ?>
    <div class="info-box">Long-term Cookie deployed. Close this browser and reopen it, and the system will bypass the login automatically.</div>
<?php endif; ?>

<?php if (!empty($_SESSION['vault_access'])): ?>
    <div class="content-box" style="text-align:center;">
        <h3>Welcome inside the Vault, <?= htmlspecialchars($_SESSION['user']) ?></h3>
        <p>You are fully authenticated.</p>
        <a href="?page=logout"><button style="background:red;">Logout completely (Erases Cookies)</button></a>
    </div>
<?php else: ?>
    <div class="error-box" style="text-align:center;">
        <h3>Authorization Check Failed</h3>
        <p>You have no active session and no Cookie payload.</p>
        <a href="?page=set_cookie"><button>Simulate 'Remember Me' Login</button></a>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.cookies.php" target="_blank">PHP Manual: Cookies</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
setcookie(&#039;theme&#039;, &#039;dark&#039;, time() + 3600, &#039;/&#039;, &#039;&#039;, true, true);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>