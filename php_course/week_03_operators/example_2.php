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


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.operators.php" target="_blank">PHP Manual: Operators</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$result = match(true) {
    $a === $b =&gt; &#039;Strictly Equal&#039;,
    default =&gt; &#039;Different&#039;
};
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>