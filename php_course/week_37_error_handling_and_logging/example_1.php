<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 37: Environment Variables (.env)";

$envMock = <<<ENV
APP_NAME="Etec Pro Framework"
APP_ENV=production
APP_DEBUG=false

DB_HOST=127.0.0.1
DB_PORT=3306
DB_USER=root
DB_PASS=C0mpl3xP@ss!
ENV;

// Simulating PHP's getenv native function (which $_ENV relies on)
$mockEnvVars = [
    'APP_ENV' => 'production',
    'DB_HOST' => '127.0.0.1'
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>12-Factor App Environment Configuration</h2>
    <p>Passwords should absolutely never be typed in PHP codebase files. We read them implicitly from the Host OS using `.env` files.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3><code>.env</code> File Content</h3>
        <pre><?= htmlspecialchars($envMock) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Extraction Logic</h3>
        <pre>
$env = $_ENV['APP_ENV'] ?? 'local';
$host = getenv('DB_HOST');

if ($env === 'production') {
    // Hide native error printing!
    ini_set('display_errors', '0');
}
        </pre>
    </div>
</div>

<div class="error-box">
    <strong>CRITICAL:</strong> <code>.env</code> files must inherently be listed in <code>.gitignore</code>! Never commit database structures to GitHub!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>