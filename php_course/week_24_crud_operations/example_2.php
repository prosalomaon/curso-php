<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 24 Project: Safe Deletion Workflows";

$articleId = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);
$currentUserId = 1; // Simulated session
$log = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $articleId) {
    // Stage 1: Verification Phase Simulation
    $ownerCheckPassed = ($articleId !== 999); // 999 simulates an un-owned article
    
    if (!$ownerCheckPassed) {
        $log = "ERROR: You lack authorization to delete Article #$articleId.";
    } else {
        // Stage 2: Execution Phase Simulation
        $log = "SUCCESS: Article #$articleId and all associated Tags completely wiped from Database.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Enforcing Ownership on DELETE</h2>
    <p>If you don't check <code>WHERE author_id = :uid</code> inside your delete queries, hackers simply change the ID to wipe someone else's data!</p>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCCESS') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($log) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="border-color:red;">
    <label>Select Target Article for Deletion:</label>
    <div style="display:flex; gap:10px;">
        <select name="delete_id">
            <option value="55">Normal Article #55 (Belongs to You)</option>
            <option value="999">Restricted Data #999 (Simulated Hacking Attempt)</option>
        </select>
        <button type="submit" style="background:red;">Execute Permanent Deletion</button>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>