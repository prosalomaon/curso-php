<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 27: The Front Controller & Dynamic Routing";

// Extract URI from the server map
$mockUri = '/user/edit/88'; // $_SERVER['REQUEST_URI']
$mockMethod = 'POST'; // $_SERVER['REQUEST_METHOD']

// 1. Defining route mapping
$routeEngineMap = [
    'GET /user/edit/{id}' => 'UserController@showEditForm',
    'POST /user/edit/{id}' => 'UserController@saveChanges',
];

$matchedAction = null;

// 2. Simple regex abstraction matcher
if (preg_match('#^/user/edit/(\d+)$#', $mockUri, $matches) && $mockMethod === 'POST') {
    $matchedAction = "Triggering Controller: [UserController], executing [saveChanges], passing Parameter Data: [" . $matches[1] . "]";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Single Entry Architecture (Front Controller)</h2>
    <p>Using `.htaccess` or Nginx, we route every single request (<code>/blog</code>, <code>/contact</code>) to a master <code>index.php</code> script that maps the URI perfectly!</p>
</div>

<div class="info-box">
    <strong>Incoming Client Payload Request:</strong> <code><?= $mockMethod ?> <?= $mockUri ?></code><br>
    <strong>Regex Dispatcher Result:</strong> <?= htmlspecialchars((string)$matchedAction) ?>
</div>

<h3>Defined Application Routes</h3>
<ul>
    <?php foreach ($routeEngineMap as $uri => $controllerString): ?>
        <li><code><strong><?= explode(' ', $uri)[0] ?></strong> <?= explode(' ', $uri)[1] ?></code> &rarr; <code><?= $controllerString ?></code></li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>