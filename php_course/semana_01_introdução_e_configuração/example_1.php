<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 1: Sintaxe & Arquitetura PHP";
$systemVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown CLI';
$currentDate = date('Y-m-d H:i:s');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Bem-vindo ao Ambiente Profissional</h2>
    <p>O PHP nos dá uma flexibilidade incrível para interagir com a configuração do servidor dinamicamente.</p>
</div>

<div class="info-box">
    <strong>Propriedades do Sistema Carregadas Separadamente:</strong>
    <ul>
        <li><strong>Versão do Motor PHP:</strong> <?= htmlspecialchars($systemVersion) ?></li>
        <li><strong>Servidor Web:</strong> <?= htmlspecialchars($serverSoftware) ?></li>
        <li><strong>Timestamp de Execução:</strong> <?= htmlspecialchars($currentDate) ?></li>
    </ul>
</div>

<p><em>Veja como este código-fonte é limpo comparado às instruções echo legadas!</em></p>

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/install.php" target="_blank">Manual do PHP: Instalação e Ambiente</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
phpinfo();
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>