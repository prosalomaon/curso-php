<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 23 Project: Secure Article Search Engine";

$searchTerm = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$simulatedResults = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    // 1. The wildcard % must be appended in PHP, not in the raw SQL statement!
    $boundVariable = '%' . $searchTerm . '%';
    
    // 2. Simulated DB execution
    $simulatedResults = [
        ['id' => 44, 'title' => "Mastering {$searchTerm} Architecture"],
        ['id' => 99, 'title' => "Deploying {$searchTerm} to AWS"]
    ];
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>WILDCARD Integration Mapping</h2>
    <p>Using <code>LIKE</code> with PDO.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Search the Blog Database:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="query" required autocomplete="off" placeholder="Try searching 'PHP'">
        <button type="submit" style="white-space:nowrap;">Run Query</button>
    </div>
</form>

<?php if ($simulatedResults !== null): ?>
    <h3>Database Output (0.012s):</h3>
    <ul>
        <?php foreach ($simulatedResults as $row): ?>
            <li><strong>[Article #<?= $row['id'] ?>]</strong> <?= htmlspecialchars($row['title']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <div class="info-box" style="margin-top:20px;">
        <strong>Behind the scenes SQL Executed safely:</strong><br>
        <code>SELECT * FROM articles WHERE title LIKE :query</code><br>
        <em>Bound <code>:query</code> to <code>"<?= htmlspecialchars('%' . $searchTerm . '%') ?>"</code></em>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdo.prepared-statements.php" target="_blank">PHP Manual: Prepared Statements</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$stmt = $pdo-&gt;prepare(&#039;SELECT * FROM users WHERE id = ?&#039;);
$stmt-&gt;execute([$id]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>