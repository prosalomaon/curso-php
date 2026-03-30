<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 2: Scalar Types & Memory in PHP 8";

$dataTypes = [
    ['type' => 'Integer', 'value' => 404, 'check' => is_int(404)],
    ['type' => 'Float', 'value' => 3.14159, 'check' => is_float(3.14159)],
    ['type' => 'String', 'value' => "Interpolated Data", 'check' => is_string("Interpolated Data")],
    ['type' => 'Boolean', 'value' => true, 'check' => is_bool(true)],
    ['type' => 'Null', 'value' => null, 'check' => is_null(null)]
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Memory Layout and Scalars</h2>
    <p>PHP uses the Zend Engine engine to allocate memory dynamically, but we should enforce strict types in professional codebases to prevent coercion flaws.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Data Type Name</th>
            <th>Raw Script Value</th>
            <th>Strict Type Check Passed?</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataTypes as $var): ?>
        <tr>
            <td><strong><?= htmlspecialchars($var['type']) ?></strong></td>
            <td><code><?= htmlspecialchars(var_export($var['value'], true)) ?></code></td>
            <td><?= $var['check'] ? '<span style="color:green">YES</span>' : '<span style="color:red">NO</span>' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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