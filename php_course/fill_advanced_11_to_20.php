<?php
/**
 * Advanced PHP Code Populate Tool - Weeks 11 to 20
 * Technical level (pre-university), 1.5-hour classes. Includes edge cases and actual projects.
 */

$examples = [
    11 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 11: Deep Dive into Superglobals (1.5 Hours)
 * Topics:
 * - Exploring $_SERVER deeply (REMOTE_ADDR, HTTP_USER_AGENT, REQUEST_URI)
 * - Handling $_GET safely (filter_input vs ??)
 * - XSS basics via Unsanitized Data
 */

// 1. The $_SERVER array
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown CLI';
$method    = $_SERVER['REQUEST_METHOD'] ?? 'CLI';

echo "<h3>Environment Details</h3>\n";
echo "IP: $ipAddress <br> User Agent: $userAgent <br> HTTP Method: $method <br><hr>\n";

// 2. Safe vs Unsafe $_GET
// UNSAFE (Do not use this in production! Prone to XSS)
// $query = $_GET['q'] ?? '';
// echo "You searched for: " . $query; 

// SAFE: Built-in filter_input is robust for superglobals
$cleanQuery = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);

if ($cleanQuery) {
    echo "You safely searched for: <strong>$cleanQuery</strong>\n";
} else {
    echo "No search query provided. Try adding <code>?q=hello</code> to the URL.\n";
}
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 11 Project: Task Manager Web App - State Handling
 * 
 * Using $_GET strictly to control the application state (Routing via Query String).
 * We enforce strict types using the 'match' control structure to handle inputs.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';
$taskId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

echo "<h2>Task Manager</h2>\n";

// Advanced Action Routing
$output = match($action) {
    'list'   => "-> Listing all current tasks in the database...",
    
    'view'   => $taskId 
                ? "-> Viewing details for Task ID: $taskId" 
                : "-> Error: Task ID required to view.",
                
    'delete' => $taskId 
                ? "-> [DANGER] Deleted Task ID: $taskId!" 
                : "-> Error: Task ID required to delete.",
                
    default  => "-> Unknown action requested: " . htmlspecialchars($action)
};

echo "<div style='padding:15px; background:#f4f4f4; border:1px solid #ddd;'>\n";
echo "<strong>System Output:</strong> <br>\n$output\n";
echo "</div>\n";

echo "<hr><h3>Simulate Actions:</h3>\n";
echo "<ul>\n";
echo "<li><a href='?action=list'>List Tasks</a></li>\n";
echo "<li><a href='?action=view&id=5'>View Task #5</a></li>\n";
echo "<li><a href='?action=delete&id=5'>Delete Task #5</a></li>\n";
echo "<li><a href='?action=hax'>Unknown Action</a></li>\n";
echo "</ul>\n";
EOT
    ],
    12 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 12: Advanced Forms and Validation (1.5 Hours)
 * Topics:
 * - Post/Redirect/Get (PRG) Pattern
 * - Strict Validation (filter_var)
 * - Anti-CSRF Intro
 */

// Basic PRG Implementation Note:
// In a real script, after a successful POST logic execution, you would:
// header('Location: success.php');
// exit;
// This prevents the "Confirm Form Resubmission" alert on page refresh.

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Strict Validation
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors['email'] = 'A valid email address is required.';
    }

    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 18, 'max_range' => 120]
    ]);
    if ($age === false) {
        $errors['age'] = 'Age must be an integer between 18 and 120.';
    }

    if (empty($errors)) {
        $successMessage = "Successfully registered user: $email (Age: $age)";
        // Simulate PRG: header("Location: ?success=1"); exit;
    }
}
?>
<h3>Advanced Validation Form</h3>
<?php if ($successMessage) echo "<p style='color:green;'>$successMessage</p>"; ?>
<form method="POST">
    <?php if (isset($errors['email'])) echo "<div style='color:red;'>{$errors['email']}</div>"; ?>
    <label>Email: <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label><br><br>
    
    <?php if (isset($errors['age'])) echo "<div style='color:red;'>{$errors['age']}</div>"; ?>
    <label>Age: <input type="number" name="age" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>"></label><br><br>
    
    <button type="submit">Register</button>
