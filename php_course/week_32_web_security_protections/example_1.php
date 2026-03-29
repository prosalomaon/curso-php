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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>