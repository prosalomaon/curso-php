<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 8: Gerador de Tabela de Multiplicação Pro";

$limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT) ?: 5;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Visualizador de Algoritmos Matemáticos</h2>
    <form method="GET">
        <label>Alterar tamanho da grade (Max 15):</label>
        <input type="number" name="limit" value="<?= $limit ?>" min="1" max="15">
        <button type="submit">Regerar Grade</button>
    </form>
</div>

<?php if ($limit > 0): ?>
    <table>
        <?php for ($row = 1; $row <= $limit; $row++): ?>
            <tr>
                <?php for ($col = 1; $col <= $limit; $col++): ?>
                    <?php 
                        $val = $row * $col;
                        $bg = ($row === $col) ? 'var(--hover-bg)' : 'transparent';
                        $color = ($row === $col) ? 'var(--text-color)' : 'inherit';
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