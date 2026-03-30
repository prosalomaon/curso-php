<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 5: Escopos, Referências e Estáticos";

$counterData = [];

// Variáveis estáticas LEMBRAM seu estado entre chamadas de função dentro da mesma execução de script!
function incrementCounter(string $label): int {
    static $calls = 0; 
    $calls++;
    return $calls;
}

// Usar referências (&) permite modificar variáveis diretamente na memória!
$globalTitle = "App Name";
function renameApp(string &$appRef, string $newName): void {
    $appRef = strtoupper($newName); 
}

$counterData[] = "Chamada 1 -> Retornou: " . incrementCounter("X");
$counterData[] = "Chamada 2 -> Retornou: " . incrementCounter("X");
$counterData[] = "Chamada 3 -> Retornou: " . incrementCounter("X");

$before = $globalTitle;
renameApp($globalTitle, "Awesome ETEC Platform");
$after = $globalTitle;

// --- END LOGIC ---
require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Estratégias de Modificação de Memória</h2>
</div>

<h3>Variáveis de Função Estáticas:</h3>
<p>Ao contrário das variáveis locais normais que reiniciam quando a função termina, <code>static</code> lembra seu valor.</p>
<pre>
<?php foreach ($counterData as $log): ?>
<?= htmlspecialchars($log) . "\n" ?>
<?php endforeach; ?>
</pre>

<h3>Passagem por Referência:</h3>
<p>Passar uma variável com <code>&amp;</code> permite que a função altere o espaço de memória da propriedade original.</p>
<table style="width:50%;">
    <tr><th>Estado Antes:</th><td><code><?= htmlspecialchars($before) ?></code></td></tr>
    <tr><th>Estado Depois:</th><td><strong><?= htmlspecialchars($after) ?></strong></td></tr>
</table>

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.control-structures.php" target="_blank">Manual do PHP: Estruturas de Controle</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
if ($age &gt;= 18) {
    echo &#039;Acesso Permitido&#039;;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>