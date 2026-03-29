<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 37 Project: Deployment Architectures";

// Conceptual representation
$deployFlow = <<<BASH
#!/bin/bash
# 1. Pull the latest code architecture securely
git pull origin main

# 2. Rebuild the Composer dependency injection
composer install --no-dev --optimize-autoloader

# 3. Synchronize database tables to exact migrations mapping
php artisan migrate --force

# 4. Cache Configurations natively for massive speed boost
php artisan config:cache

# 5. Flush external OPCACHE engine
systemctl reload php-fpm
BASH;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Zero-Downtime Deployment Lifecycle</h2>
    <p>Pushing code via FTP is obsolete. We deploy utilizing specialized server-level scripts representing absolute consistency.</p>
</div>

<h3>Production Shell Script Hook</h3>
<pre><?= htmlspecialchars($deployFlow) ?></pre>

<div class="info-box">
    <strong>Composer Flag:</strong> The <code>--no-dev</code> restricts the server from downloading testing packages (like PHPUnit), keeping the footprint extremely fast and isolated strictly to business logic!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>