<?php
/**
 * Advanced PHP Code Populate Tool - Weeks 31 to 40
 * Technical level (pre-university), 1.5-hour classes. Includes edge cases and actual projects.
 */

$examples = [
    31 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 31: Advanced Authorization & Role Based Access Control (RBAC)
 * Topics:
 * - Bitwise Permissions (Super fast, hierarchical roles)
 * - Middleware Authorization Architecture
 * - Handling 403 Forbidden properly
 */

// Bitwise Constants representing unique powers (1, 2, 4, 8, 16...)
const PERM_READ   = 1;
const PERM_WRITE  = 2;
const PERM_DELETE = 4;
const PERM_ADMIN  = 8;

// Role Configurations assigned to users in the database
$roles = [
    'GUEST'  => PERM_READ,
    'EDITOR' => PERM_READ | PERM_WRITE,
    'ADMIN'  => PERM_READ | PERM_WRITE | PERM_DELETE | PERM_ADMIN
];

$currentUserRole = $roles['EDITOR']; // Simulated from DB/Session

echo "<h3>Bitwise Role Checking</h3>";

// Checking if EDITOR can Delete
if ($currentUserRole & PERM_DELETE) {
    echo "Access Granted: Can Delete.<br>";
} else {
    echo "Access Denied: Cannot Delete. (Missing PERM_DELETE flag).<br>";
}

// Checking if EDITOR can Write
if ($currentUserRole & PERM_WRITE) {
    echo "Access Granted: Can Write!<br>";
}

// Why use Bitwise? Because storing 1 integer (`3` for Editor) is infinitely faster 
// and smaller in a DB than storing `["read" => true, "write" => true]`.
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 31 Project: Secure E-Commerce Backend - Access Control List (ACL)
 * 
 * Verifying resource ownership! An Editor can edit posts, but can they 
 * edit ANOTHER user's post?
 */

class PostPolicy {
    /**
     * @param array $user The current authenticated user
     * @param array $post The post attempting to be modified
     * @return bool
     */
    public static function canUpdate(array $user, array $post): bool {
        // 1. Admins can update ANYTHING.
        if ($user['role'] === 'ADMIN') {
            return true;
        }

        // 2. Regular users can only update their OWN posts.
        if ($user['id'] === $post['author_id']) {
            return true;
        }

        return false;
    }
}

// Simulated Entities
$loggedUser = ['id' => 42, 'role' => 'AUTHOR'];
$targetPost = ['id' => 101, 'author_id' => 99]; // Belongs to user #99!

echo "<h3>Resource Ownership (Gate Policy)</h3>";

if (PostPolicy::canUpdate($loggedUser, $targetPost)) {
    echo "<span style='color:green;'>Policy PASSED: Allowed to edit.</span>";
} else {
    echo "<span style='color:red;'>Policy FAILED: This post does not belong to you! HTTP 403.</span>";
}
EOT
    ],
    32 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 32: Web Security Protections Deep Dive (1.5 Hours)
 * Topics:
 * - Cross-Site Request Forgery (CSRF) in Depth
 * - SameSite Cookie Attribute (Strict vs Lax)
 * - Cross-Site Scripting (XSS) (Stored vs Reflected)
 * - Content Security Policy (CSP) Headers
 */

// 1. CSP Header
// Prevents the browser from executing arbitrary inline scripts or loading external scripts!
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-cdn.com");

echo "<h3>Security Headers applied!</h3>";
echo "CSP Header sent. Browsers will refuse to run inline <code>&lt;script&gt;</code> blocks on this page!<br>";

// 2. CSRF Token Generation
session_start();
if (empty($_SESSION['csrf_token'])) {
    // Generate 32 bytes of secure randomness and convert to a hex string
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}

// Validate POST securely using hash_equals to prevent timing attacks
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientToken = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if (!$clientToken || !hash_equals($_SESSION['csrf_token'], $clientToken)) {
        http_response_code(419);
        die("CSRF Token Verification Failed.");
    }
    echo "<p style='color:green'>Form executed securely with CSRF verification!</p>";
}
?>
<form method="POST">
    <!-- CRITICAL: Every state-changing form MUST have this hidden token -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <button type="submit">Perform Sensitive Action</button>
