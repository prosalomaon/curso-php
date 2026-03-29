<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 7 Project: Analytics Dashboard Engine";

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
    <h2>Aggregated Traffic Intelligence</h2>
    <p>Using multi-dimensional mapping to summarize terabytes of log data.</p>
</div>

<table>
    <thead>
        <tr><th>Timestamp</th><th>Web Route</th><th>iOS Route</th><th>Android Route</th><th>Day Total</th></tr>
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
            <td><strong>TOTAL SUMMARY</strong></td>
            <td><strong><?= $totals['web'] ?></strong></td>
            <td><strong><?= $totals['ios'] ?></strong></td>
            <td><strong><?= $totals['android'] ?></strong></td>
            <td style="color:var(--text-color); font-size:1.2em;"><strong><?= $totals['global'] ?></strong></td>
        </tr>
    </tfoot>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>