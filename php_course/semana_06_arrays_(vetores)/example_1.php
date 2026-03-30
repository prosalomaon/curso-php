<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 6: Arrays Complexos & Desestruturação";

$frameworks = ['Laravel', 'Symfony', 'CodeIgniter'];
$authConfig = [
    'driver' => 'JWT',
    'lifetime' => 7200,
    'secure' => true,
    'routes' => ['/api/user', '/api/admin']
];

// Desestruturação de Array do PHP 7.1+! Sintaxe muito limpa.
[$fw1, $fw2] = $frameworks;

// Associative Destructuring
['driver' => $drv, 'lifetime' => $lt] = $authConfig;

// PHP 7.4+ Spread Operator (...)
$newFrameworks = ['Phalcon', ...$frameworks, 'Slim'];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Arquitetura Moderna de Arrays</h2>
    <p>Arrays são fundamentais no PHP. Vamos olhar para a desestruturação avançada.</p>
</div>

<h3>Desestruturação de Atribuição de Lista:</h3>
<div class="success-box">
    Capturado diretamente do layout de memória do array:<br>
    <strong>Primário:</strong> <?= htmlspecialchars($fw1) ?> <br>
    <strong>Secundário:</strong> <?= htmlspecialchars($fw2) ?> 
</div>

<h3>Variáveis de Mapa Extraídas:</h3>
<p>Variáveis <code>$drv</code> e <code>$lt</code> criadas instantaneamente a partir das chaves do mapa:</p>
<ul>
    <li>Motor de Driver: <strong><?= htmlspecialchars($drv) ?></strong></li>
    <li>Tempo de Vida da Sessão: <strong><?= htmlspecialchars((string)$lt) ?>s</strong></li>
</ul>

<h3>Mesclagem de Array Spread (...):</h3>
<pre><?= htmlspecialchars(print_r($newFrameworks, true)) ?></pre>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.array.php" target="_blank">Manual do PHP: Arrays (Vetores)</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
// Desestruturação
[$driver, $port] = [&#039;mysql&#039;, 3306];
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>