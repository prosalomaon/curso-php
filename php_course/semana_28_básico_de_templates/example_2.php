<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 28: Wrappers de Layout Mestre (Master Layout)";

$outputBufferingCode = <<<PHP
// 1. Pausar a saída da tela do navegador explicitamente
ob_start();

// 2. Carregar os dados da página nativamente (ex: login_form.php)
require 'views/' . \$viewName . '.php';

// 3. Despejar o buffer em uma variável de string
\$content = ob_get_clean();

// 4. Injetá-lo no Frame do Layout Mestre
require 'layouts/master.php'; 
// (Dentro de master.php, simplesmente escrevemos: <?=\$content?> no centro do HTML)
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Interceptação de Buffer de Saída (Output Buffering)</h2>
    <p>Como um framework renderiza o mesmo cabeçalho e rodapé globalmente sem precisar literalmente copiar e colar <code>require 'header.php'</code> em cada arquivo? Usando o poderoso sistema <code>ob_start()</code>.</p>
</div>

<h3>Script de Injeção de Renderizador Interno:</h3>
<pre><?= htmlspecialchars($outputBufferingCode) ?></pre>

<div class="info-box">
    <strong>Nota:</strong> Atualmente estamos utilizando uma versão básica disso internamente na pasta <code>php_course</code> para impor nosso design Preto e Branco!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.basic-syntax.phpmode.php" target="_blank">Manual PHP: Templates</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;h1&gt;&lt;?= htmlspecialchars($title) ?&gt;&lt;/h1&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>