<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 39: Cache Busting";

// Configuração simulada
$appVersion = "v2.1.4"; // Incrementar isso força resets de CSS imediatamente de forma global
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Invalidação de Cache no Lado do Cliente</h2>
</div>

<h3>Aplicando Timestamp / Strings de Versão em Ativos Estáticos:</h3>
<pre>
&lt;!-- RUIM: O navegador armazena em cache por 30 dias para sempre! --&gt;
&lt;link rel="stylesheet" href="/style.css"&gt;

&lt;!-- BOM: Usando mapeamento de versão estrutural --&gt;
&lt;link rel="stylesheet" href="/style.css?v=<?= htmlspecialchars($appVersion) ?>"&gt;

&lt;!-- MELHOR: Usando o mapeamento exato do tempo de modificação do arquivo --&gt;
&lt;link rel="stylesheet" href="/style.css?time=<?= filemtime(__DIR__ . '/../style.css') ?>"&gt;
</pre>

<div class="info-box">
    O uso de <code>filemtime()</code> resolve os problemas de cache de CSS/JS de forma elegante. No momento em que você salva o arquivo CSS fisicamente, o número muda, destruindo o cache do navegador do usuário nativamente!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.php" target="_blank">Manual PHP: Arquitetura</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
// Padrões de projeto, Injeção de Dependência
$app = new Application(new Database());
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>