<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 9: Control Flow (Break & Continue)";

// Network timeout simulation list
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
        $logs[] = "[WARNING] Skipping Server {$req['ip']} - Timeout.";
        continue; // Skip the rest of this singular loop block, move to next!
    }
    
    if ($req['status'] === 'FATAL_KERNEL_PANIC') {
        $logs[] = "[CRITICAL] Entire deployment aborted due to Kernel Panic on {$req['ip']}.";
        break; // Destroys the entire foreach loop instantly!
    }
    
    $logs[] = "[OK] Pinging {$req['ip']} finished in {$req['time']}ms.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Command Structure Breaks</h2>
    <p>Controlling large data loops gracefully.</p>
</div>

<h3>Deployment Engine Output Log:</h3>
<ul style="list-style-type:none; padding:0;">
    <?php foreach ($logs as $logStr): ?>
        <?php
            $color = 'var(--text-color)';
            if (str_contains($logStr, '[WARNING]')) $color = 'orange';
            if (str_contains($logStr, '[CRITICAL]')) $color = 'red';
        ?>
        <li style="color:<?= $color ?>; font-weight:bold; margin-bottom:10px;">
            <?= htmlspecialchars($logStr) ?>
        </li>
    <?php endforeach; ?>
</ul>

<div class="error-box">Notice how <code>192.168.1.5</code> was never pinged because we broke the loop early.</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.functions.php" target="_blank">PHP Manual: Functions</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
function sum(int $a, int $b): int {
    return $a + $b;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>