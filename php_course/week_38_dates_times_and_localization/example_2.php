<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 38 Project: Test-Driven Development (TDD)";

$conceptText = <<<TEXT
1. RED: Write the exact Test FIRST! Run it. Watch it fail because no code exists yet natively.
2. GREEN: Write the minimal amount of PHP code required to pass the verification node.
3. REFACTOR: Clean up the code architecture safely, while verifying the tests still pass.
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Test-Driven Development Workflow</h2>
</div>

<h3>The TDD Cycle Configuration Matrix</h3>
<pre><?= htmlspecialchars($conceptText) ?></pre>

<div class="success-box">
    Writing tests initially feels slow. But as your system grows to thousands of lines, changing 1 fundamental method takes 5 seconds of testing, rather than an entire week of manual QA verification!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.datetime.php" target="_blank">PHP Manual: Dates &amp; Times</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$dt = new DateTime();
echo $dt-&gt;format(&#039;Y-m-d H:i:s&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>