</form>
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 12 Project: Task Manager Web App - Task Creation
 * 
 * Building the dynamic creation form of our application with rigorous validation
 * and maintaining form state.
 */

$errors = [];
$title = $_POST['title'] ?? '';
$priority = $_POST['priority'] ?? '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate Title
    $title = trim($title);
    if (mb_strlen($title) < 3) {
        $errors['title'] = 'Task title must be at least 3 characters long.';
    }

    // Validate Priority
    $priorityInt = filter_input(INPUT_POST, 'priority', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 3]
    ]);
    if ($priorityInt === false) {
        $errors['priority'] = 'Invalid priority selected.';
    }

    if (empty($errors)) {
        // Normally, save to Database here!
        echo "<h3 style='color:green;'>Task Created Successfully!</h3>";
        // Reset state after success (PRG alternative for single file)
        $title = ''; 
        $priority = '1';
    }
}
?>

<h2>Create New Task</h2>
<form method="POST">
    <div style="margin-bottom:10px;">
        <label>Task Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" style="width:100%; max-width:300px;">
        <?php if (isset($errors['title'])) echo "<small style='color:red;'><br>{$errors['title']}</small>"; ?>
    </div>
    
    <div style="margin-bottom:10px;">
        <label>Priority:</label><br>
        <select name="priority">
            <option value="1" <?= $priority === '1' ? 'selected' : '' ?>>Low</option>
            <option value="2" <?= $priority === '2' ? 'selected' : '' ?>>Medium</option>
            <option value="3" <?= $priority === '3' ? 'selected' : '' ?>>High</option>
        </select>
        <?php if (isset($errors['priority'])) echo "<small style='color:red;'><br>{$errors['priority']}</small>"; ?>
    </div>

    <button type="submit">Save Task</button>
</form>
EOT
    ],
    13 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 13: Sessions Security and State Handling (1.5 Hours)
 * Topics:
 * - session_set_cookie_params (Security first!)
 * - Session Hijacking Prevention (Regenerate ID)
 * - Destroying sessions fully
 */

// 1. ALWAYS configure session cookies BEFORE starting the session
session_set_cookie_params([
    'lifetime' => 3600, // 1 Hour
    'path' => '/',
    'domain' => '',     // Or 'yourdomain.com'
    'secure' => true,   // true in production (HTTPS only)
    'httponly' => true, // JavaScript CANNOT access this cookie (Stops XSS stealing sessions)
    'samesite' => 'Strict' // Prevents CSRF
]);

session_start();

// 2. Session Fixation Defense
// If logging a user in, ALWAYS regenerate the ID to invalidate old session tokens
if (isset($_GET['login']) && !isset($_SESSION['user_id'])) {
    session_regenerate_id(true); // true deletes the old session file
    $_SESSION['user_id'] = 404;
    $_SESSION['role'] = 'admin';
    echo "Logged in securely! Session ID regenerated.<br>";
}

echo "Current Session ID: " . session_id() . "<br>";
var_dump($_SESSION);

// 3. Complete Destruction
if (isset($_GET['logout'])) {
    session_unset(); // Unset $_SESSION variable
    session_destroy(); // Destroy session data on the server
    // Clear the cookie header
    setcookie(session_name(), '', time() - 3600, '/');
    echo "Logged out fully.";
}
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 13 Project: Secure File Vault - Auth Layer
 * 
 * We build the Login simulation that guards our File Vault project.
 */

session_start();

$authError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Hardcoded credentials for simulation (Never do this in prod!)
    if ($user === 'admin' && $pass === 'secret') {
        session_regenerate_id(true); // Security Standard!
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = $user;
        header("Location: ?page=vault");
        exit;
    } else {
        $authError = "Invalid credentials.";
    }
}

// Simulated App Routing based on Session state
$page = $_GET['page'] ?? 'login';

if ($page === 'vault') {
    if (empty($_SESSION['vault_access'])) {
        die("<h2 style='color:red;'>Access Denied. You must log in.</h2> <a href='?page=login'>Go Login</a>");
    }
    echo "<h2>Welcome to the Secure File Vault, " . htmlspecialchars($_SESSION['user']) . "</h2>";
    echo "<p>Your sensitive files would be listed here.</p>";
    echo "<a href='?page=logout'>Logout</a>";
    exit;
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
    exit;
}
?>

