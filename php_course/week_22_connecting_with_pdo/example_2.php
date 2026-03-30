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


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdo.connections.php" target="_blank">PHP Manual: PDO Connection</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$pdo = new PDO(&#039;mysql:host=localhost;dbname=test&#039;, &#039;root&#039;, &#039;&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>