<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 35 Project: CORS & Rate Limiting";

$codeSim = <<<PHP
// 1. Cross-Origin Resource Sharing (CORS) Map
header("Access-Control-Allow-Origin: https://frontend-vue-app.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 2. Pre-flight OPTIONS request handling (Browsers send this before POSTing)
if (\$_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 3. Rate Limiting Example Constraint (Usually Redis)
\$hits = checkRedisHits(\$_SERVER['REMOTE_ADDR']);
if (\$hits > 60) {
    header("Retry-After: 60");
    http_response_code(429); // Too Many Requests
    echo json_encode(['error' => 'Rate Limit Exceeded.']);
    exit;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>API Infrastructure Security</h2>
    <p>We must manually instruct the browser if a foreign website (like a Vue.js or React app) is legally allowed to fetch data from our PHP server.</p>
</div>

<h3>Secured Gateway Implementation:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>HTTP 429:</strong> Never let users infinite-loop an API request. Implementing Rate Limiting mathematically protects your database from DDoS attacks!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>