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


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.pdo.php" target="_blank">PHP Manual: JOIN Queries</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>SELECT u.name, p.title 
FROM users u 
JOIN posts p ON u.id = p.user_id;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>