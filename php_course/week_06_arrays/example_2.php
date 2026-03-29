<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 6 Project: Task List Application";

// Simple state
$tasks = [
    'Critical Error Patch',
    'Write Authentication API',
    'Design Login Modal Forms'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['new_task'])) {
    // Sanitize and append
    $safeTask = strip_tags(trim($_POST['new_task']));
    // Prepend to top of array
    array_unshift($tasks, $safeTask);
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Volatile Task Queue</h2>
    <p>Using arrays to track state (Resets on refresh since we aren't using Session or DB yet).</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>New System Feature Request:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="new_task" style="margin-bottom:0;" autocomplete="off" required>
        <button type="submit" style="white-space:nowrap;">Queue Task</button>
    </div>
</form>

<h3>Pending System Queue:</h3>
<ul>
    <?php foreach ($tasks as $index => $item): ?>
    <li style="padding:10px; border-bottom:1px dashed var(--border-color);">
        <code>[ID:<?= $index ?>]</code> <strong><?= htmlspecialchars($item) ?></strong>
    </li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>