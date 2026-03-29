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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>