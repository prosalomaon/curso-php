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

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.string.php" target="_blank">PHP Manual: Strings</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$greeting = sprintf(&quot;Hello, %s!&quot;, $user);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>