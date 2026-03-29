<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 10: Higher-Order Array Functions";

// Raw API Data
$prices = [10.50, 42.00, 5.25, 100.00];

// 1. array_map (Modifying every element) -> Applying $5 Shipping to all
$withShipping = array_map(fn($price) => $price + 5.00, $prices);

// 2. array_filter (Removing elements) -> Keeping only items above $20
$expensiveItems = array_filter($prices, fn($price) => $price > 20.00);

// 3. array_reduce (Boiling down to one value) -> Summing the cart total
$cartTotal = array_reduce($prices, fn($carry, $price) => $carry + $price, 0.0);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Functional Programming Mechanics</h2>
    <p>PHP has incredibly powerful higher-order functions that eliminate the need for writing raw <code>foreach</code> loops manually.</p>
</div>

<table>
    <tr><th>Raw Prices ($)</th><th>Map (+5 Shipping)</th><th>Filter (Only > $20)</th></tr>
    <tr>
        <td><pre><?= htmlspecialchars(print_r($prices, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($withShipping, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($expensiveItems, true)) ?></pre></td>
    </tr>
</table>

<div class="success-box" style="text-align: center;">
    <h3>Final Cart Reduce Total:</h3>
    <h1>$<?= number_format($cartTotal, 2) ?></h1>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>