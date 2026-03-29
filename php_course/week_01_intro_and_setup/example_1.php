<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 1: PHP Syntax & Architecture";
$systemVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown CLI';
$currentDate = date('Y-m-d H:i:s');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
  <h2>Welcome to the Professional Environment</h2>
  <p>PHP gives us incredible flexibility to interact with server configuration dynamically.</p>
</div>

<div class="info-box">
  <strong>System Properties Loaded Separately:</strong>
  <ul>
    <li><strong>PHP Engine Version:</strong> <?= htmlspecialchars($systemVersion) ?></li>
    <li><strong>Web Server:</strong> <?= htmlspecialchars($serverSoftware) ?></li>
    <li><strong>Execution Timestamp:</strong> <?= htmlspecialchars($currentDate) ?></li>
  </ul>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>