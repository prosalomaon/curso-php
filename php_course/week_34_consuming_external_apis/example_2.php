<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 34 Project: Monolog Abstraction";

$codeSim = <<<PHP
use Monolog\\Logger;
use Monolog\\Handler\\StreamHandler;

// Create a central logging pipeline
\$log = new Logger('AppEngine');
\$log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::WARNING));

try {
    throw new Exception("Cache completely disconnected!");
} catch (Exception \$e) {
    // Only logs WARNING and above (ERROR, CRITICAL, EMERGENCY)
    \$log->error("System Interruption: " . \$e->getMessage(), [
        'ip' => \$_SERVER['REMOTE_ADDR']
    ]);
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Standardized Logging (PSR-3)</h2>
    <p>Instead of manual <code>file_put_contents()</code>, the entire industry utilizes <code>Monolog</code> to stream errors directly to Slack, Disk, or AWS CloudWatch!</p>
</div>

<h3>Implementation Code:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>Log Levels:</strong> DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY. Different handlers can be attached simultaneously (e.g. Save everything to disk, but email the team ONLY on EMERGENCY).
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.curl.php" target="_blank">PHP Manual: External APIs (cURL)</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$ch = curl_init(&#039;https://api.github.com/users/octocat&#039;);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>