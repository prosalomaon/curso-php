<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 27: O Front Controller e Roteamento Dinâmico";

// Extrair URI do mapa do servidor
$mockUri = '/usuario/editar/88'; // $_SERVER['REQUEST_URI']
$mockMethod = 'POST'; // $_SERVER['REQUEST_METHOD']

// 1. Definindo mapeamento de rotas
$routeEngineMap = [
    'GET /usuario/editar/{id}' => 'UsuarioController@showEditForm',
    'POST /usuario/editar/{id}' => 'UsuarioController@saveChanges',
];

$matchedAction = null;

// 2. Simples combinador de abstração regex
if (preg_match('#^/usuario/editar/(\d+)$#', $mockUri, $matches) && $mockMethod === 'POST') {
    $matchedAction = "Acionando Controlador: [UsuarioController], executando [saveChanges], passando Dados do Parâmetro: [" . $matches[1] . "]";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Arquitetura de Entrada Única (Front Controller)</h2>
    <p>Usando `.htaccess` ou Nginx, roteamos cada solicitação (<code>/blog</code>, <code>/contato</code>) para um script mestre <code>index.php</code> que mapeia o URI perfeitamente!</p>
</div>

<div class="info-box">
    <strong>Solicitação de Carga Útil do Cliente:</strong> <code><?= $mockMethod ?> <?= $mockUri ?></code><br>
    <strong>Resultado do Despachante Regex:</strong> <?= htmlspecialchars((string)$matchedAction) ?>
</div>

<h3>Rotas de Aplicação Definidas</h3>
<ul>
    <?php foreach ($routeEngineMap as $uri => $controllerString): ?>
        <li><code><strong><?= explode(' ', $uri)[0] ?></strong> <?= explode(' ', $uri)[1] ?></code> &rarr; <code><?= $controllerString ?></code></li>
    <?php endforeach; ?>
</ul>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/reserved.variables.server.php" target="_blank">Manual PHP: Roteamento</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$uri = parse_url($_SERVER[&#039;REQUEST_URI&#039;], PHP_URL_PATH);
if ($uri === &#039;/sobre&#039;) { require &#039;sobre.php&#039;; }
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>