<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
// We simulate an API Request physically here by intercepting
if (isset($_GET['api']) && $_GET['api'] === 'fetch') {
  ob_end_clean(); // Nuke any HTML output buffering instantly
  header('Content-Type: application/json; charset=utf-8');

  $payload = [
    'metadata' => ['status' => 200, 'timestamp' => time()],
    'data' => [
      ['id' => 10, 'username' => 'sys_admin', 'tier' => 'gold'],
      ['id' => 11, 'username' => 'ghost_user', 'tier' => 'basic']
    ]
  ];

  echo json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
  exit; // STOP ALL EXECUTION SO NO HTML LOADS!
}

$pageTitle = "Week 35: Building JSON APIs";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
  <h2>Rendering pure JSON output natively</h2>
  <p>PHP powers global APIs seamlessly simply by altering Response Headers and halting HTML output.</p>
</div>

<div class="info-box">
  <a href="?api=fetch" style="color:#0c5460; font-weight:bold;">
    [ CLICK HERE TO VIEW API PAYLOAD IN BROWSER ]
  </a>
</div>

<h3>Architecture Required:</h3>
<pre>
header('Content-Type: application/json; charset=utf-8');
echo json_encode($arrayData);
exit;
</pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>