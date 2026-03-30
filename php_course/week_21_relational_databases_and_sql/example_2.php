<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 21 Project: Blog Database Bootstrap";

$tables = [
    'categories' => "
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
)",
    'articles' => "
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NULL,
    title VARCHAR(200) NOT NULL,
    body TEXT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
)"
];

$simulatedLogs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($tables as $name => $query) {
        $simulatedLogs[] = "Migrated target node: [{$name}]";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>CMS Schema Bootstrap Engine</h2>
</div>

<?php if ($simulatedLogs): ?>
    <div class="content-box" style="background:#000; color:#0f0;">
        <?php foreach ($simulatedLogs as $log): ?>
            <div>>> <?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
        <div style="margin-top:10px; color:yellow;">System configured for PDO insertion successfully.</div>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;" <?= $simulatedLogs ? 'disabled' : '' ?>>Execute System Migrations</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.pdo.php" target="_blank">PHP Manual: SQL Basics</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL
);</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>