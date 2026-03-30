<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 9: Fluxo de Controle (Break & Continue)";

// Lista de simulação de timeout de rede
$networkRequests = [
    ['ip' => '192.168.1.1', 'status' => 'success', 'time' => 12],
    ['ip' => '192.168.1.2', 'status' => 'timeout', 'time' => 5000],
    ['ip' => '192.168.1.3', 'status' => 'success', 'time' => 15],
    ['ip' => '10.0.0.99', 'status' => 'FATAL_KERNEL_PANIC', 'time' => 0],
    ['ip' => '192.168.1.5', 'status' => 'success', 'time' => 10], // Won't be reached
];

$logs = [];
foreach ($networkRequests as $req) {
    if ($req['status'] === 'timeout') {
        $logs[] = "[AVISO] Pulando Servidor {$req['ip']} - Timeout.";
        continue; // Pula o resto deste bloco de loop singular, vai para o próximo!
    }
    
    if ($req['status'] === 'FATAL_KERNEL_PANIC') {
        $logs[] = "[CRÍTICO] Implantação total abortada devido a Kernel Panic em {$req['ip']}.";
        break; // Destrói o loop foreach inteiro instantaneamente!
    }
    
    $logs[] = "[OK] Pinging {$req['ip']} concluído em {$req['time']}ms.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Estrutura de Interrupção de Comandos</h2>
    <p>Controlando loops de grandes volumes de dados de forma graciosa.</p>
</div>

<h3>Log de Saída do Motor de Implantação:</h3>
<ul style="list-style-type:none; padding:0;">
    <?php foreach ($logs as $logStr): ?>
        <?php
            $color = 'var(--text-color)';
            if (str_contains($logStr, '[AVISO]')) $color = 'orange';
            if (str_contains($logStr, '[CRÍTICO]')) $color = 'red';
        ?>
        <li style="color:<?= $color ?>; font-weight:bold; margin-bottom:10px;">
            <?= htmlspecialchars($logStr) ?>
        </li>
    <?php endforeach; ?>
</ul>

<div class="error-box">Observe como <code>192.168.1.5</code> nunca foi pingado porque interrompemos o loop antecipadamente.</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.functions.php" target="_blank">Manual do PHP: Funções</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
function soma(int $a, int $b): int {
    return $a + $b;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>