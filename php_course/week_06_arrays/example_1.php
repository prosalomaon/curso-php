<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 6: Complex Arrays & Deconstruction";

$frameworks = ['Laravel', 'Symfony', 'CodeIgniter'];
$authConfig = [
    'driver' => 'JWT',
    'lifetime' => 7200,
    'secure' => true,
    'routes' => ['/api/user', '/api/admin']
];

// PHP 7.1+ Array Destructuring! Very clean syntax.
[$fw1, $fw2] = $frameworks;

// Associative Destructuring
['driver' => $drv, 'lifetime' => $lt] = $authConfig;

// PHP 7.4+ Spread Operator (...)
$newFrameworks = ['Phalcon', ...$frameworks, 'Slim'];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Modern Array Architecture</h2>
    <p>Arrays are foundational in PHP. Let's look at advanced destructuring.</p>
</div>

<h3>List Assignment Destructuring:</h3>
<div class="success-box">
    Grabbed directly off the array memory layout:<br>
    <strong>Primary:</strong> <?= htmlspecialchars($fw1) ?> <br>
    <strong>Secondary:</strong> <?= htmlspecialchars($fw2) ?> 
</div>

<h3>Extracted Map Variables:</h3>
<p>Variables <code>$drv</code> and <code>$lt</code> created instantly from the hash map keys:</p>
<ul>
    <li>Driver Engine: <strong><?= htmlspecialchars($drv) ?></strong></li>
    <li>Session Lifetime: <strong><?= htmlspecialchars((string)$lt) ?>s</strong></li>
</ul>

<h3>Array Spread Merging (...):</h3>
<pre><?= htmlspecialchars(print_r($newFrameworks, true)) ?></pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>