<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 1 Project: Dynamic Bio Page";

// Initializing state for our frontend app
$profile = [
    'name' => 'Jane Doe',
    'profession' => 'Senior Backend Engineer',
    'skills' => ['PHP 8', 'Architecture', 'CSS Design', 'Database Modeling'],
    'available_for_hire' => true
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2 style="font-size: 2em; margin-bottom: 0;"><?= htmlspecialchars($profile['name']) ?></h2>
    <p style="text-transform: uppercase; font-weight: bold; color: #555;"><?= htmlspecialchars($profile['profession']) ?></p>
    <hr>
    
    <h3>Core Competencies:</h3>
    <ul>
        <?php foreach ($profile['skills'] as $skill): ?>
            <li><?= htmlspecialchars($skill) ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($profile['available_for_hire']): ?>
        <div class="success-box">
            <strong>Open to Work:</strong> Currently accepting new architectural contracts.
        </div>
    <?php else: ?>
        <div class="error-box">
            <strong>Unavailable:</strong> Currently fully booked on major projects.
        </div>
    <?php endif; ?>
</div>

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/install.php" target="_blank">PHP Manual: Installation &amp; Environment</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
phpinfo();
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>