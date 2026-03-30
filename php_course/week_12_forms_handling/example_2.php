<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 12 Project: Task Manager Form Construction";

$errors = [];
$title = $_POST['title'] ?? '';
$priority = $_POST['priority'] ?? '1';
$creationSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($title);
    if (mb_strlen($title) < 5) {
        $errors['title'] = 'Architectural Exception: Title length must bridge 5 characters minimum.';
    }

    $priorityInt = filter_input(INPUT_POST, 'priority', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 3]
    ]);
    if ($priorityInt === false) {
        $errors['priority'] = 'System Error: Unauthorized priority flag.';
    }

    if (empty($errors)) {
        $creationSuccess = true;
        $title = ''; 
        $priority = '1';
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Issue Tracker Creation Wizard</h2>
</div>

<?php if ($creationSuccess): ?>
    <div class="success-box">Ticket established and dispatched successfully to the worker queue.</div>
<?php endif; ?>

<form method="POST" class="content-box" style="border:2px dashed var(--border-color);">
    <label>Task Nomenclature:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="e.g. Refactor API controllers">
    <?php if (isset($errors['title'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['title']}</div>"; ?>
    
    <label>Severity Tier:</label>
    <select name="priority">
        <option value="1" <?= $priority === '1' ? 'selected' : '' ?>>Tier 1: Minor (Low)</option>
        <option value="2" <?= $priority === '2' ? 'selected' : '' ?>>Tier 2: Standard (Medium)</option>
        <option value="3" <?= $priority === '3' ? 'selected' : '' ?>>Tier 3: Critical (High)</option>
    </select>
    <?php if (isset($errors['priority'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['priority']}</div>"; ?>

    <button type="submit" style="width:100%;">Create Task Node</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/tutorial.forms.php" target="_blank">PHP Manual: Forms Handling</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$name = filter_input(INPUT_POST, &#039;name&#039;, FILTER_SANITIZE_STRING);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>