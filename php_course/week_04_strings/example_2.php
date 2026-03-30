<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 4 Project: Custom String Formatter Tool";

$results = null;

/**
 * A utility class-like function generator to clean user text!
 */
function sanitizeAndFormatText(string $rawInput): array {
    $clean = strip_tags(trim($rawInput)); // Security: strip HTML
    return [
        'original' => $rawInput,
        'uppercase' => strtoupper($clean),
        'word_count' => str_word_count($clean),
        'slug' => strtolower(str_replace(' ', '-', $clean))
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['rawText'] ?? '';
    if (!empty($input)) {
        $results = sanitizeAndFormatText($input);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Data Formatting Pipeline</h2>
    <p>Submit any messy string below, and see the engine parse it cleanly via separated functions.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Paste text here (Try adding HTML like &lt;b&gt;):</label>
    <textarea name="rawText" rows="4"></textarea>
    <button type="submit">Process Text</button>
</form>

<?php if ($results): ?>
    <h3>Output Pipeline:</h3>
    <table>
        <tr><th>Original Payload:</th><td><code><?= htmlspecialchars($results['original']) ?></code></td></tr>
        <tr><th>Upper Transformation:</th><td><strong><?= htmlspecialchars($results['uppercase']) ?></strong></td></tr>
        <tr><th>Total Words Parsed:</th><td><?= htmlspecialchars((string)$results['word_count']) ?></td></tr>
        <tr><th>URL Friendly Slug:</th><td><code><?= htmlspecialchars($results['slug']) ?></code></td></tr>
    </table>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.string.php" target="_blank">PHP Manual: Strings</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$greeting = sprintf(&quot;Hello, %s!&quot;, $user);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>