<h2>File Vault Login</h2>
<?php if ($authError) echo "<p style='color:red;'>$authError</p>"; ?>
<form method="POST">
    <label>Username: <input type="text" name="username"></label><br><br>
    <label>Password: <input type="password" name="password"></label><br><br>
    <button type="submit">Enter Vault</button>
</form>
<small>Hint: admin / secret</small>
EOT
    ],
    14 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 14: Cookies and Persistent Tracking (1.5 Hours)
 * Topics:
 * - Setting complex cookies
 * - "Remember Me" Architecture concept
 * - Security constraints
 */

// 1. Setting a Cookie with robust security arrays (PHP 7.3+)
$cookieName = 'app_theme';
$cookieValue = 'dark_mode';

// It is best practice to pass options as an array
setcookie($cookieName, $cookieValue, [
    'expires' => time() + (86400 * 30), // 30 Days
    'path' => '/',
    'domain' => '', 
    'secure' => false, // Set to true if on HTTPS
    'httponly' => true, // VERY IMPORTANT: Scripts can't read this cookie
    'samesite' => 'Lax'
]);

echo "<h3>Cookie Management</h3>";

if (isset($_COOKIE[$cookieName])) {
    echo "Current Theme Preference: <strong>" . htmlspecialchars($_COOKIE[$cookieName]) . "</strong><br>";
} else {
    echo "Theme Preference Cookie is setting... Re-run to see it.<br>";
}

// 2. Encryption conceptually
// NEVER store raw passwords or user roles in a cookie.
// If you build a "Remember Me" token, store a random hash in the cookie,
// and map that hash to a user ID in the database!
$rememberToken = bin2hex(random_bytes(32)); 
echo "<br>Example Secure Remember Token: $rememberToken (Store this string in DB and Cookie, NOT their password).";
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 14 Project: Secure File Vault - Remember Session
 * 
 * We check if a theoretical remember_token cookie is active and 
 * automatically set the session state if valid, bypassing the login form.
 */

session_start();

// Simulating the DB Check
$validDatabaseToken = "abc123securetokenXYZ";

// 1. If not logged in via Session, check the Cookie!
if (empty($_SESSION['vault_access']) && isset($_COOKIE['remember_me'])) {
    
    $clientToken = $_COOKIE['remember_me'];
    
    // In reality, this would be a DB query: SELECT user_id FROM tokens WHERE token = ?
    if ($clientToken === $validDatabaseToken) {
        // Auto-login!
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = 'admin_via_cookie';
        
        echo "<p style='color:green;'>Auto-logged in using 'Remember Me' Cookie!</p>";
    } else {
        // Invalid token! Destroy the malicious/expired cookie
        setcookie('remember_me', '', time() - 3600, '/');
    }
}

// Route check
$page = $_GET['page'] ?? 'home';

if ($page === 'set_cookie') {
    // Simulate checking the "Remember Me" box during login
    setcookie('remember_me', $validDatabaseToken, time() + 3600, '/', '', false, true);
    echo "Cookie set! <a href='?page=home'>Go to Vault.</a>";
    exit;
}

if (!empty($_SESSION['vault_access'])) {
    echo "<h2>File Vault (Remember Me Active)</h2>";
    echo "<p>Welcome back, {$_SESSION['user']}.</p>";
} else {
    echo "<h2>Access Denied</h2>";
    echo "<p>You are not logged in. <a href='?page=set_cookie'>Click to simulate checking 'Remember Me' box.</a></p>";
}
EOT
    ],
    15 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 15: Deep File System and Streams (1.5 Hours)
 * Topics:
 * - fopen, fread, fclose
 * - Exclusive Locks (flock) to prevent Race Conditions
 * - Directory reading
 */

$logFile = 'audit.log';

echo "<h3>File System Fundamentals</h3>";

