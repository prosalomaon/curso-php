<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 1: Página de Bio Dinâmica";

// Initializing state for our frontend app
$profile = [
    'name' => 'Jane Doe',
    'profession' => 'Engenheira Backend Sênior',
    'skills' => ['PHP 8', 'Arquitetura', 'CSS Design', 'Modelagem de Dados'],
    'available_for_hire' => true
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2 style="font-size: 2em; margin-bottom: 0;"><?= htmlspecialchars($profile['name']) ?></h2>
    <p style="text-transform: uppercase; font-weight: bold; color: #555;"><?= htmlspecialchars($profile['profession']) ?></p>
    <hr>
    
    <h3>Competências Principais:</h3>
    <ul>
        <?php foreach ($profile['skills'] as $skill): ?>
            <li><?= htmlspecialchars($skill) ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($profile['available_for_hire']): ?>
        <div class="success-box">
            <strong>Disponível para Trabalho:</strong> Atualmente aceitando novos contratos de arquitetura.
        </div>
    <?php else: ?>
        <div class="error-box">
            <strong>Indisponível:</strong> Atualmente com a agenda lotada em grandes projetos.
        </div>
    <?php endif; ?>
</div>

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