<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 31: Composer Ecosystem (Package Manager)";

$terminalSimulation = <<<BASH
> composer init
  Creating ./composer.json

> composer require ramsey/uuid
  Downloading 100%
  Generating vendor/autoload.php

> php index.php
  System Loaded.
BASH;

$composerJson = <<<JSON
{
    "name": "etec/professional-php",
    "description": "Zero to Hero Capstone",
    "require": {
        "php": "^8.2",
        "guzzlehttp/guzzle": "^7.8",
        "vlucas/phpdotenv": "^5.6"
    },
    "autoload": {
        "psr-4": {
            "App\\\\": "src/"
        }
    }
}
JSON;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The <code>vendor/autoload.php</code> Paradigm</h2>
    <p>We no longer manually write <code>require_once 'class.php'</code> fifty times per file. Composer automatically scans our folders and loads classes identically to Node's <code>npm</code>.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>CLI Simulation</h3>
        <pre><?= htmlspecialchars($terminalSimulation) ?></pre>
    </div>
    <div style="flex:1;">
        <h3><code>composer.json</code> Configuration</h3>
        <pre><?= htmlspecialchars($composerJson) ?></pre>
    </div>
</div>

<div class="success-box">
    By running <code>require 'vendor/autoload.php';</code> at the very top of your <code>index.php</code>, absolutely every class inside your <code>src/</code> directory becomes globally available automatically based on PSR-4 rules!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>