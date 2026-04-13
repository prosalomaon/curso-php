<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 4: Tipagem Avançada e Funções";

/**
 * Calcula um desconto. Impõe tipos fortemente.
 * Usando Union Types (int|float) disponível desde o PHP 8.
 */
function applyDiscount(float|int $price, float $discountRate): float {
    if ($price < 0 || $discountRate < 0) {
        throw new InvalidArgumentException("Preços e taxas não podem ser negativos.");
    }
    return $price - ($price * $discountRate);
}

// Data Array for Views
$products = [
    ['name' => 'Servidor Corporativo', 'original' => 1500, 'rate' => 0.15],
    ['name' => 'Teclado Mecânico', 'original' => 200, 'rate' => 0.05],
    ['name' => 'E-Book de Algoritmos', 'original' => 45, 'rate' => 0.50],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Tipos de União e Matemática Estrita</h2>
    <p>O uso de <code>declare(strict_types=1)</code> garante que não haja passagem acidental de `"150"` (string) em vez de `150` (int) na pilha da aplicação.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Hardware / Ativo</th>
            <th>Preço Original</th>
            <th>Desconto Aplicado</th>
            <th>Custo Final</th>
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
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.string.php" target="_blank">Manual do PHP: Strings</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$greeting = sprintf(&quot;Olá, %s!&quot;, $user);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>