</form>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 32 Project: Secure E-Commerce Backend - Anti-XSS Templating
 * 
 * We simulate handling Reflected XSS from a malicious search query,
 * and Stored XSS dragged from a compromised database.
 */

// A hacker passes arbitrary Javascript into the URL: ?query=<script>alert('XSS')</script>
$maliciousSearch = $_GET['query'] ?? "<script>alert('Reflected XSS Hit');</script>";

// A compromised record in the DB
$maliciousProductDescription = "<img src='x' onerror='alert(\"Stored XSS Hit\");'>";

echo "<h3>XSS Mitigation Zone</h3>";

// 1. DANGEROUS RENDER:
// echo "You searched for: $maliciousSearch <br>"; // DO NOT DO THIS

// 2. SAFE RENDER (Reflected):
$safeSearch = htmlspecialchars($maliciousSearch, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
echo "You securely searched for: <code style='color:blue;'>$safeSearch</code><br>";

// 3. SAFE RENDER (Stored but allowed HTML):
// Sometimes we WANT users to use bold/italic (like a WYSIWYG editor).
// We cannot use htmlspecialchars, because it breaks the formatting.
// Instead, we use `strip_tags` with an allow-list, OR a library like HTMLPurifier!
$safeProduct = strip_tags($maliciousProductDescription, '<b><i><strong><em>');
echo "Product Description (Stripped): <code style='color:green;'>$safeProduct</code>";
EOT
    ],
    33 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 33: JSON and RESTful Architecture (1.5 Hours)
 * Topics:
 * - JSON Encode/Decode internals, depth, and flags
 * - HTTP Status Codes Mapping
 * - RESTful Naming Conventions
 */

// 1. Advanced JSON Encoding
$userData = [
    'username' => 'Jöhn Døe',
    'status'   => 'active',
    'html'     => '<a href="#">Link</a>'
];

// JSON_UNESCAPED_UNICODE keeps special chars intact.
// JSON_HEX_TAG escapes < and > to prevent XSS if the JSON is echoed directly into an HTML script block.
$json = json_encode($userData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT);

echo "<h3>JSON Export</h3><pre>$json</pre>";

// 2. Advanced JSON Decoding
$badJson = '{"name": "Alice", "age": }'; // Syntax Error!
$decoded = json_decode($badJson, true); // true = associatve array

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<strong>JSON Decode Failed:</strong> " . json_last_error_msg() . "<br>";
}

// 3. REST HTTP Methods Concept
echo "<hr><strong>REST Verbs:</strong><br>";
echo "GET = Retrieve Data<br>POST = Create Data<br>PUT/PATCH = Update Data<br>DELETE = Destroy Data";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 33 Project: Weather Application API - Receiving Endpoints
 * 
 * Parsing a RAW JSON payload from the request body. 
 * $_POST is ONLY populated by forms (application/x-www-form-urlencoded).
 * Mobile Apps or modern JS (fetch/axios) send raw `application/json`.
 */

// 1. Read the raw PHP input stream
$rawInput = file_get_contents('php://input');

// Simulate a raw payload arriving
$rawInput = '{"city": "London", "temp": 15.5}';

if (!empty($rawInput)) {
    // 2. Decode strictly to an array
    $payload = json_decode($rawInput, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        $city = htmlspecialchars((string)($payload['city'] ?? 'Unknown'));
        $temp = (float)($payload['temp'] ?? 0.0);
        
        echo "<h3>API Receiver Logic</h3>";
        echo "Successfully parsed weather update:<br>";
        echo "City: $city <br> Temp: {$temp}°C";
        
        // Return a JSON response
        // header('Content-Type: application/json');
        // echo json_encode(['status' => 'success']);
    }
}
EOT
    ],
    34 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 34: Consuming External APIs (1.5 Hours)
 * Topics:
 * - cURL configuration deeply (Timeouts, SSL, Headers)
 * - Handling Remote API Failures
 * - file_get_contents vs cURL
 */

