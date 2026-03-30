<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 22: Advanced PDO Architectures";

// Creating a simulated mock to prevent crashing on missing localhost databases in this demo environment
class SafeMockPDO {
    public function getAttribute($attr) {
        return "STRICT_EXCEPTION_MODE";
    }
}

$dsn = "mysql:host=localhost;dbname=test_db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// $pdo = new PDO($dsn, 'root', '', $options);
$pdo = new SafeMockPDO(); 
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>PHP Data Objects (PDO) Setup</h2>
    <p>Using the legendary Singleton Pattern ensures your app opens exactly 1 connection to your Database per page load, rather than 50!</p>
</div>

<div class="success-box">
    Database Connectivity Configured.<br>
    <strong>Error Mode:</strong> <?= htmlspecialchars($pdo->getAttribute('mock')) ?><br>
    <strong>Fetch Mode:</strong> FETCH_ASSOC (Associative Arrays)
</div>

<div class="info-box">
    <strong>Mandatory Security Check:</strong> <code>PDO::ATTR_EMULATE_PREPARES</code> must be turned <code>false</code> in order to force the actual MySQL engine to prepare the queries natively (Better security against injection).
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdo.connections.php" target="_blank">PHP Manual: PDO Connection</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$pdo = new PDO(&#039;mysql:host=localhost;dbname=test&#039;, &#039;root&#039;, &#039;&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>