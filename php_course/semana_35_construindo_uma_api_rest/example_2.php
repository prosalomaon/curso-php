<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 35: CORS e Rate Limiting";

$codeSim = <<<PHP
// 1. Mapa de Compartilhamento de Recursos de Origem Cruzada (CORS)
header("Access-Control-Allow-Origin: https://aplicativo-vue-frontend.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 2. Manipulação de requisição OPTIONS pre-flight (Navegadores enviam isso antes de POSTar)
if (\$_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 3. Exemplo de Restrição de Rate Limiting (Geralmente via Redis)
\$hits = checkRedisHits(\$_SERVER['REMOTE_ADDR']);
if (\$hits > 60) {
    header("Retry-After: 60");
    http_response_code(429); // Too Many Requests
    echo json_encode(['error' => 'Limite de Requisições Excedido.']);
    exit;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Segurança de Infraestrutura de API</h2>
    <p>Devemos instruir manualmente o navegador se um site estrangeiro (como um aplicativo Vue.js ou React) tem permissão legal para buscar dados do nosso servidor PHP.</p>
</div>

<h3>Implementação de Gateway Seguro:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>HTTP 429:</strong> Nunca deixe os usuários em loop infinito em uma requisição de API. Implementar Rate Limiting matematicamente protege seu banco de dados contra ataques DDoS!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/reserved.variables.server.php" target="_blank">Manual PHP: Construindo APIs</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
if ($_SERVER[&#039;REQUEST_METHOD&#039;] === &#039;POST&#039;) {
    // Criar recurso
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>