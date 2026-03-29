<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 22 Project: PDO Fetch Abstractions";

class SimulatedStatement {
    public function fetchAll(int $mode = PDO::FETCH_ASSOC): array {
        if ($mode === PDO::FETCH_OBJ) {
            return [(object)['id'=>1, 'title'=>'PDO Engine Architecture']];
        }
        return [['id'=>1, 'title'=>'PDO Engine Architecture']];
    }
}

$stmt = new SimulatedStatement();
$assocOutput = $stmt->fetchAll(PDO::FETCH_ASSOC);
$objOutput = $stmt->fetchAll(PDO::FETCH_OBJ);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Retrieval Format Engine</h2>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Standard Arrays (FETCH_ASSOC)</h3>
        <p>Ultra-fast array hash mapping.</p>
        <pre><?= htmlspecialchars(print_r($assocOutput, true)) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Anonymous Objects (FETCH_OBJ)</h3>
        <p>Cleaner <code>$row->title</code> syntax mapping natively applied.</p>
        <pre><?= htmlspecialchars(print_r($objOutput, true)) ?></pre>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>