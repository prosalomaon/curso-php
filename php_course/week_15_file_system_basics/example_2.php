<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 15 Project: Secure Vault Logger Abstraction";

class AppLogger {
    private string $logPath;

    public function __construct(string $directoryName) {
        $this->logPath = __DIR__ . '/' . $directoryName;
        // Self-healing environment
        if (!is_dir($this->logPath)) {
            mkdir($this->logPath, 0700, true);
        }
    }

    public function info(string $message, string $user): void {
        $filePath = $this->logPath . '/vault_activity.log';
        $entry = sprintf("[%s] USER: %s | INFO: %s\n", date('Y-m-d H:i:s'), $user, $message);
        
        // file_put_contents acts as a powerful wrapper for fopen/fwrite/fclose!
        // We pass LOCK_EX via bitwise flag to enforce concurrency safety natively.
        file_put_contents($filePath, $entry, FILE_APPEND | LOCK_EX);
    }
}

$logger = new AppLogger('protected_logs');
$actionsFired = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logger->info("File Download: classified_doc.pdf", "root_admin");
    $logger->info("Permission Modified: User #441", "root_admin");
    $actionsFired = true;
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>File Abstraction Object</h2>
    <p>We abstract messy file functions into clean Objects to use anywhere in the application.</p>
</div>

<?php if ($actionsFired): ?>
    <div class="success-box">
        Log writes completed successfully.<br>
        <strong>Path:</strong> <code>protected_logs/vault_activity.log</code>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;">Execute Batch Vault Commands</button>
</form>

<div class="info-box">
    Instead of writing <code>fopen()</code> twenty times, we simply write <code>$logger->info(...)</code> and the application handles the complex file-locking mechanics.
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/ref.filesystem.php" target="_blank">PHP Manual: File System</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
file_put_contents(&#039;log.txt&#039;, &quot;Error logged!\n&quot;, FILE_APPEND);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>