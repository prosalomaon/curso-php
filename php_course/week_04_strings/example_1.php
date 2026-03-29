<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 4: Advanced Typing and Functions";

/**
 * Calculates a discount. Enforces types strongly.
 * Using Union Types (int|float) available since PHP 8.
 */
function applyDiscount(float|int $price, float $discountRate): float {
    if ($price < 0 || $discountRate < 0) {
        throw new InvalidArgumentException("Prices and rates cannot be negative.");
    }
    return $price - ($price * $discountRate);
}

// Data Array for Views
$products = [
    ['name' => 'Enterprise Server', 'original' => 1500, 'rate' => 0.15],
    ['name' => 'Mechanical Keyboard', 'original' => 200, 'rate' => 0.05],
    ['name' => 'Algorithm E-Book', 'original' => 45, 'rate' => 0.50],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Union Types and Strict Math</h2>
    <p>Using <code>declare(strict_types=1)</code> ensures no accidental passing of `"150"` (string) instead of `150` (int) down the application stack.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Hardware / Asset</th>
            <th>Original Price</th>
            <th>Discount Applied</th>
            <th>Final Cost</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
            <td>$<?= number_format((float)$p['original'], 2) ?></td>
            <td><?= $p['rate'] * 100 ?>% OFF</td>
            <td style="color: green; font-weight: bold;">
                $<?= number_format(applyDiscount($p['original'], $p['rate']), 2) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>