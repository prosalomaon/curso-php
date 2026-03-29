<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 28: View Engines & Global Helpers";

// Function mapping used exclusively in HTML views mapping
function e(?string $text): string {
    return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$maliciousDataAttempt = "<script>alert('Stealing cookies using XSS!');</script>";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The Presentation Layer (Views)</h2>
    <p>Views should never format raw data directly. A global helper like <code>e()</code> ensures we never accidentally leak HTML script nodes to the browser layout.</p>
</div>

<h3>Cross Site Scripting Mitigation Matrix:</h3>
<div style="border:1px solid var(--border-color); padding:10px; margin-bottom:10px;">
    <strong>Raw Attack Output Simulation:</strong><br>
    <code style="color:red;"><?= htmlspecialchars("echo \$maliciousDataAttempt;") ?></code>
</div>

<div class="success-box">
    <strong>Escaped Protection Engine:</strong><br>
    <code>e($maliciousDataAttempt)</code> outputs:<br><br>
    <b style="color:#155724; font-family:monospace;"><?= e($maliciousDataAttempt) ?></b>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>