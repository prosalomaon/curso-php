<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
// We simulate cross-request global state using Sessions!
session_start();

$pageTitle = "Week 5 Project: Advanced Session Scoping Matrix";

// Setup state
if (!isset($_SESSION['player_score'])) {
    $_SESSION['player_score'] = 0;
}

$action = $_POST['action'] ?? '';

if ($action === 'score') {
    $_SESSION['player_score'] += 10;
} elseif ($action === 'reset') {
    $_SESSION['player_score'] = 0;
}

$currentScore = $_SESSION['player_score'];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Persistent Scoping Server</h2>
    <p>PHP scripts die when the page loads. To keep data alive globally across requests, we hook into <code>$_SESSION</code>.</p>
</div>

<div class="info-box" style="text-align: center;">
    <h3>CURRENT APPLICATION STATE:</h3>
    <h1 style="font-size: 4em; margin:10px 0; color:var(--text-color);"><?= htmlspecialchars((string)$currentScore) ?></h1>
    <p>Your session ID: <code><?= htmlspecialchars(session_id()) ?></code></p>
</div>

<div style="display:flex; gap:10px; justify-content:center;">
    <form method="POST">
        <input type="hidden" name="action" value="score">
        <button type="submit" style="background:#155724; border-color:#155724;">+10 Score Points</button>
    </form>
    
    <form method="POST">
        <input type="hidden" name="action" value="reset">
        <button type="submit" style="background:#721c24; border-color:#721c24;">Hard Reset Core</button>
    </form>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.control-structures.php" target="_blank">PHP Manual: Control Structures</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
if ($age &gt;= 18) {
    echo &#039;Access Granted&#039;;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>