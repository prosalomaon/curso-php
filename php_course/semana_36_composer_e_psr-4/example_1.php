<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 36: Consumindo APIs Externas";

// Usaremos stream_context como alternativa ao cURL para buscas básicas!
$resultData = null;
$errorLog = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = "https://jsonplaceholder.typicode.com/posts/1"; // API fake pública
    
    // Configurando a configuração HTTP nativamente no PHP sem cURL
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: EtecPHPProfissional/1.0\r\n" .
                        "Accept: application/json\r\n",
            'timeout' => 5
        ]
    ];
    
    $context = stream_context_create($options);
    
    // O @ suprime avisos para que possamos capturá-los de forma limpa para a UI
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        $errorLog = "Falha na Rede: Não foi possível conectar de forma limpa à API Typicode.";
    } else {
        // Decodificamos com segurança para um Array Associativo (argumento true)
        $resultData = json_decode($response, true);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Busca via Stream Context (Busca no servidor)</h2>
    <p>O PHP pode agir como o "Navegador", conectando-se a outros serviços (Stripe, Twilio) a partir do backend de forma privada.</p>
</div>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;">Buscar Endpoint HTTPS Externo Nativamente</button>
</form>

<?php if ($errorLog): ?>
    <div class="error-box"><?= htmlspecialchars($errorLog) ?></div>
<?php endif; ?>

<?php if ($resultData): ?>
    <div class="success-box">
        <h3>Carga Útil Decodificada:</h3>
        <table>
            <tr><th>Identificador</th><td><?= $resultData['id'] ?></td></tr>
            <tr><th>Título do Recurso</th><td><?= htmlspecialchars($resultData['title']) ?></td></tr>
            <tr><th>Corpo do Conteúdo</th><td><?= htmlspecialchars($resultData['body']) ?></td></tr>
        </table>
    </div>
<?php endif; ?>


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