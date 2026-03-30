<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 15: Sistemas de Arquivos, Streams e Bloqueios Exclusivos";

$logFile = __DIR__ . '/audit_temp.log';
$status = null;
$logHistory = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proper File Stream Usage
    $handle = fopen($logFile, 'a'); // Open for appending
    
    if ($handle) {
        // Critical: Using LOCK_EX to prevent File Corruption if 1,000 users hit this instantly!
        if (flock($handle, LOCK_EX)) {
            $msg = sprintf("[%s] Security Ping from User\n", date('H:i:s'));
            fwrite($handle, $msg);
            flock($handle, LOCK_UN); // Release the lock immediately to free up server
            $status = "Log de Auditoria anexado com segurança.";
        } else {
            $status = "ERRO CRÍTICO: Falha ao adquirir bloqueio de arquivo.";
        }
        fclose($handle); // Always clean up your handles!
    }
}

// Read logic utilizing memory efficiency
if (file_exists($logFile)) {
    $readHandle = fopen($logFile, 'r');
    if ($readHandle) {
        // fgets reads one line at a time. This prevents RAM exhaustion on a 10GB file!
        while (($line = fgets($readHandle)) !== false) {
            $logHistory[] = trim($line);
        }
        fclose($readHandle);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Streams de Arquivos Nativos</h2>
    <p>O uso de <code>fopen()</code> e <code>flock()</code> garante que nunca soframos de condições de corrida (race conditions) sob carga pesada.</p>
</div>

<?php if ($status): ?>
    <div class="success-box"><?= htmlspecialchars($status) ?></div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit">Pingar o Log de Auditoria da Rede</button>
</form>

<?php if ($logHistory): ?>
    <h3>Rastreamento do Log do Servidor ao Vivo:</h3>
    <pre style="background:#000; color:#0f0; padding:15px;">
<?php foreach ($logHistory as $entry): ?>
>> <?= htmlspecialchars($entry) . "\n" ?>
<?php endforeach; ?>
    </pre>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/ref.filesystem.php" target="_blank">Manual PHP: Sistema de Arquivos</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
file_put_contents(&#039;log.txt&#039;, &quot;Erro registrado!\n&quot;, FILE_APPEND);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>