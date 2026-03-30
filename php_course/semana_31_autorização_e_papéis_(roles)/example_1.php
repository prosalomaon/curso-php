<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 31: Ecossistema Composer (Gerenciador de Pacotes)";

$terminalSimulation = <<<BASH
> composer init
  Criando ./composer.json

> composer require ramsey/uuid
  Baixando 100%
  Gerando vendor/autoload.php

> php index.php
  Sistema Carregado.
BASH;

$composerJson = <<<JSON
{
    "name": "etec/php-profissional",
    "description": "Projeto Final: Do Zero ao Senior",
    "require": {
        "php": "^8.2",
        "guzzlehttp/guzzle": "^7.8",
        "vlucas/phpdotenv": "^5.6"
    },
    "autoload": {
        "psr-4": {
            "App\\\\": "src/"
        }
    }
}
JSON;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>O Paradigma <code>vendor/autoload.php</code></h2>
    <p>Não precisamos mais escrever <code>require_once 'classe.php'</code> cinquenta vezes por arquivo. O Composer verifica automaticamente nossas pastas e carrega as classes de forma idêntica ao <code>npm</code> do Node.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Simulação de CLI</h3>
        <pre><?= htmlspecialchars($terminalSimulation) ?></pre>
    </div>
    <div style="flex:1;">
        <h3>Configuração <code>composer.json</code></h3>
        <pre><?= htmlspecialchars($composerJson) ?></pre>
    </div>
</div>

<div class="success-box">
    Ao executar <code>require 'vendor/autoload.php';</code> no topo do seu <code>index.php</code>, absolutamente todas as classes dentro do seu diretório <code>src/</code> tornam-se disponíveis globalmente de forma automática com base nas regras PSR-4!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.sessions.php" target="_blank">Manual PHP: Autorização e Papéis</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
if (!in_array(&#039;admin&#039;, $_SESSION[&#039;roles&#039;])) {
    http_response_code(403);
    die(&#039;Proibido&#039;);
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>