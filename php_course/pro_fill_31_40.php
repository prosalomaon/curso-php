<?php
/**
 * Professional PHP Code Populate Tool - Weeks 31 to 40
 * Focus: Advanced Architecture, APIs, Caching, and Enterprise Polish.
 */

$examples = [
  31 => [
    'ex1' => <<<'EOT'
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
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 31 Project: UUID Generator Array";

// We simulate utilizing 'ramsey/uuid' from packagist
class SimulatedUuid {
    public static function uuid4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

$generated = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 0; $i < 5; $i++) {
        $generated[] = SimulatedUuid::uuid4();
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Third-Party Integration Mockup</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <h3>Generate 5 Random Database Identity Nodes:</h3>
    <button type="submit" style="width:100%;">Execute Generation</button>
</form>

<?php if ($generated): ?>
    <div class="info-box">
        <strong>Instead of basic auto-incrementing integers (1, 2, 3),</strong> modern systems use UUIDs for security to prevent hackers from iterating through user profiles (e.g. <code>/users/4</code>).
    </div>
    
    <ul style="list-style-type:none; padding:0;">
        <?php foreach ($generated as $key => $uuid): ?>
            <li class="content-box" style="margin-bottom:10px; font-family:monospace; font-size:1.2em; border-color:var(--text-color);">
                <strong>[UUID_<?= $key ?>]</strong> <?= htmlspecialchars($uuid) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  32 => [
    'ex1' => <<<'EOT'
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
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 32 Project: Namespace Collision Resolution";

// Simulated scenario: You downloaded a PDF library, and it has a 'Logger' class.
// But YOUR app also has a 'Logger' class!

namespace App\Internal {
    class Logger {
        public function __construct() { echo "<li>Internal App Logger Booted</li>"; }
    }
}

namespace Vendor\PDFLibrary {
    class Logger {
        public function __construct() { echo "<li>External Package Logger Booted</li>"; }
    }
}

namespace App\Execution {
    $title = "Namespace Collision Handling";
    
    // We handle logic manually here because of how namespaces isolate execution
    ob_start();
    // Using aliases to fix the exact same Name!
    use App\Internal\Logger as AppLog;
    use Vendor\PDFLibrary\Logger as PdfLog;
    
    $appLogging = new AppLog();
    $pdfLogging = new PdfLog();
    
    $output = ob_get_clean();
    
    // --- TEMPLATE REQUIREMENT WORKAROUND FOR MULTIPLE NAMESPACES --- 
    require_once __DIR__ . '/../includes/header.php';
    echo <<<HTML
    <div class="content-box">
        <h2>Aliasing to prevent Fatal Collisions</h2>
        <p>Using <code>as</code> to rename classes on the fly.</p>
    </div>
    
    <div class="success-box">
        <h3>System Boot Sequence:</h3>
        <ul>{$output}</ul>
    </div>
HTML;
    require_once __DIR__ . '/../includes/footer.php';
}

EOT
  ],
  33 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 33: Dependency Injection (S.O.L.I.D.)";

interface CacheInterface {
    public function set(string $key, $value): void;
    public function getName(): string;
}

class RedisCache implements CacheInterface {
    public function set(string $k, $v): void {}
    public function getName(): string { return "REDIS_IN_MEMORY_DAEMON"; }
}

class MemcachedCache implements CacheInterface {
    public function set(string $k, $v): void {}
    public function getName(): string { return "MEMCACHED_DAEMON"; }
}

// THE WRONG WAY (Hardcoded coupling)
class BadController {
    public function doWork() {
        $cache = new RedisCache(); // Hardcoded! Impossible to unit test with mock data.
    }
}

// THE RIGHT WAY (Injection)
class SecureController {
    private CacheInterface $cache;
    
    // The framework "injects" the cache engine from the outside.
    public function __construct(CacheInterface $cache) {
        $this->cache = $cache;
    }
    
    public function render() {
        return "Controller correctly utilizing: " . $this->cache->getName();
    }
}

$activeDriver = new MemcachedCache();
$controller = new SecureController($activeDriver);
$result = $controller->render();
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Inversion of Control (IoC)</h2>
    <p>Classes should never instantiate their own heavy dependencies (like Databases, Mailers). They should ask for them in their Constructor.</p>
</div>

<div class="success-box">
    <strong>Execution Path:</strong> <?= htmlspecialchars($result) ?>
</div>

<div class="info-box">
    Since <code>SecureController</code> asks for a <code>CacheInterface</code>, we can swap from Memcached to Redis, or even to a fake <code>MockCache</code> for unit testing, without ever modifying the Controller's code at all!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  34 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 34: Try/Catch & Exception Bubbling";

$log = [];

class DatabaseException extends Exception {}
class ValidationException extends Exception {}

function attemptFragileOperation(bool $failDb, bool $failVal) {
    if ($failVal) throw new ValidationException("User provided bad input data.");
    if ($failDb) throw new DatabaseException("MySQL Engine went offline unexpectedly.");
    
    return "Operation Succeeded!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $failDb = isset($_POST['fail_db']);
    $failVal = isset($_POST['fail_val']);
    
    try {
        $log[] = "Trying operation...";
        $result = attemptFragileOperation($failDb, $failVal);
        $log[] = "RESULT: " . $result;
        
    } catch (ValidationException $e) {
        $log[] = "[CAUGHT] Business Logic Error: " . $e->getMessage();
        
    } catch (DatabaseException $e) {
        $log[] = "[CAUGHT] Infrastructure Error: " . $e->getMessage();
        // Here you would normally log to Monolog & page DevOps!
        
    } catch (Exception $e) {
        // The ultimate fallback for anything else
        $log[] = "[FATAL] Unknown crash: " . $e->getMessage();
        
    } finally {
        $log[] = "Finally Block Executed: Cleaning up RAM/Files regardless of success or crash.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Handling Catastrophic Failures</h2>
    <p>Using Custom Exceptions allows us to direct traffic when scripts explode natively, preventing white-screens of death.</p>
</div>

<form method="POST" class="content-box" style="display:flex; flex-direction:column; gap:10px;">
    <div>
        <input type="checkbox" id="v" name="fail_val" value="1"> 
        <label for="v">Simulate Invalid User Data (Soft Error)</label>
    </div>
    <div>
        <input type="checkbox" id="d" name="fail_db" value="1"> 
        <label for="d">Simulate Database Network Outage (Hard Crash)</label>
    </div>
    <button type="submit">Run Execution Block</button>
</form>

<?php if ($log): ?>
    <ul class="content-box" style="background:#000; color:#0f0; padding:20px; list-style-type:none;">
        <?php foreach ($log as $l): ?>
            <li style="margin-bottom:5px;">>> <?= htmlspecialchars($l) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 34 Project: Monolog Abstraction";

$codeSim = <<<PHP
use Monolog\\Logger;
use Monolog\\Handler\\StreamHandler;

// Create a central logging pipeline
\$log = new Logger('AppEngine');
\$log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::WARNING));

try {
    throw new Exception("Cache completely disconnected!");
} catch (Exception \$e) {
    // Only logs WARNING and above (ERROR, CRITICAL, EMERGENCY)
    \$log->error("System Interruption: " . \$e->getMessage(), [
        'ip' => \$_SERVER['REMOTE_ADDR']
    ]);
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Standardized Logging (PSR-3)</h2>
    <p>Instead of manual <code>file_put_contents()</code>, the entire industry utilizes <code>Monolog</code> to stream errors directly to Slack, Disk, or AWS CloudWatch!</p>
</div>

<h3>Implementation Code:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>Log Levels:</strong> DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY. Different handlers can be attached simultaneously (e.g. Save everything to disk, but email the team ONLY on EMERGENCY).
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  35 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
// We simulate an API Request physically here by intercepting
if (isset($_GET['api']) && $_GET['api'] === 'fetch') {
    ob_end_clean(); // Nuke any HTML output buffering instantly
    header('Content-Type: application/json; charset=utf-8');
    
    $payload = [
        'metadata' => ['status' => 200, 'timestamp' => time()],
        'data' => [
            ['id' => 10, 'username' => 'sys_admin', 'tier' => 'gold'],
            ['id' => 11, 'username' => 'ghost_user', 'tier' => 'basic']
        ]
    ];
    
    echo json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    exit; // STOP ALL EXECUTION SO NO HTML LOADS!
}

$pageTitle = "Week 35: Building JSON APIs";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Rendering pure JSON output natively</h2>
    <p>PHP powers global APIs seamlessly simply by altering Response Headers and halting HTML output.</p>
</div>

<div class="info-box">
    <a href="?api=fetch" style="color:#0c5460; font-weight:bold;">
        [ CLICK HERE TO VIEW API PAYLOAD IN BROWSER ]
    </a>
</div>

<h3>Architecture Required:</h3>
<pre>
header('Content-Type: application/json; charset=utf-8');
echo json_encode($arrayData);
exit;
</pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 35 Project: CORS & Rate Limiting";

$codeSim = <<<PHP
// 1. Cross-Origin Resource Sharing (CORS) Map
header("Access-Control-Allow-Origin: https://frontend-vue-app.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 2. Pre-flight OPTIONS request handling (Browsers send this before POSTing)
if (\$_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 3. Rate Limiting Example Constraint (Usually Redis)
\$hits = checkRedisHits(\$_SERVER['REMOTE_ADDR']);
if (\$hits > 60) {
    header("Retry-After: 60");
    http_response_code(429); // Too Many Requests
    echo json_encode(['error' => 'Rate Limit Exceeded.']);
    exit;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>API Infrastructure Security</h2>
    <p>We must manually instruct the browser if a foreign website (like a Vue.js or React app) is legally allowed to fetch data from our PHP server.</p>
</div>

<h3>Secured Gateway Implementation:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>HTTP 429:</strong> Never let users infinite-loop an API request. Implementing Rate Limiting mathematically protects your database from DDoS attacks!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  36 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 36: Consuming External APIs";

// We will use stream_context as an alternative to cURL for basic fetches!
$resultData = null;
$errorLog = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = "https://jsonplaceholder.typicode.com/posts/1"; // Public fake API
    
    // Setting up the HTTP config natively in PHP without cURL
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: EtecProfessionalPHP/1.0\r\n" .
                        "Accept: application/json\r\n",
            'timeout' => 5
        ]
    ];
    
    $context = stream_context_create($options);
    
    // The @ suppresses warnings so we can catch them cleanly for the UI
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        $errorLog = "Network Outage: Unable to connect cleanly to Typicode API.";
    } else {
        // We decode safely to an Associative Array (true argument)
        $resultData = json_decode($response, true);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Stream Context fetching (Server-side fetch)</h2>
    <p>PHP can act as the "Browser", connecting to other services (Stripe, Twilio) from the backend privately.</p>
</div>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;">Fetch External HTTPS Endpoint natively</button>
</form>

<?php if ($errorLog): ?>
    <div class="error-box"><?= htmlspecialchars($errorLog) ?></div>
<?php endif; ?>

<?php if ($resultData): ?>
    <div class="success-box">
        <h3>Payload Decoded:</h3>
        <table>
            <tr><th>Identifier</th><td><?= $resultData['id'] ?></td></tr>
            <tr><th>Resource Title</th><td><?= htmlspecialchars($resultData['title']) ?></td></tr>
            <tr><th>Content Body</th><td><?= htmlspecialchars($resultData['body']) ?></td></tr>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 36 Project: Advanced Extranet cURL Payload";

$curlCode = <<<PHP
\$ch = curl_init("https://api.stripe.com/v1/charges");

// Configure massive cURL payload
curl_setopt_array(\$ch, [
    CURLOPT_RETURNTRANSFER => true, // Return data instead of printing!
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['amount' => 2000, 'currency' => 'usd']),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer sk_test_secretKey123", /* JWT or Bearer Auth */
        "Accept: application/json"
    ],
    CURLOPT_TIMEOUT => 10,
]);

\$apiResult = curl_exec(\$ch);

if(curl_errno(\$ch)) {
    throw new Exception("cURL Critical Error: " . curl_error(\$ch));
}

\$httpCode = curl_getinfo(\$ch, CURLINFO_HTTP_CODE);
curl_close(\$ch);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Client URL (cURL) Infrastructure Engine</h2>
    <p>For complex API communication (OAuth, JWT Bearer tokens, multipart forms), cURL provides absolute low-level structural control.</p>
</div>

<h3>Mock Configuration Mapping:</h3>
<pre><?= htmlspecialchars($curlCode) ?></pre>

<div class="info-box">
    In modern PHP 8+, Developers often install <strong>GuzzleHTTP</strong> via Composer, which totally wraps the nasty <code>curl_setopt</code> logic into beautiful Object-Oriented methods (<code>$client->post('/charges', ['json' => $data]);</code>).
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  37 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 37: Environment Variables (.env)";

$envMock = <<<ENV
APP_NAME="Etec Pro Framework"
APP_ENV=production
APP_DEBUG=false

DB_HOST=127.0.0.1
DB_PORT=3306
DB_USER=root
DB_PASS=C0mpl3xP@ss!
ENV;

// Simulating PHP's getenv native function (which $_ENV relies on)
$mockEnvVars = [
    'APP_ENV' => 'production',
    'DB_HOST' => '127.0.0.1'
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>12-Factor App Environment Configuration</h2>
    <p>Passwords should absolutely never be typed in PHP codebase files. We read them implicitly from the Host OS using `.env` files.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3><code>.env</code> File Content</h3>
        <pre><?= htmlspecialchars($envMock) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Extraction Logic</h3>
        <pre>
$env = $_ENV['APP_ENV'] ?? 'local';
$host = getenv('DB_HOST');

if ($env === 'production') {
    // Hide native error printing!
    ini_set('display_errors', '0');
}
        </pre>
    </div>
</div>

<div class="error-box">
    <strong>CRITICAL:</strong> <code>.env</code> files must inherently be listed in <code>.gitignore</code>! Never commit database structures to GitHub!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 37 Project: Deployment Architectures";

// Conceptual representation
$deployFlow = <<<BASH
#!/bin/bash
# 1. Pull the latest code architecture securely
git pull origin main

# 2. Rebuild the Composer dependency injection
composer install --no-dev --optimize-autoloader

# 3. Synchronize database tables to exact migrations mapping
php artisan migrate --force

# 4. Cache Configurations natively for massive speed boost
php artisan config:cache

# 5. Flush external OPCACHE engine
systemctl reload php-fpm
BASH;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Zero-Downtime Deployment Lifecycle</h2>
    <p>Pushing code via FTP is obsolete. We deploy utilizing specialized server-level scripts representing absolute consistency.</p>
</div>

<h3>Production Shell Script Hook</h3>
<pre><?= htmlspecialchars($deployFlow) ?></pre>

<div class="info-box">
    <strong>Composer Flag:</strong> The <code>--no-dev</code> restricts the server from downloading testing packages (like PHPUnit), keeping the footprint extremely fast and isolated strictly to business logic!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  38 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 38: Unit Testing (PHPUnit Integration)";

$testSubject = <<<PHP
class MathService {
    public function divide(float \$n, float \$d): float {
        if (\$d == 0) throw new InvalidArgumentException("Divisor zero zero constraint.");
        return \$n / \$d;
    }
}
PHP;

$unitTest = <<<PHP
use PHPUnit\\Framework\\TestCase;

class MathServiceTest extends TestCase {
    
    public function testDivisionCalculatesCleanly(): void {
        \$math = new MathService();
        \$result = \$math->divide(10, 2);
        
        \$this->assertEquals(5.0, \$result); // Assertion
    }
    
    public function testDivisionByZeroRejects(): void {
        \$this->expectException(InvalidArgumentException::class);
        
        \$math = new MathService();
        \$math->divide(10, 0); // Will instantly trigger green if the exception fires!
    }
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Automated Code Verification logic</h2>
    <p>Professional devs do not refresh their browser to check if their code works. They write code that automatically checks their code.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Original File Engine</h3>
        <pre><?= htmlspecialchars($testSubject) ?></pre>
    </div>
    
    <div style="flex:1; border-left:4px solid green; padding-left:15px;">
        <h3 style="color:green;">PHPUnit Test Engine</h3>
        <pre><?= htmlspecialchars($unitTest) ?></pre>
    </div>
</div>

<div class="info-box" style="text-align:center;">
    <strong>Terminal Execution:</strong> <code>./vendor/bin/phpunit tests/</code> <br><br>
    <span style="background:#000; color:#0f0; padding:10px; font-family:monospace; display:inline-block;">OK (2 tests, 2 assertions)</span>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 38 Project: Test-Driven Development (TDD)";

$conceptText = <<<TEXT
1. RED: Write the exact Test FIRST! Run it. Watch it fail because no code exists yet natively.
2. GREEN: Write the minimal amount of PHP code required to pass the verification node.
3. REFACTOR: Clean up the code architecture safely, while verifying the tests still pass.
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Test-Driven Development Workflow</h2>
</div>

<h3>The TDD Cycle Configuration Matrix</h3>
<pre><?= htmlspecialchars($conceptText) ?></pre>

<div class="success-box">
    Writing tests initially feels slow. But as your system grows to thousands of lines, changing 1 fundamental method takes 5 seconds of testing, rather than an entire week of manual QA verification!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  39 => [
    'ex1' => <<<'EOT'
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
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 39 Project: Cache Busting";

// Simulated config
$appVersion = "v2.1.4"; // Incrementing this forces CSS resets immediately globally
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Client-Side Cache Invalidation</h2>
</div>

<h3>Applying Timestamp / Version Strings to Static Assets:</h3>
<pre>
&lt;!-- BAD: Browser caches it for 30 days forever! --&gt;
&lt;link rel="stylesheet" href="/style.css"&gt;

&lt;!-- GOOD: Using structural version mapping --&gt;
&lt;link rel="stylesheet" href="/style.css?v=<?= htmlspecialchars($appVersion) ?>"&gt;

&lt;!-- BEST: Using exact file modification time mapping --&gt;
&lt;link rel="stylesheet" href="/style.css?time=<?= filemtime(__DIR__ . '/../style.css') ?>"&gt;
</pre>

<div class="info-box">
    Using <code>filemtime()</code> solves the CSS/JS cache problems elegantly. The moment you save the CSS file physically, the number changes, destroying the user's browser cache natively!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  40 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 40: CSRF Tokens & Final Polish";

session_start();

// 1. Generate CRSF Token securely if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$status = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    
    // 2. Validate token exactly via timing-attack safe comparison!
    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        http_response_code(403);
        $status = "FORBIDDEN: Security Token Mismatch. Suspected CSRF Hijack execution blocked.";
    } else {
        $status = "SUCCESS: Profile Updated securely.";
        // Reset the token so it cannot be reused!
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Cross-Site Request Forgery (CSRF) Mitigation</h2>
    <p>We inject a hidden token into EVERY form. If a malicious website tricks your browser into submitting a form to your server, they won't know the exact random token so the request fails validation natively!</p>
</div>

<?php if ($status): ?>
    <div class="<?= str_starts_with($status, 'SUCCESS') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($status) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <!-- HIDDEN CONSTANT INJECTION -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    
    <label>Modify Profile Node Setup:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="data" value="Some Secure Layout Data" autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Run Execution</button>
    </div>
    
    <div style="margin-top:10px; font-size:0.8em;">
        <strong>Hidden Injected Payload:</strong> <code><?= htmlspecialchars($_SESSION['csrf_token']) ?></code>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 40 Project: Full Curriculum Final Review";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box" style="text-align:center; padding-top:40px; padding-bottom:40px;">
    
    <h1 style="font-size:3em; margin-bottom:0;">Zero to Hero: PHP Capstone</h1>
    <h3 style="color:var(--text-color); margin-top:10px; text-transform:uppercase;">Curriculum Output Validated Successfully</h3>
    
    <hr style="width:50%; margin:30px auto;">
    
    <ul style="list-style-type:none; padding:0; display:inline-block; text-align:left;">
        <li style="margin-bottom:10px;">✔️ Phase 1: Engine Output & Basic Algorithms</li>
        <li style="margin-bottom:10px;">✔️ Phase 2: Array Structures & Functional Paradigms</li>
        <li style="margin-bottom:10px;">✔️ Phase 3: S.O.L.I.D. Architectural Boundaries</li>
        <li style="margin-bottom:10px;">✔️ Phase 4: MVC State Machines & Databases</li>
        <li style="margin-bottom:10px;">✔️ Phase 5: Cryptography, Identity, & Scaling</li>
    </ul>

</div>

<div class="success-box" style="text-align:center;">
    You are now equipped with the exact design patterns natively powering <strong>Laravel</strong>, <strong>Symfony</strong>, and <strong>Enterprise Platforms</strong> worldwide.
</div>

<div style="text-align:center; margin-top:30px;">
    <a href="/php_course/index.php"><button style="padding:15px 30px; font-size:1.2em;">Return to Core Index Directory</button></a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ]
];

$dirs = array_filter(glob(__DIR__ . '/week_*'), 'is_dir');
foreach ($dirs as $dir) {
  preg_match('/week_0*(\d+)/', basename($dir), $matches);
  if (!isset($matches[1]))
    continue;
  $weekNum = (int) $matches[1];
    if (isset($examples[$weekNum])) {
        $refs = require __DIR__ . '/references_data.php';
        $refData = $refs[$weekNum] ?? ['url' => 'https://www.php.net/manual/pt_BR/', 'title' => 'Official Documentation', 'snippet' => '// Custom snippet'];
        
        $injectionHtml = '
<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="' . htmlspecialchars($refData['url']) . '" target="_blank">PHP Manual: ' . htmlspecialchars($refData['title']) . '</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>' . htmlspecialchars($refData['snippet']) . '</code></pre>
</div>
';

        $footerRequire = "<?php require_once __DIR__ . '/../includes/footer.php'; ?>";
        
        $ex1 = str_replace($footerRequire, $injectionHtml . "\n" . $footerRequire, $examples[$weekNum]['ex1']);
        $ex2 = str_replace($footerRequire, $injectionHtml . "\n" . $footerRequire, $examples[$weekNum]['ex2']);

        file_put_contents($dir . '/example_1.php', $ex1);
        file_put_contents($dir . '/example_2.php', $ex2);
    }
}
echo "Professional Layouts generated & applied to Weeks 31-40.\n";
