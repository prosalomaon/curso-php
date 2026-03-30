<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 39 Project: Cache Busting";

// Simulated config
$appVersion = "v2.1.4"; // Incrementing this forces CSS resets immediately globally
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Client-Side Cache Invalidation</h2>
</div>

<h3>Applying Timestamp / Version Strings to Static Assets:</h3>
<pre>
&lt;!-- BAD: Browser caches it for 30 days forever! --&gt;
&lt;link rel="stylesheet" href="/style.css"&gt;

&lt;!-- GOOD: Using structural version mapping --&gt;
&lt;link rel="stylesheet" href="/style.css?v=<?= htmlspecialchars($appVersion) ?>"&gt;

&lt;!-- BEST: Using exact file modification time mapping --&gt;
&lt;link rel="stylesheet" href="/style.css?time=<?= filemtime(__DIR__ . '/../style.css') ?>"&gt;
</pre>

<div class="info-box">
    Using <code>filemtime()</code> solves the CSS/JS cache problems elegantly. The moment you save the CSS file physically, the number changes, destroying the user's browser cache natively!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.php" target="_blank">PHP Manual: Architecture</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
// Design patterns, Dependency Injection
$app = new Application(new Database());
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>