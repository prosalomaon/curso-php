<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 8: Loops de Iteradores Avançados";

// Em aplicações reais, consultas massivas de banco de dados não devem ser carregadas na memória.
// Generadores usam a palavra-chave `yield` para cuspir itens de forma eficiente!
function generateCpuSpike(int $limit): Generator {
    for ($i = 1; $i <= $limit; $i++) {
        // O Yield faz uma pausa exatamente aqui e libera memória para o frontend
        yield $i => rand(1000, 9999);
    }
}

$startMemory = memory_get_usage();
$generator = generateCpuSpike(100);
// At this exact line, PHP hasn't used any memory to hold the 100 random numbers!
$endMemory = memory_get_usage();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Gerenciamento de Memória de Loop (O Iterador Yield)</h2>
    <p>Se você construir uma API puxando 5 milhões de registros para um array, o servidor trava. Percorremos iteradores usando <code>yield</code> em vez disso.</p>
</div>

<div class="info-box">
    <strong>Custo de Configuração de Memória:</strong> <?= $endMemory - $startMemory ?> bytes.<br>
    <em>Como o loop ainda não rodou, o uso de RAM é quase zero!</em>
</div>

<div style="height:200px; overflow-y:scroll; border:1px solid var(--border-color); padding:10px; background:#fff;">
    <?php foreach ($generator as $index => $randomNumber): ?>
        <code>[ID:<?= str_pad((string)$index, 3, '0', STR_PAD_LEFT) ?>] Hash: <?= $randomNumber ?></code><br>
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