<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 8: Advanced Iterator Loops";

// In real applications, massive DB queries shouldn't be loaded into memory.
// Generators use the `yield` keyword to spit out items efficiently!
function generateCpuSpike(int $limit): Generator {
    for ($i = 1; $i <= $limit; $i++) {
        // Yield pauses exactly here and gives memory to the frontend
        yield $i => rand(1000, 9999);
    }
}

$startMemory = memory_get_usage();
$generator = generateCpuSpike(100);
// At this exact line, PHP hasn't used any memory to hold the 100 random numbers!
$endMemory = memory_get_usage();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Loop Memory Management (The Yield Iterator)</h2>
    <p>If you build an API pulling 5 million records into an array, the server crashes. We loop iterators using <code>yield</code> instead.</p>
</div>

<div class="info-box">
    <strong>Memory Setup Cost:</strong> <?= $endMemory - $startMemory ?> bytes.<br>
    <em>Because the loop hasn't run yet, RAM usage is almost zero!</em>
</div>

<div style="height:200px; overflow-y:scroll; border:1px solid var(--border-color); padding:10px; background:#fff;">
    <?php foreach ($generator as $index => $randomNumber): ?>
        <code>[ID:<?= str_pad((string)$index, 3, '0', STR_PAD_LEFT) ?>] Hash: <?= $randomNumber ?></code><br>
    <?php endforeach; ?>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/ref.array.php" target="_blank">PHP Manual: Array Functions</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$mapped = array_map(fn($x) =&gt; $x * 2, [1, 2, 3]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>