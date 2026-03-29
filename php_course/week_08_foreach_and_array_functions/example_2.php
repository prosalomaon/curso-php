<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 8 Project: HTML Table Visualizer Tool";

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
    <h2>Dynamic Multi-Iteration Matrix Render</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Generate a matrix grid safely up to 20x20:</label>
    <div style="display:flex; gap:10px;">
        <input type="number" name="grid" min="1" max="20" required value="<?= $gridSize ?: 5 ?>">
        <button type="submit" style="white-space:nowrap;">Build Grid Layout</button>
    </div>
</form>

<?php if ($gridSize > 0): ?>
    <h3>Live Render:</h3>
    <table style="text-align:center;">
        <?php for ($row = 1; $row <= $gridSize; $row++): ?>
            <tr>
                <?php for ($col = 1; $col <= $gridSize; $col++): ?>
                    <?php 
                        // Highlighting the diagonal line
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>