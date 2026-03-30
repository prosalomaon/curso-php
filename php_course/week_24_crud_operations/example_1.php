<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 24: ACID Compliance and Database Transactions";

$transactionCode = <<<PHP
try {
    \$pdo->beginTransaction();

    // Deduct money from Account A
    \$pdo->exec("UPDATE accounts SET balance = balance - 100 WHERE id = 1");
    
    // Add money to Account B
    \$pdo->exec("UPDATE accounts SET balance = balance + 100 WHERE id = 2");

    \$pdo->commit(); // Save all changes atomically

} catch (Exception \$e) {
    \$pdo->rollBack(); // On ANY error, revert the entire batch!
    throw \$e;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The <code>rollBack()</code> Safety Net</h2>
    <p>What happens if a script crashes natively half-way through transferring $10,000 from one user to another? Data corruption. Transactions fix this instantly.</p>
</div>

<h3>Atomic Consistency Code Block:</h3>
<pre><?= htmlspecialchars($transactionCode) ?></pre>

<div class="info-box">
    When deploying logic that touches multiple database tables simultaneously (e.g. creating a User AND assigning them a Profile), wrap it natively in a PDO Transaction!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdostatement.execute.php" target="_blank">PHP Manual: CRUD Operations</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$stmt = $pdo-&gt;prepare(&quot;INSERT INTO users (name) VALUES (:name)&quot;);
$stmt-&gt;execute([&#039;name&#039; =&gt; $data]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>