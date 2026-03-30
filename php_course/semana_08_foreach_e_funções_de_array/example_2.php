<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 8: Ferramenta Visualizadora de Tabela HTML";

$gridSize = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gridSize = filter_input(INPUT_POST, 'grid', FILTER_VALIDATE_INT) ?: 0;
    // Hard limit to avoid user crashing the PHP script
    $gridSize = min($gridSize, 20); 
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Renderização de Matriz de Multi-Iteração Dinâmica</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Gere uma grade de matriz com segurança até 20x20:</label>
    <div style="display:flex; gap:10px;">
        <input type="number" name="grid" min="1" max="20" required value="<?= $gridSize ?: 5 ?>">
        <button type="submit" style="white-space:nowrap;">Construir Layout de Grade</button>
    </div>
</form>

<?php if ($gridSize > 0): ?>
    <h3>Renderização ao Vivo:</h3>
    <table style="text-align:center;">
        <?php for ($row = 1; $row <= $gridSize; $row++): ?>
            <tr>
                <?php for ($col = 1; $col <= $gridSize; $col++): ?>
                    <?php 
                        // Destacando a linha diagonal
                        $isDiagonal = ($row === $col);
                        $bg = $isDiagonal ? 'var(--text-color)' : 'transparent';
                        $color = $isDiagonal ? 'var(--bg-color)' : 'var(--text-color)';
                    ?>
                    <td style="background:<?= $bg ?>; color:<?= $color ?>; border:1px solid var(--border-color); padding:5px;">
                        <?= $row ?>x<?= $col ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/ref.array.php" target="_blank">Manual do PHP: Funções de Array</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$mapped = array_map(fn($x) =&gt; $x * 2, [1, 2, 3]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>