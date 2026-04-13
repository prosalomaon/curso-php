<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 7: Gerador de Matriz de Pixels";

$matrix = [];
$size = 8; // 8x8 Grid

for ($row = 0; $row < $size; $row++) {
    for ($col = 0; $col < $size; $col++) {
        // Gera um brilho aleatório para cada pixel
        $matrix[$row][$col] = rand(0, 255);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Processamento de Matriz Aninhada</h2>
    <p>Útil para desenvolvimento de jogos, filtragem de imagem ou renderização de mapas de dados!</p>
</div>

<div style="display:grid; grid-template-columns: repeat(<?= $size ?>, 40px); gap:2px; justify-content:center; background:#000; padding:10px; border-radius:8px;">
    <?php foreach ($matrix as $row): ?>
        <?php foreach ($row as $pixel): ?>
            <div style="width:40px; height:40px; background:rgb(<?= "$pixel, 120, $pixel" ?>); border:1px solid rgba(255,255,255,0.1);"></div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<p style="text-align:center; margin-top:10px;"><em>Matriz 8x8 gerada dinamicamente via loops <code>for</code> aninhados.</em></p>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/control-structures.foreach.php" target="_blank">Manual do PHP: Laços de Repetição</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
foreach($users as $id =&gt; $name) {
    echo &quot;Usuário $id: $name&quot;;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>