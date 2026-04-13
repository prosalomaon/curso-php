<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 8: Algoritmos de Iteração (While vs Do-While)";

$backupNodes = ['Server-A', 'Server-B', 'Server-C'];
$statusLog = [];

// Exemplo While: Tentar até que a condição falhe (pode nunca rodar!)
while (!empty($backupNodes)) {
    $node = array_shift($backupNodes);
    $statusLog[] = "Sincronizando: $node... [CONCLUÍDO]";
}

// Exemplo Do-While: Roda pelo menos UMA VEZ!
$retryCount = 0;
$maxRetries = 3;
do {
    $retryCount++;
    $connectionResult = ($retryCount === 3) ? "ESTABELECIDA" : "FALHA";
    $statusLog[] = "Tentativa de Conexão #$retryCount: $connectionResult";
} while ($connectionResult !== "ESTABELECIDA" && $retryCount < $maxRetries);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Controle de Fluxo de Iteração</h2>
    <p>Escolher o laço correto impacta a segurança e performance da aplicação.</p>
</div>

<div class="info-box" style="font-family:monospace;">
    <?php foreach ($statusLog as $line): ?>
        <?= htmlspecialchars($line) ?><br>
    <?php endforeach; ?>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/ref.array.php" target="_blank">Manual do PHP: Funções de Array</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$mapped = array_map(fn($x) =&gt; $x * 2, [1, 2, 3]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>