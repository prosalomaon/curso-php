<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 10: Funções de Array de Ordem Superior";

// Dados Brutos da API
$prices = [10.50, 42.00, 5.25, 100.00];

// 1. array_map (Modificando cada elemento) -> Aplicando $5 de Frete para todos
$withShipping = array_map(fn($price) => $price + 5.00, $prices);

// 2. array_filter (Removendo elementos) -> Mantendo apenas itens acima de $20
$expensiveItems = array_filter($prices, fn($price) => $price > 20.00);

// 3. array_reduce (Resumindo em um único valor) -> Somando o total do carrinho
$cartTotal = array_reduce($prices, fn($carry, $price) => $carry + $price, 0.0);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Mecânica de Programação Funcional</h2>
    <p>O PHP tem funções de ordem superior incrivelmente poderosas que eliminam a necessidade de escrever loops <code>foreach</code> brutos manualmente.</p>
</div>

<table>
    <tr><th>Preços Brutos ($)</th><th>Mapa (+5 Frete)</th><th>Filtro (Apenas > $20)</th></tr>
    <tr>
        <td><pre><?= htmlspecialchars(print_r($prices, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($withShipping, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($expensiveItems, true)) ?></pre></td>
    </tr>
</table>

<div class="success-box" style="text-align: center;">
    <h3>Total Final Reduzido do Carrinho:</h3>
    <h1>$<?= number_format($cartTotal, 2) ?></h1>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/functions.anonymous.php" target="_blank">Manual do PHP: Escopo e Funções Anônimas</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$tax = 0.5;
$calc = function($price) use ($tax) {
    return $price + ($price * $tax);
};
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>