// 1. Using File Streams manually instead of file_put_contents
// This is critical for massive files to avoid memory exhaustion!
$handle = fopen($logFile, 'a'); // 'a' = append mode
if ($handle) {
    // 2. Race Conditions & Locking
    // What if 20 users hit this script at the exact same millisecond? 
    // Data corruption. We MUST use flock() for shared files.
    if (flock($handle, LOCK_EX)) { // Exclusive Lock
        fwrite($handle, "User accessed system at " . date('H:i:s') . "\n");
        flock($handle, LOCK_UN); // Unlock
    } else {
        echo "Could not lock the file!<br>";
    }
    fclose($handle);
}

// 3. Reading line by line (Memory Efficient!)
if (file_exists($logFile)) {
    echo "<h4>Audit Log Contents:</h4><div style='background:#f4f4f4; padding:10px; font-family:monospace;'>";
    $readHandle = fopen($logFile, 'r');
    while (($line = fgets($readHandle)) !== false) {
        echo htmlspecialchars($line) . "<br>";
    }
    fclose($readHandle);
    echo "</div>";
}
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 15 Project: Secure File Vault - Activity Logger
 * 
 * Every time the vault is accessed, we must log it securely using locks.
 * We will abstract this into a robust FileLogger class-like function structure.
 */

// Abstraction for Logging to avoid code duplication across the app
function writeVaultLog(string $action, string $user): void {
    $logDirectory = __DIR__ . '/secure_logs';
    
    // Create directory securely if it doesn't exist
    if (!is_dir($logDirectory)) {
        mkdir($logDirectory, 0700, true); // 0700 means ONLY the server owner can read it
    }
    
    $filePath = $logDirectory . '/vault_activity.log';
    $entry = sprintf("[%s] USER: %s | ACTION: %s\n", date('Y-m-d H:i:s'), $user, $action);
    
    // file_put_contents supports LOCK_EX seamlessly as a flag!
    file_put_contents($filePath, $entry, FILE_APPEND | LOCK_EX);
}

// Simulate Vault Activity
writeVaultLog('VIEW_DOCUMENT', 'admin_jane');
writeVaultLog('DOWNLOAD_FILE', 'admin_jane');

echo "<h2>Vault Activity Triggered</h2>";
echo "<p>Logs have been securely appended to <code>secure_logs/vault_activity.log</code> using Exclusive Locks.</p>";
EOT
    ],
    16 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 16: File Uploads Security Deep Dive (1.5 Hours)
 * Topics:
 * - $_FILES array internals and UPLOAD_ERR constants
 * - finfo MIME type checking (NEVER trust $_FILES['type']!)
 * - Securing the upload directory
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    
    $file = $_FILES['document'];
    
    // 1. Check for PHP's internal upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code: " . $file['error']);
    }

    // 2. NEVER TRUST client-provided info ($file['type'] or the extension).
    // An attacker might rename `shell.php` to `shell.jpg` to bypass checks!
    
    // Use finfo to read the ACTUAL bytes of the file to determine MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $realMimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    $allowedMimes = [
        'application/pdf' => 'pdf',
        'image/jpeg'      => 'jpg',
        'image/png'       => 'png'
    ];

    if (!array_key_exists($realMimeType, $allowedMimes)) {
        die("Security Warning: Invalid file format detected ($realMimeType).");
    }

    // 3. Generate a secure, randomized filename to prevent overwriting and injection
    $extension = $allowedMimes[$realMimeType];
    $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
    
    // 4. Move the file
    $uploadDir = __DIR__ . '/uploads/';
    @mkdir($uploadDir, 0755);
    
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
        echo "<h3 style='color:green;'>File secured and saved as $safeName</h3>";
    }
}
?>

<h3>Secure File Uploader</h3>
<form method="POST" enctype="multipart/form-data">
    <!-- MAX_FILE_SIZE is a suggestion to the browser, PHP configs ultimately override this -->
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000"> 
    <input type="file" name="document" required><br><br>
    <button type="submit">Upload Securely</button>
</form>
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 16 Project: Secure File Vault - Document Deposit
 * 
 * Storing uploaded files in a directory that is strictly inaccessible to the public web.
 * (This simulates uploading outside public_html in a real server environment).
 */

$vaultStorage = __DIR__ . '/private_vault_data';
@mkdir($vaultStorage, 0700);

