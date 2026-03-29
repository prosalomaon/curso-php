<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 30: Authentication State Checks";

// Simulated Database Data
$dbHashRecord = password_hash("CorrectH0rseBatteryStaple!", PASSWORD_DEFAULT, ['cost' => 10]);

// Simulated Form Data
$simulatedLoginAttempt = "CorrectH0rseBatteryStaple!";

$authGranted = password_verify($simulatedLoginAttempt, $dbHashRecord);

$rehashRequired = password_needs_rehash($dbHashRecord, PASSWORD_DEFAULT, ['cost' => 12]);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Verifying Hashes and Upgrading Salts</h2>
    <p>Since we extract salt hashes natively inside the BCRYPT text block, <code>password_verify()</code> can compare a raw string with an encrypted string mathematically.</p>
</div>

<?php if ($authGranted): ?>
    <div class="success-box">
        <h4>Verification Check Passed Gracefully!</h4>
        <p>The strings mathematically match using the correct internal cryptographic algorithms.</p>
    </div>
    
    <?php if ($rehashRequired): ?>
        <div class="info-box">
            <strong>System Tuning:</strong> The database hash was generated using older <code>cost 10</code>. The system is automatically upgrading the hash to <code>cost 12</code> natively in the background and updating the database!
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="error-box">Critical Security Failure. Payload manipulation detected.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>