<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 18: Promotion, Destructors, & Typed Props";

class NetworkSocket {
    // 1. Constructor Property Promotion (PHP 8 shortcut!)
    // 2. Readonly Property (PHP 8.1 - assigned once, completely locked forever)
    public function __construct(
        public readonly string $address,
        public readonly int $port,
        private string $privateKey
    ) {
        $this->log("Connecting to {$this->address}:{$this->port}...");
    }

    public function log(string $msg): void {
        echo "<div class='info-box' style='padding:5px; margin-bottom:5px; border-width:1px;'>[CORE] $msg</div>";
    }

    // Automatically spins up when the object RAM is unassigned or script dies!
    public function __destruct() {
        $this->log("Destructor Fired: Gracefully severing {$this->address} socket.");
    }
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Lifecycle and Lockdowns</h2>
    <p>PHP 8 features drastically reduce boilerplate class setups while adding intense <code>readonly</code> security.</p>
</div>

<h3>Application Runtime Stack:</h3>

<?php
// We create the object
$connection = new NetworkSocket('10.5.5.101', 5432, 'super_secret');

// $connection->address = 'hacked_ip'; // Will FATAL CRASH! Readonly block.

// We manually trigger destruction of the object BEFORE the script finishes!
$connection->log("Executing transactions...");
unset($connection);

echo "<p>Execution stack complete.</p>";
?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.visibility.php" target="_blank">PHP Manual: Visibility &amp; Constructors</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
class Service {
    public function __construct(private string $apiKey) {}
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>