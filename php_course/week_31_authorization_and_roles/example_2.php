<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 31 Project: UUID Generator Array";

// We simulate utilizing 'ramsey/uuid' from packagist
class SimulatedUuid {
    public static function uuid4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

$generated = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 0; $i < 5; $i++) {
        $generated[] = SimulatedUuid::uuid4();
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Third-Party Integration Mockup</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <h3>Generate 5 Random Database Identity Nodes:</h3>
    <button type="submit" style="width:100%;">Execute Generation</button>
</form>

<?php if ($generated): ?>
    <div class="info-box">
        <strong>Instead of basic auto-incrementing integers (1, 2, 3),</strong> modern systems use UUIDs for security to prevent hackers from iterating through user profiles (e.g. <code>/users/4</code>).
    </div>
    
    <ul style="list-style-type:none; padding:0;">
        <?php foreach ($generated as $key => $uuid): ?>
            <li class="content-box" style="margin-bottom:10px; font-family:monospace; font-size:1.2em; border-color:var(--text-color);">
                <strong>[UUID_<?= $key ?>]</strong> <?= htmlspecialchars($uuid) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>