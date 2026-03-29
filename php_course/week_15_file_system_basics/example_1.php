<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 15: File Systems, Streams, and Exclusive Locks";

$logFile = __DIR__ . '/audit_temp.log';
$status = null;
$logHistory = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proper File Stream Usage
    $handle = fopen($logFile, 'a'); // Open for appending
    
    if ($handle) {
        // Critical: Using LOCK_EX to prevent File Corruption if 1,000 users hit this instantly!
        if (flock($handle, LOCK_EX)) {
            $msg = sprintf("[%s] Security Ping from User\n", date('H:i:s'));
            fwrite($handle, $msg);
            flock($handle, LOCK_UN); // Release the lock immediately to free up server
            $status = "Audit Log appended safely.";
        } else {
            $status = "CRITICAL ERROR: Failed to acquire file lock.";
        }
        fclose($handle); // Always clean up your handles!
    }
}

// Read logic utilizing memory efficiency
if (file_exists($logFile)) {
    $readHandle = fopen($logFile, 'r');
    if ($readHandle) {
        // fgets reads one line at a time. This prevents RAM exhaustion on a 10GB file!
        while (($line = fgets($readHandle)) !== false) {
            $logHistory[] = trim($line);
        }
        fclose($readHandle);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Native File Streams</h2>
    <p>Using <code>fopen()</code> and <code>flock()</code> guarantees that we never suffer from race conditions under heavy load.</p>
</div>

<?php if ($status): ?>
    <div class="success-box"><?= htmlspecialchars($status) ?></div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit">Ping the Network Audit Log</button>
</form>

<?php if ($logHistory): ?>
    <h3>Live Server Log Tracking:</h3>
    <pre style="background:#000; color:#0f0; padding:15px;">
<?php foreach ($logHistory as $entry): ?>
>> <?= htmlspecialchars($entry) . "\n" ?>
<?php endforeach; ?>
    </pre>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>