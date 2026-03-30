<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 13: Session Security and State Management";

// 1. Mandatory Security Directives BEFORE opening the session engine!
session_set_cookie_params([
    'lifetime' => 3600, // TimeToLive (Seconds)
    'path' => '/',
    'domain' => '', 
    'secure' => false,  // True in production! Prevents interception over HTTP.
    'httponly' => true, // Prevents XSS Javascript from reading the session.
    'samesite' => 'Lax'
]);

session_start();
$actionLog = [];

if (isset($_GET['login']) && empty($_SESSION['user_id'])) {
    // Session Fixation Prevention
    session_regenerate_id(true); 
    $_SESSION['user_id'] = mt_rand(1000, 9999);
    $_SESSION['role'] = 'SUPER_ADMIN';
    $actionLog[] = "Authentication Authorized. Session Identity completely regenerated.";
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/'); // Nuke the client-side reference
    $actionLog[] = "Session purged. Client cookie destroyed. Re-execution required.";
}

$stateActive = !empty($_SESSION['user_id']);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Secure Session Lifecycle</h2>
    <p>PHP handles session mechanics automatically, but requires strict tuning to avoid Hijacking and Fixation exploits.</p>
</div>

<?php foreach ($actionLog as $log): ?>
    <div class="success-box"><?= htmlspecialchars($log) ?></div>
<?php endforeach; ?>

<div class="info-box">
    <strong>Internal Pointer (Session ID):</strong> <code><?= htmlspecialchars(session_id() ?: 'NONE') ?></code><br>
    <?php if ($stateActive): ?>
        <strong>User ID:</strong> <?= $_SESSION['user_id'] ?> |
        <strong>Global Role:</strong> <?= $_SESSION['role'] ?>
    <?php else: ?>
        <strong>Auth State:</strong> UNIDENTIFIED GUEST
    <?php endif; ?>
</div>

<div style="display:flex; gap:10px;">
    <?php if (!$stateActive): ?>
        <a href="?login=1"><button>Simulate Secure Login</button></a>
    <?php else: ?>
        <a href="?logout=1"><button style="background:red;">Purge Session (Logout)</button></a>
    <?php endif; ?>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.sessions.php" target="_blank">PHP Manual: Sessions</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
session_start();
$_SESSION[&#039;user_id&#039;] = 404;
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>