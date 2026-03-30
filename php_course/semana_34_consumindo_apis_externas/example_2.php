<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 34: Abstração Monolog";

$codeSim = <<<PHP
use Monolog\\Logger;
use Monolog\\Handler\\StreamHandler;

// Criar um pipeline de log central
\$log = new Logger('MecanismoApp');
\$log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::WARNING));

try {
    throw new Exception("Cache completamente desconectado!");
} catch (Exception \$e) {
    // Registra apenas WARNING e superior (ERROR, CRITICAL, EMERGENCY)
    \$log->error("Interrupção do Sistema: " . \$e->getMessage(), [
        'ip' => \$_SERVER['REMOTE_ADDR']
    ]);
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Registro Padronizado (PSR-3)</h2>
    <p>Em vez de <code>file_put_contents()</code> manual, toda a indústria utiliza <code>Monolog</code> para transmitir erros diretamente para o Slack, Disco ou AWS CloudWatch!</p>
</div>

<h3>Código de Implementação:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>Níveis de Log:</strong> DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY. Diferentes manipuladores podem ser anexados simultaneamente (ex: Salvar tudo no disco, mas enviar e-mail para a equipe APENAS em EMERGENCY).
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.curl.php" target="_blank">Manual PHP: APIs Externas (cURL)</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$ch = curl_init(&#039;https://api.github.com/users/octocat&#039;);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>