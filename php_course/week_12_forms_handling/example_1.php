<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 12: Advanced Forms and Validation";

$errors = [];
$successMessage = '';
$submittedData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Validate Email rigorously
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors['email'] = 'A mathematically valid email structure is strictly required.';
    }

    // 2. Validate Age range
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 18, 'max_range' => 120]
    ]);
    if ($age === false) {
        $errors['age'] = 'Access restricted: You must provide a valid integer between 18 and 120.';
    }

    // 3. Evaluate state
    if (empty($errors)) {
        $successMessage = "Database Insert Simulation Successful!";
        $submittedData = ['email' => $email, 'age' => $age];
        
        // In reality, implement PRG (Post-Redirect-Get): 
        // header("Location: ?success=1"); exit;
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Secure Data Extraction Pipeline</h2>
    <p>Never trust user input. Ensure data strictly matches system constraints before allowing Database touches.</p>
</div>

<?php if ($successMessage): ?>
    <div class="success-box">
        <h4><?= htmlspecialchars($successMessage) ?></h4>
        <p><strong>Payload Secured:</strong> <?= htmlspecialchars($submittedData['email']) ?> (Age: <?= $submittedData['age'] ?>)</p>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <div style="margin-bottom:15px;">
        <label>Operator Email Address:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="off">
        <?php if (isset($errors['email'])) echo "<div style='color:red; font-size:0.9em;'>{$errors['email']}</div>"; ?>
    </div>
    
    <div style="margin-bottom:15px;">
        <label>Operator Age Component:</label>
        <input type="number" name="age" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">
        <?php if (isset($errors['age'])) echo "<div style='color:red; font-size:0.9em;'>{$errors['age']}</div>"; ?>
    </div>
    
    <button type="submit">Execute Insertion Payload</button>
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