<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 5: Scopes, References, and Statics";

$counterData = [];

// Static variables REMEMBER their state across function calls within the same script execution!
function incrementCounter(string $label): int {
    static $calls = 0; 
    $calls++;
    return $calls;
}

// Using references (&) allows modifying variables directly in memory!
$globalTitle = "App Name";
function renameApp(string &$appRef, string $newName): void {
    $appRef = strtoupper($newName); 
}

$counterData[] = "Call 1 -> Returned: " . incrementCounter("X");
$counterData[] = "Call 2 -> Returned: " . incrementCounter("X");
$counterData[] = "Call 3 -> Returned: " . incrementCounter("X");

$before = $globalTitle;
renameApp($globalTitle, "Awesome ETEC Platform");
$after = $globalTitle;

// --- END LOGIC ---
require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Memory Modification Strategies</h2>
</div>

<h3>Static Function Variables:</h3>
<p>Unlike normal local variables which reset when the function ends, <code>static</code> remembers its value.</p>
<pre>
<?php foreach ($counterData as $log): ?>
<?= htmlspecialchars($log) . "\n" ?>
<?php endforeach; ?>
</pre>

<h3>Passing by Reference:</h3>
<p>Passing a variable with <code>&amp;</code> allows the function to mutate the original property memory space.</p>
<table style="width:50%;">
    <tr><th>State Before:</th><td><code><?= htmlspecialchars($before) ?></code></td></tr>
    <tr><th>State After:</th><td><strong><?= htmlspecialchars($after) ?></strong></td></tr>
</table>

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