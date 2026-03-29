<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 10 Project: Complex Database Filters";

// Simulated complex SQL Joins into an architecture array
$tasks = [
    ['id' => 1, 'priority' => 'high', 'completed' => true, 'tag' => 'auth'],
    ['id' => 2, 'priority' => 'low', 'completed' => false, 'tag' => 'ui'],
    ['id' => 3, 'priority' => 'high', 'completed' => false, 'tag' => 'database'],
    ['id' => 4, 'priority' => 'medium', 'completed' => false, 'tag' => 'auth'],
];

// Chain them: Find all INCOMPLETE tasks, then grab ONLY their TAG names as a clean list!
$pendingTasks = array_filter($tasks, fn($t) => !$t['completed']);
$pendingTags  = array_map(fn($t) => strtoupper($t['tag']), $pendingTasks);

// Make the tags unique using another built in
$uniquePendingTags = array_unique($pendingTags);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Data Pipeline Architecture</h2>
    <p>In highly advanced architectures, we chain filter/map actions to isolate exact data slices from complex structures.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    
    <div class="content-box" style="flex:1;">
        <h3>Original Data Struct:</h3>
        <pre><?= htmlspecialchars(var_export($tasks, true)) ?></pre>
    </div>
    
    <div class="info-box" style="flex:1;">
        <h3>Actionable Pipeline Output:</h3>
        <p>The system needs to know which departments owe work. We filtered completed tasks out, grouped their keys, and removed duplicates instantly natively:</p>
        
        <ul style="margin-top:20px;">
            <?php foreach ($uniquePendingTags as $deptCode): ?>
                <li style="font-weight:bold; color:red; margin-bottom:10px;">
                    WORK PENDING IN MODULE: [<?= htmlspecialchars($deptCode) ?>]
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>