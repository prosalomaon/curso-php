<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 25: Arquitetura Muitos-para-Muitos em CMS";

$manyToManySyntax = <<<SQL
SELECT tags.nome_tag 
FROM tags
INNER JOIN artigo_tags ON tags.id = artigo_tags.tag_id
WHERE artigo_tags.artigo_id = :post_id;
SQL;

// Execução simulada retornada pelo PDO
$articleTags = ['Ciência', 'Arquitetura PHP', 'Backend Design'];

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Contexto de Tabelas Pivô (Pivot)</h2>
    <p>Artigos têm várias Tags. Tags têm vários Artigos. Resolvemos esse pesadelo de banco de dados usando uma Tabela Pivô (<code>artigo_tags</code>) mapeada nativamente via um <code>INNER JOIN</code>.</p>
</div>

<h3>Representação de Consulta CMS</h3>
<pre><?= htmlspecialchars($manyToManySyntax) ?></pre>

<div class="success-box">
    <strong>Tags vinculadas ao Artigo Renderizado:</strong>
    <ul style="margin-bottom:0;">
        <?php foreach ($articleTags as $tag): ?>
            <li style="font-family:monospace;">~ <?= htmlspecialchars($tag) ?></li>
        <?php endforeach; ?>
    </ul>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.pdo.php" target="_blank">Manual PHP: Consultas JOIN</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>SELECT u.name, p.title 
FROM users u 
JOIN posts p ON u.id = p.user_id;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>