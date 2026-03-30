<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 25 Project: CMS Many-to-Many Architecture";

$manyToManySyntax = <<<SQL
SELECT tags.tag_name 
FROM tags
INNER JOIN article_tags ON tags.id = article_tags.tag_id
WHERE article_tags.article_id = :post_id;
SQL;

// Simulated Execution returned by PDO
$articleTags = ['Science', 'PHP Architecture', 'Backend Design'];

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Pivot Tables Context</h2>
    <p>Articles have multiple Tags. Tags have multiple Articles. We resolve this database nightmare using a Pivot Table (<code>article_tags</code>) natively mapped via an <code>INNER JOIN</code>.</p>
</div>

<h3>CMS Query Representation</h3>
<pre><?= htmlspecialchars($manyToManySyntax) ?></pre>

<div class="success-box">
    <strong>Tags linked to Article Rendered:</strong>
    <ul style="margin-bottom:0;">
        <?php foreach ($articleTags as $tag): ?>
            <li style="font-family:monospace;">~ <?= htmlspecialchars($tag) ?></li>
        <?php endforeach; ?>
    </ul>
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