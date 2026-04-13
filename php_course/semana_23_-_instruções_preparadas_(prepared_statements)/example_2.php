<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 23: Mecanismo de Busca de Artigos Seguro";

$searchTerm = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$simulatedResults = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    // 1. O curinga % deve ser anexado no PHP, não na instrução SQL bruta!
    $boundVariable = '%' . $searchTerm . '%';
    
    // 2. Simulação de execução de DB
    $simulatedResults = [
        ['id' => 44, 'titulo' => "Dominando a Arquitetura de {$searchTerm}"],
        ['id' => 99, 'titulo' => "Implantando {$searchTerm} na AWS"]
    ];
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mapeamento de Integração WILDCARD</h2>
    <p>Usando <code>LIKE</code> com PDO.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Buscar no Banco de Dados do Blog:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="query" required autocomplete="off" placeholder="Tente buscar 'PHP'">
        <button type="submit" style="white-space:nowrap;">Executar Consulta</button>
    </div>
</form>

<?php if ($simulatedResults !== null): ?>
    <h3>Saída do Banco de Dados (0.012s):</h3>
    <ul>
        <?php foreach ($simulatedResults as $row): ?>
            <li><strong>[Artigo #<?= $row['id'] ?>]</strong> <?= htmlspecialchars($row['titulo']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <div class="info-box" style="margin-top:20px;">
        <strong>Nos bastidores, SQL executado com segurança:</strong><br>
        <code>SELECT * FROM artigos WHERE titulo LIKE :query</code><br>
        <em>Vinculado <code>:query</code> para <code>"<?= htmlspecialchars('%' . $searchTerm . '%') ?>"</code></em>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdo.prepared-statements.php" target="_blank">Manual PHP: Instruções Preparadas</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$stmt = $pdo-&gt;prepare(&#039;SELECT * FROM users WHERE id = ?&#039;);
$stmt-&gt;execute([$id]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>