<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 3 Project: Content Security Gate";
$gateStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs via robust filters
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $subscribe = isset($_POST['subscribe']); // Checkbox presence

    if ($age === false) {
        $gateStatus = ['status' => 'error', 'msg' => 'Invalid integer provided for age.'];
    } elseif ($age < 18) {
        $gateStatus = ['status' => 'error', 'msg' => 'Access Denied: You must be 18 or older to view the professional network.'];
    } elseif (!$subscribe) {
        $gateStatus = ['status' => 'info', 'msg' => 'Access Granted, but please consider subscribing to our tech newsletter!'];
    } else {
        $gateStatus = ['status' => 'success', 'msg' => 'Access Granted: Welcome, Pro Member.'];
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Infrastructure Authentication Gate</h2>
    <p>Utilizing compound conditionals and boolean logic securely.</p>
</div>

<?php if ($gateStatus): ?>
    <div class="<?= htmlspecialchars($gateStatus['status']) ?>-box">
        <?= htmlspecialchars($gateStatus['msg']) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <label><strong>Enter your Age:</strong></label>
    <input type="number" name="age" required min="1" max="120">
    
    <div style="margin-bottom: 20px;">
        <input type="checkbox" name="subscribe" id="sub" value="1">
        <label for="sub" style="font-weight:bold;">Opt-in to the Professional Technical Newsletter (Agrees to ToS)</label>
    </div>

    <button type="submit">Attempt Login</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>