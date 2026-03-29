<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 11 Project: Task Manager Routing via GET";

// 1. Data Retrieval
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';
$taskId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// 2. Controller Routing
// Using Match to enforce strict architecture over query strings
$outputMessage = match($action) {
    'list'   => "Listing all active tasks in the system...",
    'view'   => $taskId ? "Viewing complex details for Task #{$taskId}" : "Error: Missing Task ID",
    'delete' => $taskId ? "[CRITICAL] Emulating permanent deletion of Task #{$taskId}!" : "Error: Missing Task ID",
    default  => "Unknown route requested: {$action}"
};

$statusClass = str_starts_with($outputMessage, 'Error') ? 'error-box' : (str_starts_with($outputMessage, '[CRITICAL]') ? 'error-box' : 'success-box');

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Query String Controller</h2>
    <p>We use <code>?action=xxx</code> to instruct the PHP file what block of logic to execute, essentially creating a rudimentary API router!</p>
</div>

<div class="<?= $statusClass ?>">
    <strong>Application State:</strong> <?= htmlspecialchars($outputMessage) ?>
</div>

<h3>Simulate Incoming Requests:</h3>
<ul>
    <li><a href="?action=list"><strong>GET</strong> /tasks (List)</a></li>
    <li><a href="?action=view&id=88"><strong>GET</strong> /tasks/88 (View)</a></li>
    <li><a href="?action=delete&id=88"><strong>DELETE</strong> /tasks/88 (Delete)</a></li>
    <li><a href="?action=hax&id=1"><strong>GET</strong> /tasks/hax (Invalid Route)</a></li>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>