<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 11: Mergulho Profundo em Superglobais";

$serverData = [
    'Endereço IP' => $_SERVER['REMOTE_ADDR'] ?? 'Desconhecido',
    'Agente do Usuário' => $_SERVER['HTTP_USER_AGENT'] ?? 'Desconhecido CLI',
    'Método HTTP' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
    'URI da Requisição' => $_SERVER['REQUEST_URI'] ?? '/'
];

// Always sanitize GET before dumping it into HTML!
$cleanQuery = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Estado do Ambiente via <code>$_SERVER</code></h2>
    <p>O PHP constrói automaticamente um array associativo massivo contendo tudo sobre a requisição web atual.</p>
</div>

<table>
    <thead><tr><th>Nome da Propriedade</th><th>Valor Detectado</th></tr></thead>
    <tbody>
        <?php foreach ($serverData as $key => $val): ?>
            <tr><td><strong><?= htmlspecialchars($key) ?></strong></td><td><code><?= htmlspecialchars($val) ?></code></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="content-box">
    <h3>Filtro de Busca Seguro (<code>$_GET</code>)</h3>
    <form method="GET" style="display:flex; gap:10px;">
        <input type="text" name="q" value="<?= $cleanQuery ?>" placeholder="Tente passar <script>alert(1)</script>">
        <button type="submit" style="white-space:nowrap;">Ação de Busca</button>
    </form>
    
    <?php if ($cleanQuery): ?>
        <p>Você buscou com segurança por: <strong><?= $cleanQuery ?></strong></p>
    <?php endif; ?>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.variables.superglobals.php" target="_blank">Manual PHP: Superglobais</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
var_dump($_SERVER[&#039;HTTP_HOST&#039;]);
var_dump($_GET[&#039;id&#039;] ?? 1);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>