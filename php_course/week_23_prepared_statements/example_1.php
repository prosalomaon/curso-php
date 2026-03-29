<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 23: Bindings & SQL Injection Defense";

$userId = $_GET['id'] ?? '1 OR 1=1; DROP TABLE users;';

$safeExample = <<<PHP
\$stmt = \$pdo->prepare("UPDATE users SET status = :status WHERE id = :user_id");

// Execute binds values perfectly, closing the injection loophole explicitly.
\$stmt->execute([
    'user_id' => \$userId,
    'status'  => 'active'
]);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Prepared Statements (The Ultimate Shield)</h2>
    <p>SQL Injection is the #1 vulnerability on the web. We kill it permanently by separating the SQL logic framework from the user's data variables using <code>prepare()</code>.</p>
</div>

<div class="error-box">
    <strong>Malicious Payload Detected in $_GET:</strong><br>
    <code><?= htmlspecialchars($userId) ?></code>
</div>

<div class="success-box">
    Using <strong>Named Bindings</strong> (<code>:variable</code>), the malicious string above is treated purely as a literal string by the database engine, causing no damage.
</div>

<h3>Deployment Code:</h3>
<pre><?= htmlspecialchars($safeExample) ?></pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>