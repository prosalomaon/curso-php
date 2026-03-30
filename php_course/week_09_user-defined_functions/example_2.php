<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 9 Project: Security Search Protocol";

$userDatabase = [
    'alice@example.com', 'admin@example.com', 'bob@example.com', 
    'charlie@example.com', 'malory@example.com'
];

$searchTerm = $_POST['email'] ?? '';
$searchResult = null;
$searchedPaths = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    foreach ($userDatabase as $index => $email) {
        $searchedPaths++; // Keep track of how many rows we looked at
        
        if ($email === $searchTerm) {
            $searchResult = "FOUND User ID #$index for $email";
            break; // IMMEDIATE OPTIMIZATION. Don't check the rest of the array!
        }
    }
    if (!$searchResult) $searchResult = "FAILED: User $searchTerm not found.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Optimized Array Searching</h2>
    <p>Using <code>break</code> to prevent unnecessary CPU cycles in search protocols.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Find specific User Email (Bob, Alice, Admin...):</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="email" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Run Database Check</button>
    </div>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <?php if (str_starts_with($searchResult, 'FOUND')): ?>
        <div class="success-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php else: ?>
        <div class="error-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php endif; ?>
    
    <div class="info-box">
        <strong>Engine Metrics:</strong> Searched exactly <strong><?= $searchedPaths ?></strong> rows before stopping algorithm execution.<br>
        <em>If we didn't use break, it would have scanned all 5 rows every time!</em>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.functions.php" target="_blank">PHP Manual: Functions</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
function sum(int $a, int $b): int {
    return $a + $b;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>