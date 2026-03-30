<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 11: Deep Dive into Superglobals";

$serverData = [
    'IP Address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
    'User Agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown CLI',
    'HTTP Method' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
    'Request URI' => $_SERVER['REQUEST_URI'] ?? '/'
];

// Always sanitize GET before dumping it into HTML!
$cleanQuery = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Environment State via <code>$_SERVER</code></h2>
    <p>PHP automatically builds a massive associative array containing everything about the current web request.</p>
</div>

<table>
    <thead><tr><th>Property Name</th><th>Detected Value</th></tr></thead>
    <tbody>
        <?php foreach ($serverData as $key => $val): ?>
            <tr><td><strong><?= htmlspecialchars($key) ?></strong></td><td><code><?= htmlspecialchars($val) ?></code></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="content-box">
    <h3>Safe Search Filter (<code>$_GET</code>)</h3>
    <form method="GET" style="display:flex; gap:10px;">
        <input type="text" name="q" value="<?= $cleanQuery ?>" placeholder="Try passing <script>alert(1)</script>">
        <button type="submit" style="white-space:nowrap;">Search Action</button>
    </form>
    
    <?php if ($cleanQuery): ?>
        <p>You safely searched for: <strong><?= $cleanQuery ?></strong></p>
    <?php endif; ?>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.variables.superglobals.php" target="_blank">PHP Manual: Superglobals</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
var_dump($_SERVER[&#039;HTTP_HOST&#039;]);
var_dump($_GET[&#039;id&#039;] ?? 1);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>