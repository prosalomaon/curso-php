<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 2 Project: Web App Form Challenge";
$message = null;
$error = null;

// Form Handling Logic MUST occur before headers/html
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedAnswer = trim($_POST['answer'] ?? '');
    
    // Strict typing logic evaluation
    if (strtolower($submittedAnswer) === 'elephant') {
        $message = "Correct! The PHP mascot is indeed the elePHPant!";
    } else if (empty($submittedAnswer)) {
        $error = "You left the answer blank!";
    } else {
        $error = "'{$submittedAnswer}' is incorrect. Think gray and heavy.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Interactive Developer Quiz</h2>
    <p>Using <code>$_POST</code> separated entirely from the View template!</p>
</div>

<?php if ($message): ?>
    <div class="success-box"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-box"><strong>Failure:</strong> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label for="answer"><strong>Question:</strong> What animal is the official mascot of the PHP language?</label>
    <input type="text" id="answer" name="answer" placeholder="Type your answer here..." autocomplete="off">
    
    <button type="submit">Validate Answer</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.php" target="_blank">PHP Manual: Variables &amp; Types</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$name = &quot;PHP 8&quot;;
var_dump(is_string($name)); // bool(true)
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>