// We drop an .htaccess file in the vault to completely disable execution and web access!
$htaccess = "Order Deny,Allow\nDeny from all";
if (!file_exists("$vaultStorage/.htaccess")) {
    file_put_contents("$vaultStorage/.htaccess", $htaccess);
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['vault_file'])) {
    
    $tmpName = $_FILES['vault_file']['tmp_name'];
    
    if (is_uploaded_file($tmpName)) {
        // We clean the original file name to keep a reference
        $safeOriginalName = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $_FILES['vault_file']['name']);
        
        $destination = $vaultStorage . '/' . time() . '_' . $safeOriginalName;
        
        if (move_uploaded_file($tmpName, $destination)) {
            $msg = "File securely locked in vault: $safeOriginalName";
        }
    }
}
?>

<h2>File Vault: Deposit Document</h2>
<?= $msg ? "<div style='color:green; font-weight:bold; border:1px solid green; padding:10px;'>$msg</div>" : '' ?>

<p>Files uploaded here are placed in <code>private_vault_data</code> alongside an .htaccess block.</p>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="vault_file" required>
    <button type="submit">Encrypt & Deposit</button>
</form>
EOT
    ],
    17 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 17: Object-Oriented Programming (OOP) Introduction (1.5 Hours)
 * Topics:
 * - Classes, Objects, Properties, Methods
 * - The $this keyword (Object Context)
 * - Encapsulation (Why properties shouldn't be publicly accessible directly)
 * - stdClass and dynamic properties (Deprecated in 8.2)
 */

class BankAccount {
    // Encapsulation. The balance shouldn't be modifiable from the outside!
    private float $balance = 0.0;
    private string $owner;

    // Initialization logic
    public function __construct(string $owner) {
        $this->owner = $owner;
    }

    // Public API to interact with the private state safely
    public function deposit(float $amount): void {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Deposit amount must be positive.");
        }
        $this->balance += $amount;
        echo "Deposited $$amount for {$this->owner}.<br>";
    }

    public function getBalance(): float {
        return $this->balance;
    }
}

$account = new BankAccount('Alice');
$account->deposit(150.50);

// $account->balance = 5000; // FATAL ERROR: Cannot access private property
echo "Secure Balance: $" . $account->getBalance() . "<hr>";

// Basic stdClass (Useful for JSON parsing)
$genericObject = new stdClass();
$genericObject->dynamicTrait = "I am allowed but unstructured!";
echo $genericObject->dynamicTrait;
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 17 Project: Character Generator API
 * 
 * We start architecting our Character API using proper OOP models.
 * State encapsulates the character's base stats.
 */

class Character {
    private string $name;
    private int $hp;
    private int $strength;
    private int $agility;

    public function __construct(string $name) {
        $this->name = $name;
        $this->rollStats();
    }

    /**
     * Private method. Cannot be called outside this class.
     * We don't want external scripts re-rolling stats arbitrarily!
     */
    private function rollStats(): void {
        $this->hp = rand(80, 150);
        $this->strength = rand(5, 20);
        $this->agility = rand(5, 20);
    }

    public function getProfile(): array {
        return [
            'name' => $this->name,
            'health_points' => $this->hp,
            'str' => $this->strength,
            'agi' => $this->agility,
            'status' => 'Alive'
        ];
    }
}

// Instantiate and simulate API output
$hero = new Character("Gimli The Brave");
$enemy = new Character("Goblin Scout");

echo "<h3>Game State Setup</h3>";
echo "<strong>Hero:</strong><br><pre>" . print_r($hero->getProfile(), true) . "</pre>";
echo "<strong>Enemy:</strong><br><pre>" . print_r($enemy->getProfile(), true) . "</pre>";
EOT
    ],
    18 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 18: Advanced Instantiation (1.5 Hours)
 * Topics:
 * - Readonly Properties (PHP 8.1+)
 * - Constructor Property Promotion (PHP 8.0+)
 * - Destructors (__destruct)
 * - Typed Properties 
 */

class DatabaseConnection {
    // 1. Readonly properties can be initialized ONCE, and never changed again!
    // 2. Promotion: We declare properties directly inside the constructor signature!
    public function __construct(
        public readonly string $dsn,
        public readonly string $user,
        private string $password // Private and NOT readonly, so we can change it internally if needed
    ) {
        echo "[LOG] Attempting to connect to {$this->dsn}...<br>";
    }

