<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 28 Project: Master Layout Wrappers";

$outputBufferingCode = <<<PHP
// 1. Pause browser screen output explicitly
ob_start();

// 2. Load the page data natively (e.g., login_form.php)
require 'views/' . \$viewName . '.php';

// 3. Dump buffer into a string variable
\$content = ob_get_clean();

// 4. Inject it into the Master Layout Frame
require 'layouts/master.php'; 
// (Inside master.php, we simply write: <?=\$content?> in the center of the HTML)
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Output Buffering Interception</h2>
    <p>How does a framework render the same header and footer globally without needing to literally copy-paste <code>require 'header.php'</code> into every single file? Using the super powerful <code>ob_start()</code> system.</p>
</div>

<h3>Internal Renderer Injection Script:</h3>
<pre><?= htmlspecialchars($outputBufferingCode) ?></pre>

<div class="info-box">
    <strong>Note:</strong> We are currently utilizing a basic version of this internally in the <code>php_course</code> folder to enforce our Black & White design!
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