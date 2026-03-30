<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 26: Model-View-Controller (MVC) Pattern";

$architectureFlow = <<<TEXT
1. USER requests -> Router.
2. Router decides which CONTROLLER to deploy based on the URL.
3. Controller retrieves Data variables from the MODEL (Database).
4. Controller sanitizes and processes logic.
5. Controller injects Logic output into the VIEW (HTML).
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Total Separation of Concerns</h2>
    <p>Your PHP code has grown. MVC is the global standard for keeping huge codebases maintainable by splitting domains explicitly.</p>
</div>

<h3>The Lifecycle Matrix:</h3>
<pre><?= htmlspecialchars($architectureFlow) ?></pre>

<div class="info-box">
    <strong>Golden Rule:</strong> Views should absolutely NEVER execute SQL queries or manipulate raw business validation logic. They just print data formatting safely via <code>htmlspecialchars()</code>.
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.architecture.php" target="_blank">PHP Manual: MVC Pattern</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
// Router invokes Controller, passes Model data to View
$controller = new UserController(new UserModel());
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>