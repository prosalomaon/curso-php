<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 28: View Engines & Global Helpers";

// Function mapping used exclusively in HTML views mapping
function e(?string $text): string {
    return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$maliciousDataAttempt = "<script>alert('Stealing cookies using XSS!');</script>";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The Presentation Layer (Views)</h2>
    <p>Views should never format raw data directly. A global helper like <code>e()</code> ensures we never accidentally leak HTML script nodes to the browser layout.</p>
</div>

<h3>Cross Site Scripting Mitigation Matrix:</h3>
<div style="border:1px solid var(--border-color); padding:10px; margin-bottom:10px;">
    <strong>Raw Attack Output Simulation:</strong><br>
    <code style="color:red;"><?= htmlspecialchars("echo \$maliciousDataAttempt;") ?></code>
</div>

<div class="success-box">
    <strong>Escaped Protection Engine:</strong><br>
    <code>e($maliciousDataAttempt)</code> outputs:<br><br>
    <b style="color:#155724; font-family:monospace;"><?= e($maliciousDataAttempt) ?></b>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.basic-syntax.phpmode.php" target="_blank">PHP Manual: Templating</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;h1&gt;&lt;?= htmlspecialchars($title) ?&gt;&lt;/h1&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>