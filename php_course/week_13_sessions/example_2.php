<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 13 Project: Secure File Vault Router";

session_start();
$authError = null;
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'login';

// Form Logic Check
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Hardcoded dev credentials
    if ($user === 'admin' && $pass === 'secret') {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = $user;
        
        // Post-Redirect-Get implementation
        header("Location: ?page=vault_dashboard");
        exit;
    } else {
        $authError = "Critical Auth Failure: Credentials do not match database.";
    }
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
    exit;
}

// Router Gate
$isVaultViewing = ($page === 'vault_dashboard');
if ($isVaultViewing && empty($_SESSION['vault_access'])) {
    // 403 Forbidden Simulation
    http_response_code(403);
    $page = '403';
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->

<?php if ($page === 'login'): ?>
    <div class="content-box">
        <h2>File Vault Authentication</h2>
    </div>

    <?php if ($authError): ?>
        <div class="error-box"><?= htmlspecialchars($authError) ?></div>
    <?php endif; ?>

    <form method="POST" class="content-box" style="margin: 0 auto; max-width:400px; background:var(--hover-bg);">
        <label>Operator Identification:</label>
        <input type="text" name="username" required>
        
        <label>Passphrase:</label>
        <input type="password" name="password" required>
        
        <button type="submit" style="width:100%;">Authorize Access</button>
        <small style="display:block; text-align:center; margin-top:15px;">Target: admin / secret</small>
    </form>

<?php elseif ($page === 'vault_dashboard'): ?>
    <div class="success-box" style="text-align:center;">
        <h2 style="margin:0;">VAULT ACCESS GRANTED</h2>
        <p style="text-transform:uppercase;">OPERATOR: <?= htmlspecialchars($_SESSION['user']) ?></p>
    </div>
    
    <table style="width:100%; font-family:monospace;">
        <tr><th>File Name</th><th>Security Level</th><th>Actions</th></tr>
        <tr><td>core_infrastructure.pdf</td><td>LEVEL_OMEGA</td><td>[ENCRYPTED]</td></tr>
        <tr><td>customer_hashes.csv</td><td>LEVEL_ALPHA</td><td>[ENCRYPTED]</td></tr>
    </table>
    
    <div style="text-align:center;">
        <a href="?page=logout"><button style="background:red;">Terminate Session</button></a>
    </div>

<?php elseif ($page === '403'): ?>
    <div class="error-box" style="text-align:center; padding:50px;">
        <h1 style="font-size:3em; margin:0;">HTTP 403</h1>
        <p>FORBIDDEN: You must authenticate to view this sector.</p>
        <a href="?page=login" style="color:var(--text-color); font-weight:bold;">[ RETURN TO AUTHORIZATION GATE ]</a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>