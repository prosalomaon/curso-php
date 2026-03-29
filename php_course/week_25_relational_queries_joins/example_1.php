<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 25: Relational JOINs & System Optimization";

$querySyntax = <<<SQL
SELECT 
    users.username, 
    COUNT(posts.id) as total_posts 
FROM users 
LEFT JOIN posts ON users.id = posts.user_id 
GROUP BY users.id;
SQL;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Database Relationships over loops (N+1 Crisis)</h2>
    <p>Running SQL Queries inside a PHP <code>foreach</code> loop is heavily forbidden in production. Instead, we use SQL <code>JOIN</code> syntax to grab interconnected data instantaneously!</p>
</div>

<h3>Aggregate Data Retrieval (Count total user posts)</h3>
<pre><?= htmlspecialchars($querySyntax) ?></pre>

<div class="info-box">
    This logic executes purely inside the MySQL/MariaDB RAM in 3 milliseconds, rather than PHP hammering the network with thousands of separate connection requests natively!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>