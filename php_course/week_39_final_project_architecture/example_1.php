<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 39: Aggressive Application Caching";

// File Cache Simulation Engine
$cacheFile = __DIR__ . '/api_cache.json';
$cacheValidForSeconds = 30; 

$wasCached = false;
$apiData = [];

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheValidForSeconds) {
    // 1. Pull directly from Cache. Avoid Database entirely!
    $cachedData = file_get_contents($cacheFile);
    $apiData = json_decode($cachedData, true);
    $wasCached = true;
} else {
    // 2. Cache Expired! Re-calculate logic heavily.
    // Simulating heavy query logic (e.g. JOINing 5 tables)
    sleep(1); 
    
    $apiData = [
        'generated_at' => date('H:i:s'),
        'total_active_users' => 45000,
        'sales_volume' => 125000.50
    ];
    
    // 3. Save to Cache File for next visitor
    file_put_contents($cacheFile, json_encode($apiData));
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Bypassing CPU Cost Execution (Memoization)</h2>
    <p>By outputting database aggregations to a physical JSON file (or Redis Memory), the next 10,000 users load the site instantly rather than killing the Database!</p>
</div>

<div style="display:flex; justify-content:space-between; align-items:center; background:#f4f4f4; padding:20px; border-radius:5px;">
    
    <div style="text-align:center;">
        <h1 style="<?= $wasCached ? 'color:green;' : 'color:red;' ?>">
            <?= $wasCached ? '⚡ CACHE HIT (0.01s)' : '🐢 CACHE MISS/EXPIRED (1.10s)' ?>
        </h1>
        <p>Refresh the page multiple times to observe the caching behavior automatically resolving to files.</p>
    </div>
    
    <div>
        <h3>Data Node Retrieved:</h3>
        <pre><?= htmlspecialchars(print_r($apiData, true)) ?></pre>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>