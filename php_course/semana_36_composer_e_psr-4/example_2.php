<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 36: Carga cURL Avançada de Extranete";

$curlCode = <<<PHP
\$ch = curl_init("https://api.stripe.com/v1/charges");

// Configurar carga cURL massiva
curl_setopt_array(\$ch, [
    CURLOPT_RETURNTRANSFER => true, // Retorna dados em vez de imprimir!
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['amount' => 2000, 'currency' => 'brl']),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer sk_test_chaveSecreta123", /* JWT ou Bearer Auth */
        "Accept: application/json"
    ],
    CURLOPT_TIMEOUT => 10,
]);

\$apiResult = curl_exec(\$ch);

if(curl_errno(\$ch)) {
    throw new Exception("Erro Crítico cURL: " . curl_error(\$ch));
}

\$httpCode = curl_getinfo(\$ch, CURLINFO_HTTP_CODE);
curl_close(\$ch);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mecanismo de Infraestrutura Client URL (cURL)</h2>
    <p>Para comunicação complexa de API (OAuth, tokens JWT Bearer, formulários multipart), o cURL fornece controle estrutural absoluto de baixo nível.</p>
</div>

<h3>Mapeamento de Configuração Mock:</h3>
<pre><?= htmlspecialchars($curlCode) ?></pre>

<div class="info-box">
    No PHP 8+ moderno, desenvolvedores frequentemente instalam o <strong>GuzzleHTTP</strong> via Composer, que envolve totalmente a lógica confusa de <code>curl_setopt</code> em métodos Orientados a Objetos bonitos (<code>$client->post('/charges', ['json' => $data]);</code>).
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.namespaces.rationale.php" target="_blank">Manual PHP: Composer e PSR-4</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
require &#039;vendor/autoload.php&#039;;
use App\Models\Usuario;
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>