    // 3. Destructors fire automatically when the object is deleted or script ends.
    // Extremely useful for closing database connections or file handles!
    public function __destruct() {
        echo "[LOG] Closing connection to {$this->dsn}...<br>";
    }
}

echo "<h3>Constructor Promotion & Destructor Lifecycle</h3>";

$db = new DatabaseConnection('mysql:host=localhost;dbname=app', 'root', 'secret');

// $db->dsn = 'hacked_db'; // Error! Readonly property cannot be modified!
// $db->password;          // Error! Private property!

echo "Using Database inside application scope...<br>";

// Manual destruction will force the destructor to run IMMEDIATELY!
unset($db); 

echo "End of script line.<br>";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 18 Project: Character Generator API - Inventory System
 * 
 * Using Constructor Promotion and tightly coupled objects (Dependency Injection).
 */

class Weapon {
    public function __construct(
        public readonly string $name,
        public readonly int $damage
    ) {}
}

class Inventory {
    // Typed array to guarantee only Weapons exist (pseudo-generics)
    private array $weapons = [];

    public function addWeapon(Weapon $weapon): void {
        $this->weapons[] = $weapon;
    }

    public function getTotalDamage(): int {
        return array_reduce($this->weapons, fn($sum, $w) => $sum + $w->damage, 0);
    }
    
    public function getList(): array {
        return array_map(fn($w) => "{$w->name} (Dmg: {$w->damage})", $this->weapons);
    }
}

// Main Character class passing IN the inventory system
class Knight {
    public function __construct(
        public readonly string $name,
        private Inventory $inventory // Composition! An Object holding an Object.
    ) {}

    public function getCombatPower(): int {
        // Base power 10 + Weapon power
        return 10 + $this->inventory->getTotalDamage();
    }
    
    public function getInventory(): array {
         return $this->inventory->getList();
    }
}

$pouch = new Inventory();
$pouch->addWeapon(new Weapon('Iron Sword', 15));
$pouch->addWeapon(new Weapon('Steel Dagger', 8));

$sirLancelot = new Knight('Lancelot', $pouch);

echo "<h3>Knight Loadout</h3>";
echo "Name: {$sirLancelot->name}<br>";
echo "Total Combat Power: {$sirLancelot->getCombatPower()}<br>";
echo "Items:<br><pre>" . print_r($sirLancelot->getInventory(), true) . "</pre>";
EOT
    ],
    19 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 19: Inheritance Architecture (1.5 Hours)
 * Topics:
 * - Protected vs Private visibility across extends
 * - parent:: method overriding
 * - 'final' classes preventing inheritance
 * - The 'instanceof' type verifier
 */

// A locked class that CANNOT be extended! Used for core security logic.
final class SecurityEngine {
    public function checkHash() { return true; }
}
// class MyEngine extends SecurityEngine {} // FATAL ERROR!

class Document {
    protected string $title; // Notice protected allows children to read/write this. Private blocks them.

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function render(): string {
        return "<h1>{$this->title}</h1>";
    }
}

class PdfDocument extends Document {
    public function render(): string {
        // Polymorphism/Overriding: We call the parent's base logic, then ADD to it.
        $base = parent::render();
        return "<div style='background:red; color:white; padding:10px;'>[PDF RENDER ENGINE]</div>" . $base;
    }
}

$doc = new PdfDocument("Invoice #12345");
echo $doc->render();

// Strict type checking across the inheritance tree
echo "<br>";
echo "Is it a PdfDocument? " . ($doc instanceof PdfDocument ? 'Yes' : 'No') . "<br>";
echo "Is it a Document? " . ($doc instanceof Document ? 'Yes' : 'No') . " (Because it extends it!)<br>";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 19 Project: Character Generator API - Classes & Races
 * 
 * Implementing Character Subclasses using polymorphic overrides.
 */

class BaseCharacter {
    protected string $name;
    protected int $health = 100;
    protected int $mana = 50;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getStatus(): string {
        return "[{$this->name}] HP: {$this->health} | MP: {$this->mana}";
    }

