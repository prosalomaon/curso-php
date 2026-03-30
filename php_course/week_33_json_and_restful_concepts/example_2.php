<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 33 Project: Modular Email System";

interface MailDriver {
    public function transmit(string $body): string;
}

class SmtpDriver implements MailDriver {
    public function transmit(string $b): string { return "[SMTP Server] Sent payload: $b"; }
}

class MailgunApiDriver implements MailDriver {
    public function transmit(string $b): string { return "[Mailgun API HTTP] Posted JSON: $b"; }
}

class NotificationService {
    public function __construct(private MailDriver $mailer) {}
    
    public function alertAdmin(): string {
        return $this->mailer->transmit("SERVER CPU > 95%");
    }
}

$driverChoice = $_POST['driver'] ?? 'smtp';
$log = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Dependency Resolution
    $driver = ($driverChoice === 'api') ? new MailgunApiDriver() : new SmtpDriver();
    
    // 2. Injection!
    $service = new NotificationService($driver);
    
    // 3. Execution
    $log = $service->alertAdmin();
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Hot-Swapping Drivers dynamically</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Select Master Email Transport Engine:</label>
    <div style="display:flex; gap:10px;">
        <select name="driver">
            <option value="smtp">Legacy SMTP Engine (Slow)</option>
            <option value="api">External REST API Protocol (Fast)</option>
        </select>
        <button type="submit" style="white-space:nowrap;">Run Execution</button>
    </div>
</form>

<?php if ($log): ?>
    <div class="success-box">
        <h4>System Action Completed:</h4>
        <code><?= htmlspecialchars($log) ?></code>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.json.php" target="_blank">PHP Manual: JSON &amp; REST</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
header(&#039;Content-Type: application/json&#039;);
echo json_encode([&#039;status&#039; =&gt; &#039;success&#039;, &#039;data&#039; =&gt; []]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>