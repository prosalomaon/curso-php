<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 7: Motor de Dashboard de Analytics";

// Huge dataset representing daily visitors across platforms
$analytics = [
    '2026-10-01' => ['web' => 450, 'ios' => 200, 'android' => 310],
    '2026-10-02' => ['web' => 520, 'ios' => 215, 'android' => 305],
    '2026-10-03' => ['web' => 490, 'ios' => 250, 'android' => 340],
];

// Logic engine to boil it down into actionable insights
$totals = ['web' => 0, 'ios' => 0, 'android' => 0, 'global' => 0];

foreach ($analytics as $date => $metrics) {
    $totals['web'] += $metrics['web'];
    $totals['ios'] += $metrics['ios'];
    $totals['android'] += $metrics['android'];
    
    // Total aggregate for the day
    $totals['global'] += ($metrics['web'] + $metrics['ios'] + $metrics['android']);
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Inteligência de Tráfego Agregada</h2>
    <p>Usando mapeamento multidimensional para resumir terabytes de dados de log.</p>
</div>

<table>
    <thead>
        <tr><th>Timestamp</th><th>Rota Web</th><th>Rota iOS</th><th>Rota Android</th><th>Total do Dia</th></tr>
    </thead>
    <tbody>
        <?php foreach ($analytics as $date => $metrics): ?>
            <?php $dayTotal = array_sum($metrics); ?>
            <tr>
                <td><strong><?= htmlspecialchars($date) ?></strong></td>
                <td><?= $metrics['web'] ?></td>
                <td><?= $metrics['ios'] ?></td>
                <td><?= $metrics['android'] ?></td>
                <td style="font-weight:bold;"><?= $dayTotal ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr style="background:var(--hover-bg);">
            <td><strong>RESUMO TOTAL</strong></td>
            <td><strong><?= $totals['web'] ?></strong></td>
            <td><strong><?= $totals['ios'] ?></strong></td>
            <td><strong><?= $totals['android'] ?></strong></td>
            <td style="color:var(--text-color); font-size:1.2em;"><strong><?= $totals['global'] ?></strong></td>
        </tr>
    </tfoot>
</table>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/control-structures.foreach.php" target="_blank">Manual do PHP: Laços de Repetição</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
foreach($users as $id =&gt; $name) {
    echo &quot;Usuário $id: $name&quot;;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>