// While file_get_contents is easy, cURL is professional.
$url = "https://jsonplaceholder.typicode.com/users/1";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true, // Return data instead of printing directly
    CURLOPT_TIMEOUT => 5, // DONT hang the PHP server forever if the API is down!
    CURLOPT_SSL_VERIFYPEER => true, // NEVER set this to false in prod!
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'User-Agent: ETEC-Server/1.0'
    ]
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch) . "<br>";
} else {
    echo "<h3>API Request Completed (Code $httpCode)</h3>";
    $userData = json_decode($response, true);
    echo "Fetched User: " . htmlspecialchars($userData['name'] ?? 'N/A');
}

curl_close($ch);
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 34 Project: Weather Application API - Fetching Geocoding
 * 
 * Combining an external API fetch with error handling and class encapsulation.
 */

class WeatherService {
    private string $apiKey = "DEMO_KEY"; // Normally loaded from $_ENV

    public function fetchCityData(string $city): ?array {
        // Simulating the URL format for OpenWeatherMap
        $cleanCity = urlencode($city);
        $url = "https://jsonplaceholder.typicode.com/users?username={$cleanCity}";
        
        // Using context for file_get_contents (A simpler alternative to cURL for GET requests)
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 3, // 3 seconds timeout
            ]
        ]);

        // Supress warnings with @ if the server goes offline, handle via false check
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            error_log("WeatherService Failure: Could not reach API for city: $city");
            return null; // Graceful degradation
        }

        return json_decode($response, true);
    }
}

$service = new WeatherService();
echo "<h3>Weather Fetching Simulation</h3>";
$data = $service->fetchCityData('Bret'); // Using 'Bret' to match the fake JSON API

if ($data) {
    echo "Data retrieved! " . count($data) . " records found.";
} else {
    echo "Service temporarily unavailable. Please try again later.";
}
EOT
    ],
    35 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 35: Building a Custom RESTful API (1.5 Hours)
 * Topics:
 * - Proper HTTP Status Codes
 * - JSON Response architecture
 * - Token Authentication Headers (Bearer)
 */

