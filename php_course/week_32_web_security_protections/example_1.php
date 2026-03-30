<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 32: Namespaces and PSR-4";

$codeSim = <<<PHP
<?php
// File: src/Controllers/UserController.php
namespace App\\Controllers;

use App\\Models\\User; // Imports the specific class from another folder
use App\\Services\\Mailer;

class UserController {
    public function register() {
        \$user = new User(); // PHP knows exactly where this file is!
        \$mail = new Mailer();
        
        // Native PHP classes like DateTime must be preceded by a backslash!
        \$date = new \\DateTime(); 
    }
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Directory Mapping natively (Namespacing)</h2>
    <p>Namespaces solve the problem of having two classes named <code>Controller</code> in the same project. They map directly to your physical folder structure.</p>
</div>

<h3>Namespace Usage:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    Using <code>use</code> at the top of the file prevents the code from becoming messy. Instead of writing <code>$u = new \App\Models\User()</code>, we simply write <code>$u = new User()</code>.
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/security.php" target="_blank">PHP Manual: Web Security</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
// Prevent XSS
$safe = htmlspecialchars($unsafeStr, ENT_QUOTES, &#039;UTF-8&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>