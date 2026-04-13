<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 28: Motores de Visualização (View Engines) e Helpers Globais";

// Mapeamento de função usado exclusivamente no mapeamento de visualizações HTML
function e(?string $text): string {
    return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$maliciousDataAttempt = "<script>alert('Roubando cookies usando XSS!');</script>";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>A Camada de Apresentação (Views)</h2>
    <p>As views nunca devem formatar dados brutos diretamente. Um helper global como <code>e()</code> garante que nunca vazemos acidentalmente nós de script HTML para o layout do navegador.</p>
</div>

<h3>Matriz de Mitigação de Cross Site Scripting:</h3>
<div style="border:1px solid var(--border-color); padding:10px; margin-bottom:10px;">
    <strong>Simulação de Saída de Ataque Bruto:</strong><br>
    <code style="color:red;"><?= htmlspecialchars("echo \$maliciousDataAttempt;") ?></code>
</div>

<div class="success-box">
    <strong>Mecanismo de Proteção com Escape:</strong><br>
    <code>e($maliciousDataAttempt)</code> produz:<br><br>
    <b style="color:#155724; font-family:monospace;"><?= e($maliciousDataAttempt) ?></b>
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