// A reusable trait to enforce standard JSON API responses
trait ApiResponse {
    protected function json(mixed $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *'); // CORS handling
        
        echo json_encode([
            'status' => $status < 400 ? 'success' : 'error',
            'data'   => $status < 400 ? $data : null,
            'error'  => $status >= 400 ? $data : null
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

class ApiController {
    use ApiResponse;

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        if ($method !== 'GET') {
            $this->json('Method Not Allowed. This endpoint is Read-Only.', 405);
        }

        // Simulate Auth Check
        $headers = getallheaders();
        $auth = $headers['Authorization'] ?? '';
        
        // We bypass auth for this demo if not present, but in reality:
        // if (strpos($auth, 'Bearer') !== 0) $this->json('Unauthorized', 401);

        $this->json(['message' => 'API is functional.', 'version' => '1.0']);
    }
}

// In a real router: (new ApiController())->handleRequest();
echo "<h3>API Controller Bootstrapped</h3>";
echo "Use Postman to target this script. It uses standard `http_response_code()` and outputs raw JSON.";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 35 Project: Weather Application API - Endpoints
 * 
 * Routing an incoming API request to the correct internal service.
 */

// Simulated Router state
$requestUri = '/api/weather/london'; 
$method = 'GET';

echo "<h3>API Router Simulation</h3>";

if (preg_match('/^\/api\/weather\/(.+)$/', $requestUri, $matches)) {
    if ($method === 'GET') {
        $city = htmlspecialchars($matches[1]);
        
        // Response Payload
        $payload = [
            'city' => ucfirst($city),
            'temp_celsius' => 18.5,
            'condition' => 'Cloudy'
        ];
        
        // Output as JSON
        echo "<pre>" . json_encode($payload, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "405 Method Not Allowed";
    }
} else {
    echo "404 Endpoint Not Found";
}
EOT
    ],
    36 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 36: Modern PHP Ecosystem (Composer & PSR-4) (1.5 Hours)
 * Topics:
 * - composer.json internals
 * - Namespaces
 * - PSR-4 Autoloading vs requires
 */

namespace App\Core; // Declaring a namespace prevents class name collisions!

class Application {
    public function run() {
        echo "Application Booted within namespace App\Core!<br>";
    }
}

// Global scope switch to use it
namespace {
    echo "<h3>Modern Namespacing</h3>";
    $app = new \App\Core\Application();
    $app->run();

    echo "<hr><h4>The Composer Magic</h4>";
    echo "Without Composer, you would need to write: <br><code>require 'src/Core/Application.php';</code><br>";
    echo "With Composer, you map <code>\"App\\\\\": \"src/\"</code> in <code>composer.json</code>...<br>";
    echo "And simply call <code>require 'vendor/autoload.php';</code> once at the top of <code>index.php</code>!";
}
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 36 Project: Mailer Integration via Composer
 * 
 * Simulating the integration of PHPMailer (A 3rd-party Composer package).
 */

namespace App\Services;

// We pretend this is loaded via Composer's vendor/autoload.php
// use PHPMailer\PHPMailer\PHPMailer; 

class NotificationService {
    public function sendWelcomeEmail(string $email) {
        /*
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->setFrom('noreply@myapp.com', 'My App');
        $mail->addAddress($email);
        $mail->Subject = 'Welcome to the App!';
        $mail->Body    = 'Glad to have you onboard.';
        $mail->send();
        */
        
        echo "<p style='color:green'>[Simulation] Email safely dispatched to $email using modern Composer packages!</p>";
    }
}

namespace {
    $notifier = new \App\Services\NotificationService();
    $notifier->sendWelcomeEmail("student@etec.edu.br");
}
EOT
    ],
    37 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 37: Advanced Error Handling and Exceptions (1.5 Hours)
 * Topics:
 * - set_error_handler & set_exception_handler
 * - Custom Exception Classes
 * - The Finally block
 */

// 1. Defining Custom Exceptions
class DatabaseException extends Exception {}
class ValidationException extends Exception {}

function connectAndSave(string $data) {
    if (empty($data)) {
        // Validation fails
        throw new ValidationException("Data cannot be empty!");
    }
    // DB Fails
    throw new DatabaseException("Connection timeout attempting to save '$data'.");
}

echo "<h3>Exception Handling Blocks</h3>";

try {
    echo "Trying to connect...<br>";
    connectAndSave(''); // Will throw ValidationException
} catch (ValidationException $e) {
    // We catch specific errors and route them
    echo "<span style='color:orange;'>Validation Blocked: {$e->getMessage()}</span><br>";
} catch (DatabaseException $e) {
    echo "<span style='color:red;'>Database Crash: {$e->getMessage()}</span><br>";
} catch (Exception $e) {
    // Fallback for absolutely anything else
    echo "Unknown Error: {$e->getMessage()}<br>";
} finally {
    // Finally ALWAYS runs, even if execution was halted or returned inside the try/catch!
    // Vital for closing files or database connections.
    echo "<strong>Finally Block:</strong> Cleaning up resources...<br>";
}
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 37 Project: Full-Stack Integration - Global Error Handler
 * 
 * Setting up an overriding engine that grabs ALL stray PHP warnings 
 * and fatal errors, turning them into clean JSON exceptions.
 */

// Intercepts things like array_key warnings!
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Intercepts uncaught exceptions and prevents ugly stack traces to the user!
set_exception_handler(function(Throwable $e) {
    http_response_code(500);
    echo "<div style='background:#fee; border:1px solid red; padding:15px; font-family:monospace;'>";
    echo "<h2>Critical System Failure Intercepted</h2>";
    echo "Message: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "<br>";
    echo "<em>In a real app, this prints into log files, and the user sees a friendly 500 page.</em>";
    echo "</div>";
});

// Trigger an error to test the interceptor:
echo "Attempting to read undefined variable:<br>";
echo $thisVariableDoesntExist; // Will crash gracefully due to our custom handler!
EOT
    ],
    38 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 38: Dates, Times, and Localization (1.5 Hours)
 * Topics:
 * - The DateTime object vs procedural dates
 * - DateInterval & DatePeriod
 * - Timezone conversions
 */

echo "<h3>DateTime Engine</h3>";

// 1. Instantiating precise localized times
$nyTime = new DateTime('now', new DateTimeZone('America/New_York'));
$spTime = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

echo "New York Time: " . $nyTime->format('Y-m-d H:i:s') . "<br>";
echo "São Paulo Time: " . $spTime->format('Y-m-d H:i:s') . "<br>";

// 2. Modifying Dates mathematically
$invoiceDue = clone $spTime; // Clone to avoid modifying original object!
$invoiceDue->modify('+14 days');
echo "Invoice Due Date (14 days from SP): " . $invoiceDue->format('l, F jS, Y') . "<br>";

// 3. Comparing Dates
if ($spTime < $invoiceDue) {
    echo "The invoice is still valid.<br>";
}

// 4. DateInterval (Adding precise spans)
$duration = new DateInterval('P1Y2M3D'); // Period: 1 Year, 2 Months, 3 Days
$spTime->add($duration);
echo "SP Time after 1Y2M3D: " . $spTime->format('Y-m-d H:i:s') . "<br>";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 38 Project: Full-Stack Integration - Localization Helpers
 * 
 * Formatting dates relatively (e.g., "5 minutes ago", "yesterday") 
 * specifically for the Blog/CMS interface.
 */

function timeAgo(DateTime $datetime): string {
    $now = new DateTime();
    $interval = $now->diff($datetime);

    if ($interval->y > 0) return $interval->y . " year(s) ago";
    if ($interval->m > 0) return $interval->m . " month(s) ago";
    if ($interval->d > 0) {
        if ($interval->d === 1) return "Yesterday";
        return $interval->d . " days ago";
    }
    if ($interval->h > 0) return $interval->h . " hour(s) ago";
    if ($interval->i > 0) return $interval->i . " minute(s) ago";
    
    return "Just now";
}

echo "<h3>Blog Timeline Render</h3>";

$post1 = new DateTime('-5 minutes');
$post2 = new DateTime('-3 hours');
$post3 = new DateTime('-1 day');
$post4 = new DateTime('-4 months');

echo "<ul>";
echo "<li>Latest Post: " . timeAgo($post1) . "</li>";
echo "<li>Server Update: " . timeAgo($post2) . "</li>";
echo "<li>Database Backup: " . timeAgo($post3) . "</li>";
echo "<li>System Implemented: " . timeAgo($post4) . "</li>";
echo "</ul>";
EOT
    ],
    39 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 39: Final Architecture Patterns (1.5 Hours)
 * Topics:
 * - Bootstrapping a framework
 * - Dependency Injection Container concepts
 * - Environment variables (.env)
 */

