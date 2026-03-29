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
<?php require_once __DIR__ . '/../includes/footer.php'; ?>