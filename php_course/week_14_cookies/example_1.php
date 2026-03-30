<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 14: Cookies and Persistent Tracking";

$cookieName = 'app_theme';
$cookieSetAction = $_POST['theme'] ?? null;
$statusMsg = null;

// Logic execution before Headers are sent!
if ($cookieSetAction) {
    // Passing cookie options as strongly typed array (PHP 7.3+)
    setcookie($cookieName, $cookieSetAction, [
        'expires' => time() + (86400 * 30), // 30 Days mapping
        'path'    => '/',
        'samesite'=> 'Lax'
    ]);
    
    // In order for $_COOKIE to reflect IMMEDIATELY on this exact page load, 
    // we manually inject it into the superglobal array (since the browser hasn't sent it back yet).
    $_COOKIE[$cookieName] = $cookieSetAction; 
    $statusMsg = "Cookie configuration dispatched successfully.";
}

$currentTheme = $_COOKIE[$cookieName] ?? 'light_mode';
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Client-Side Payload Storage (Cookies)</h2>
    <p>Using cookies to offload specific preference trackers without needing database storage per user.</p>
</div>

<?php if ($statusMsg): ?>
    <div class="success-box"><?= htmlspecialchars($statusMsg) ?></div>
<?php endif; ?>

<div class="info-box">
    <strong>Active Client Preference Read:</strong> <code><?= htmlspecialchars($currentTheme) ?></code>
</div>

<form method="POST" class="content-box">
    <h3>Inject Configuration Cookie:</h3>
    <div style="display:flex; gap:10px;">
        <select name="theme">
            <option value="light_mode">Light Matrix (Default)</option>
            <option value="dark_mode">Dark Console</option>
            <option value="cyber_punk">Cyber Protocol</option>
        </select>
        <button type="submit" style="white-space:nowrap;">Deploy Tracker</button>
    </div>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.cookies.php" target="_blank">PHP Manual: Cookies</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
setcookie(&#039;theme&#039;, &#039;dark&#039;, time() + 3600, &#039;/&#039;, &#039;&#039;, true, true);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>