echo "<h3>The Architecture Flow</h3>";

$architecture = <<<TEXT
Modern Application Flow:
1. `public/index.php` hit by the browser.
2. It requires `vendor/autoload.php`.
3. It loads the `.env` configuration file (containing DB passwords).
4. The Dependency Injection Container (DIC) maps standard singletons (PDO, ViewEngine).
5. The `Router` reads `routes.php` and executes the configured `Controller`.
6. The `Controller` receives Dependencies via its `__construct()`.
7. The `Controller` grabs data from the `Models`.
8. The `Controller` replies sending the data back using the `ViewEngine`.
TEXT;

echo "<pre>$architecture</pre>";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 39 Project: Full-Stack App - The Service Container
 * 
 * Demonstrating how modern frameworks map dependencies so Controllers 
 * don't have to manually `new Database()` everywhere!
 */

class ServiceContainer {
    private array $services = [];

    // Register a service with an anonymous function (lazy loading)
    public function bind(string $name, callable $resolver) {
        $this->services[$name] = $resolver;
    }

    // Resolve and return the service
    public function resolve(string $name) {
        if (!isset($this->services[$name])) throw new Exception("Service not found.");
        // Call the closure and return the object
        return $this->services[$name](); 
    }
}

// System Boot
$app = new ServiceContainer();

