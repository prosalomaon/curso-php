<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 30 Project: Middleware Guard";

// We simulate middleware natively handling requests!
$mockSessionRole = 'CUSTOMER'; // They purchased items.

// Middleware Controller Pattern Matrix
$canAccessAdmin = false;
$middlewareLog = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mockSessionRole === 'SUPER_ADMIN') {
        $canAccessAdmin = true;
        $middlewareLog = "ACCESS GRANTED: Security gates bypassed successfully for System Admin.";
    } else {
        $middlewareLog = "HTTP 403 FORBIDDEN: Origin Role [" . $mockSessionRole . "] severely lacks the required security node constraints.";
    }
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The Middleware Gateway Shield</h2>
    <p>Controllers should not manually check logic. A specific Middleware layer explicitly executes check states before the Controller is even legally allowed to boot.</p>
</div>

<?php if ($middlewareLog): ?>
    <div class="<?= $canAccessAdmin ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($middlewareLog) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="border-style:dashed;">
    <h3 style="margin-top:0;">Access the E-Commerce Admin Node</h3>
    <p>Target Route: <code>/admin/dashboard</code></p>
    <button type="submit" style="width:100%; <?= $middlewareLog && !$canAccessAdmin ? 'background:red;border-color:red;' : '' ?>">Execute Path Resolution</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>