<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 1: PHP Syntax & Architecture";
$systemVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown CLI';
$currentDate = date('Y-m-d H:i:s');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Welcome to the Professional Environment</h2>
    <p>PHP gives us incredible flexibility to interact with server configuration dynamically.</p>
</div>

<div class="info-box">
    <strong>System Properties Loaded Separately:</strong>
    <ul>
        <li><strong>PHP Engine Version:</strong> <?= htmlspecialchars($systemVersion) ?></li>
        <li><strong>Web Server:</strong> <?= htmlspecialchars($serverSoftware) ?></li>
        <li><strong>Execution Timestamp:</strong> <?= htmlspecialchars($currentDate) ?></li>
    </ul>
</div>

<p><em>Notice how clean this source code is compared to legacy echo statements!</em></p>

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/install.php" target="_blank">PHP Manual: Installation &amp; Environment</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
phpinfo();
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>