$app->bind('database', function() {
    // In reality: return new PDO(...);
    return (object)['status' => 'Conneted to MariaDB', 'version' => '10.5'];
});

$app->bind('mailer', function() {
    return (object)['service' => 'Sendgrid Driver Active'];
});

// Deep inside a controller later in execution:
echo "<h3>Controller Accessing Container</h3>";
$db = $app->resolve('database');
echo "DB Loaded: " . $db->status . "<br>";

$mail = $app->resolve('mailer');
echo "Mail Loaded: " . $mail->service . "<br>";
EOT
    ],
    40 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 40: The Final Polish and Deployment Strategies (1.5 Hours)
 * Topics:
 * - Production php.ini configurations
 * - Nginx/Apache .htaccess lockdown
 * - Environment segregation
 * - Final Security Checklist
 */

echo "<h3>Production Checklist Matrix</h3>";

$checklist = [
    'display_errors' => 'Must be OFF. Logs must be ON. Never leak stack traces.',
    'PDO Emulations' => 'Must be FALSE. Protects against advanced SQL Intrusions.',
    'Session Config' => 'Strict SameSite, Secure flags, HttpOnly on all tokens.',
    'Vendor Folder'  => 'Must NOT be accessible from the web. Keep public files inside `/public`.',
    'Passwords'      => 'Use PASSWORD_ARGON2ID or PASSWORD_BCRYPT.',
    'File Uploads'   => 'Block PHP execution in upload folders using .htaccess or Nginx rules.',
    'Permissions'    => 'chmod 755 for directories, 644 for files. 777 is forbidden.'
];

echo "<ul>";
foreach ($checklist as $key => $rule) {
    echo "<li><strong>$key:</strong> $rule</li>";
}
echo "</ul>";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 40 Project: Full-Stack App - Graduation!
 * 
 * Wrap up implementation.
 */

// Simulated Graduation Logic
$studentName = "Amazing Developer";
$weeksCompleted = 40;
$allProjectsExecuted = true;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Graduation</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Arial; text-align: center; background-color: #f0f4f8; padding-top: 50px; }
        .certificate { background: #fff; padding: 40px; border: 2px solid gold; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; }
        h2 { color: #e67e22; }
        p { font-size: 1.2em; color: #34495e; }
    </style>
</head>
<body>

    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <h2>Zero to Hero: Advanced PHP Backend Architecture</h2>
        
        <p>This certifies that <strong><?= htmlspecialchars($studentName) ?></strong> has completed the grueling <?= $weeksCompleted ?>-week curriculum.</p>
        
        <?php if ($allProjectsExecuted): ?>
            <p style="color: green; font-weight: bold;">[ PASSED WITH DISTINCTION ]</p>
            <p>Mastered Arrays, OOP, PDO, Security, APIs, and modern RESTful Systems.</p>
        <?php else: ?>
            <p>Please complete missed projects to obtain graduation status.</p>
        <?php endif; ?>

        <hr style="border-color: #eee;">
        <p><em>Class Dismissed.</em></p>
    </div>

</body>
</html>
EOT
    ]
];

$dirs = array_filter(glob(__DIR__ . '/week_*'), 'is_dir');
foreach ($dirs as $dir) {
    preg_match('/week_0*(\d+)/', basename($dir), $matches);
    if (!isset($matches[1])) continue;
    $weekNum = (int)$matches[1];
    
    if (isset($examples[$weekNum])) {
        file_put_contents($dir . '/example_1.php', $examples[$weekNum]['ex1']);
        file_put_contents($dir . '/example_2.php', $examples[$weekNum]['ex2']);
    }
}
echo "Advanced Weeks 31-40 examples populated successfully.\n";