    public function attack(): string {
        return "{$this->name} swings a basic attack for 5 damage.";
    }
}

class Mage extends BaseCharacter {
    public function __construct(string $name) {
        parent::__construct($name);
        // Mages get different base stats
        $this->health = 60;
        $this->mana = 200;
    }

    // Overriding the attack method completely
    public function attack(): string {
        if ($this->mana >= 20) {
            $this->mana -= 20;
            return "{$this->name} casts FIREBALL for 45 damage! (-20 MP)";
        }
        return parent::attack(); // Fallback to basic attack
    }
}

class Warrior extends BaseCharacter {
    // Warriors have high HP, low mana
    public function __construct(string $name) {
        parent::__construct($name);
        $this->health = 200;
        $this->mana = 10;
    }
}

$gandalf = new Mage("Gandalf");
$aragorn = new Warrior("Aragorn");

echo "<h3>Battle Log</h3>";
echo "<strong>Initial States:</strong><br>";
echo $gandalf->getStatus() . "<br>";
echo $aragorn->getStatus() . "<br><br>";

echo "<strong>Turn 1:</strong><br>";
echo $gandalf->attack() . "<br>"; // Uses magic
echo $aragorn->attack() . "<br>"; // Basic swing

echo "<br><strong>Current States:</strong><br>";
echo $gandalf->getStatus() . " (Notice mana is drained)<br>";
EOT
    ],
    20 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 20: Interfaces, Abstract Classes, and Traits (1.5 Hours)
 * Topics:
 * - Interfaces as structural contracts
 * - Abstract classes as partial implementations
 * - Traits for horizontal code sharing (multiple inheritance workaround)
 */

// 1. Interface (A strict contract of methods)
interface PaymentGatewayInterface {
    public function processPayment(float $amount): bool;
}

class StripeGateway implements PaymentGatewayInterface {
    public function processPayment(float $amount): bool {
        echo "Processing $$amount through Stripe API...<br>";
        return true;
    }
}

// 2. Abstract Class (Forces structure, but allows default logic)
abstract class Animal {
    abstract public function makeSound(): string; // Must be implemented
    
    public function sleep(): void {
        echo "Zzz...<br>"; // Default logic shared by all
    }
}
class Cat extends Animal {
    public function makeSound(): string { return "Meow!"; }
}
$cat = new Cat();
echo $cat->makeSound() . "<br>";
$cat->sleep();

// 3. Traits (Injecting methods horizontally)
trait LoggerTrait {
    public function log(string $msg) {
        echo "[LOG] $msg <br>";
    }
}

class UserAuth {
    use LoggerTrait;
    public function login() {
        $this->log("User logged in.");
    }
}

$auth = new UserAuth();
$auth->login();
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 20 Project: Character Generator API - Systems Architecture
 * 
 * We enforce Game Architecture perfectly using Interfaces. 
 * Characters can only equip items that implement the EquippableInterface.
 */

interface EquippableInterface {
    public function getStatBonus(): int;
    public function getEquipSlot(): string;
}

class Helmet implements EquippableInterface {
    public function getStatBonus(): int { return 15; } // +15 Defense
    public function getEquipSlot(): string { return 'head'; }
}

class HealthPotion {
    // This is consumable, NOT equippable!
    public function heal(): int { return 50; }
}

class Hero {
    private array $equipment = [];

    // Type hinting the INTERFACE directly! 
    // This guarantees the object passed has getStatBonus() and getEquipSlot()!
    public function equip(EquippableInterface $item): void {
        $slot = $item->getEquipSlot();
        $this->equipment[$slot] = $item;
        
        echo "Equipped item gracefully! Bonus added: +{$item->getStatBonus()} towards $slot armor.<br>";
    }
}

echo "<h3>Game Inventory Logic</h3>";
$hero = new Hero();
$ironHelm = new Helmet();
$potion = new HealthPotion();

// Success!
$hero->equip($ironHelm);

// Type Error!
// $hero->equip($potion); // FATAL ERROR: HealthPotion must implement EquippableInterface

echo "<br><i>The interface ensures completely different classes share the exact required methods for our engine.</i>";
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
echo "Advanced Weeks 11-20 examples populated successfully.\n";
