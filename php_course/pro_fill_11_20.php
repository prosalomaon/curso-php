<?php
/**
 * Professional PHP Code Populate Tool - Weeks 11 to 20
 * Separates MVC logic from Views and uses the global Header/Footer.
 */

$examples = [
  11 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 11: Deep Dive into Superglobals";

$serverData = [
    'IP Address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
    'User Agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown CLI',
    'HTTP Method' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
    'Request URI' => $_SERVER['REQUEST_URI'] ?? '/'
];

// Always sanitize GET before dumping it into HTML!
$cleanQuery = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Environment State via <code>$_SERVER</code></h2>
    <p>PHP automatically builds a massive associative array containing everything about the current web request.</p>
</div>

<table>
    <thead><tr><th>Property Name</th><th>Detected Value</th></tr></thead>
    <tbody>
        <?php foreach ($serverData as $key => $val): ?>
            <tr><td><strong><?= htmlspecialchars($key) ?></strong></td><td><code><?= htmlspecialchars($val) ?></code></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="content-box">
    <h3>Safe Search Filter (<code>$_GET</code>)</h3>
    <form method="GET" style="display:flex; gap:10px;">
        <input type="text" name="q" value="<?= $cleanQuery ?>" placeholder="Try passing <script>alert(1)</script>">
        <button type="submit" style="white-space:nowrap;">Search Action</button>
    </form>
    
    <?php if ($cleanQuery): ?>
        <p>You safely searched for: <strong><?= $cleanQuery ?></strong></p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 11 Project: Task Manager Routing via GET";

// 1. Data Retrieval
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';
$taskId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// 2. Controller Routing
// Using Match to enforce strict architecture over query strings
$outputMessage = match($action) {
    'list'   => "Listing all active tasks in the system...",
    'view'   => $taskId ? "Viewing complex details for Task #{$taskId}" : "Error: Missing Task ID",
    'delete' => $taskId ? "[CRITICAL] Emulating permanent deletion of Task #{$taskId}!" : "Error: Missing Task ID",
    default  => "Unknown route requested: {$action}"
};

$statusClass = str_starts_with($outputMessage, 'Error') ? 'error-box' : (str_starts_with($outputMessage, '[CRITICAL]') ? 'error-box' : 'success-box');

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Query String Controller</h2>
    <p>We use <code>?action=xxx</code> to instruct the PHP file what block of logic to execute, essentially creating a rudimentary API router!</p>
</div>

<div class="<?= $statusClass ?>">
    <strong>Application State:</strong> <?= htmlspecialchars($outputMessage) ?>
</div>

<h3>Simulate Incoming Requests:</h3>
<ul>
    <li><a href="?action=list"><strong>GET</strong> /tasks (List)</a></li>
    <li><a href="?action=view&id=88"><strong>GET</strong> /tasks/88 (View)</a></li>
    <li><a href="?action=delete&id=88"><strong>DELETE</strong> /tasks/88 (Delete)</a></li>
    <li><a href="?action=hax&id=1"><strong>GET</strong> /tasks/hax (Invalid Route)</a></li>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  12 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 12: Advanced Forms and Validation";

$errors = [];
$successMessage = '';
$submittedData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Validate Email rigorously
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors['email'] = 'A mathematically valid email structure is strictly required.';
    }

    // 2. Validate Age range
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 18, 'max_range' => 120]
    ]);
    if ($age === false) {
        $errors['age'] = 'Access restricted: You must provide a valid integer between 18 and 120.';
    }

    // 3. Evaluate state
    if (empty($errors)) {
        $successMessage = "Database Insert Simulation Successful!";
        $submittedData = ['email' => $email, 'age' => $age];
        
        // In reality, implement PRG (Post-Redirect-Get): 
        // header("Location: ?success=1"); exit;
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Secure Data Extraction Pipeline</h2>
    <p>Never trust user input. Ensure data strictly matches system constraints before allowing Database touches.</p>
</div>

<?php if ($successMessage): ?>
    <div class="success-box">
        <h4><?= htmlspecialchars($successMessage) ?></h4>
        <p><strong>Payload Secured:</strong> <?= htmlspecialchars($submittedData['email']) ?> (Age: <?= $submittedData['age'] ?>)</p>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <div style="margin-bottom:15px;">
        <label>Operator Email Address:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="off">
        <?php if (isset($errors['email'])) echo "<div style='color:red; font-size:0.9em;'>{$errors['email']}</div>"; ?>
    </div>
    
    <div style="margin-bottom:15px;">
        <label>Operator Age Component:</label>
        <input type="number" name="age" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">
        <?php if (isset($errors['age'])) echo "<div style='color:red; font-size:0.9em;'>{$errors['age']}</div>"; ?>
    </div>
    
    <button type="submit">Execute Insertion Payload</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 12 Project: Task Manager Form Construction";

$errors = [];
$title = $_POST['title'] ?? '';
$priority = $_POST['priority'] ?? '1';
$creationSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($title);
    if (mb_strlen($title) < 5) {
        $errors['title'] = 'Architectural Exception: Title length must bridge 5 characters minimum.';
    }

    $priorityInt = filter_input(INPUT_POST, 'priority', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 3]
    ]);
    if ($priorityInt === false) {
        $errors['priority'] = 'System Error: Unauthorized priority flag.';
    }

    if (empty($errors)) {
        $creationSuccess = true;
        $title = ''; 
        $priority = '1';
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Issue Tracker Creation Wizard</h2>
</div>

<?php if ($creationSuccess): ?>
    <div class="success-box">Ticket established and dispatched successfully to the worker queue.</div>
<?php endif; ?>

<form method="POST" class="content-box" style="border:2px dashed var(--border-color);">
    <label>Task Nomenclature:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="e.g. Refactor API controllers">
    <?php if (isset($errors['title'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['title']}</div>"; ?>
    
    <label>Severity Tier:</label>
    <select name="priority">
        <option value="1" <?= $priority === '1' ? 'selected' : '' ?>>Tier 1: Minor (Low)</option>
        <option value="2" <?= $priority === '2' ? 'selected' : '' ?>>Tier 2: Standard (Medium)</option>
        <option value="3" <?= $priority === '3' ? 'selected' : '' ?>>Tier 3: Critical (High)</option>
    </select>
    <?php if (isset($errors['priority'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['priority']}</div>"; ?>

    <button type="submit" style="width:100%;">Create Task Node</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  13 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 13: Session Security and State Management";

// 1. Mandatory Security Directives BEFORE opening the session engine!
session_set_cookie_params([
    'lifetime' => 3600, // TimeToLive (Seconds)
    'path' => '/',
    'domain' => '', 
    'secure' => false,  // True in production! Prevents interception over HTTP.
    'httponly' => true, // Prevents XSS Javascript from reading the session.
    'samesite' => 'Lax'
]);

session_start();
$actionLog = [];

if (isset($_GET['login']) && empty($_SESSION['user_id'])) {
    // Session Fixation Prevention
    session_regenerate_id(true); 
    $_SESSION['user_id'] = mt_rand(1000, 9999);
    $_SESSION['role'] = 'SUPER_ADMIN';
    $actionLog[] = "Authentication Authorized. Session Identity completely regenerated.";
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/'); // Nuke the client-side reference
    $actionLog[] = "Session purged. Client cookie destroyed. Re-execution required.";
}

$stateActive = !empty($_SESSION['user_id']);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Secure Session Lifecycle</h2>
    <p>PHP handles session mechanics automatically, but requires strict tuning to avoid Hijacking and Fixation exploits.</p>
</div>

<?php foreach ($actionLog as $log): ?>
    <div class="success-box"><?= htmlspecialchars($log) ?></div>
<?php endforeach; ?>

<div class="info-box">
    <strong>Internal Pointer (Session ID):</strong> <code><?= htmlspecialchars(session_id() ?: 'NONE') ?></code><br>
    <?php if ($stateActive): ?>
        <strong>User ID:</strong> <?= $_SESSION['user_id'] ?> |
        <strong>Global Role:</strong> <?= $_SESSION['role'] ?>
    <?php else: ?>
        <strong>Auth State:</strong> UNIDENTIFIED GUEST
    <?php endif; ?>
</div>

<div style="display:flex; gap:10px;">
    <?php if (!$stateActive): ?>
        <a href="?login=1"><button>Simulate Secure Login</button></a>
    <?php else: ?>
        <a href="?logout=1"><button style="background:red;">Purge Session (Logout)</button></a>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 13 Project: Secure File Vault Router";

session_start();
$authError = null;
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'login';

// Form Logic Check
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Hardcoded dev credentials
    if ($user === 'admin' && $pass === 'secret') {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = $user;
        
        // Post-Redirect-Get implementation
        header("Location: ?page=vault_dashboard");
        exit;
    } else {
        $authError = "Critical Auth Failure: Credentials do not match database.";
    }
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
    exit;
}

// Router Gate
$isVaultViewing = ($page === 'vault_dashboard');
if ($isVaultViewing && empty($_SESSION['vault_access'])) {
    // 403 Forbidden Simulation
    http_response_code(403);
    $page = '403';
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->

<?php if ($page === 'login'): ?>
    <div class="content-box">
        <h2>File Vault Authentication</h2>
    </div>

    <?php if ($authError): ?>
        <div class="error-box"><?= htmlspecialchars($authError) ?></div>
    <?php endif; ?>

    <form method="POST" class="content-box" style="margin: 0 auto; max-width:400px; background:var(--hover-bg);">
        <label>Operator Identification:</label>
        <input type="text" name="username" required>
        
        <label>Passphrase:</label>
        <input type="password" name="password" required>
        
        <button type="submit" style="width:100%;">Authorize Access</button>
        <small style="display:block; text-align:center; margin-top:15px;">Target: admin / secret</small>
    </form>

<?php elseif ($page === 'vault_dashboard'): ?>
    <div class="success-box" style="text-align:center;">
        <h2 style="margin:0;">VAULT ACCESS GRANTED</h2>
        <p style="text-transform:uppercase;">OPERATOR: <?= htmlspecialchars($_SESSION['user']) ?></p>
    </div>
    
    <table style="width:100%; font-family:monospace;">
        <tr><th>File Name</th><th>Security Level</th><th>Actions</th></tr>
        <tr><td>core_infrastructure.pdf</td><td>LEVEL_OMEGA</td><td>[ENCRYPTED]</td></tr>
        <tr><td>customer_hashes.csv</td><td>LEVEL_ALPHA</td><td>[ENCRYPTED]</td></tr>
    </table>
    
    <div style="text-align:center;">
        <a href="?page=logout"><button style="background:red;">Terminate Session</button></a>
    </div>

<?php elseif ($page === '403'): ?>
    <div class="error-box" style="text-align:center; padding:50px;">
        <h1 style="font-size:3em; margin:0;">HTTP 403</h1>
        <p>FORBIDDEN: You must authenticate to view this sector.</p>
        <a href="?page=login" style="color:var(--text-color); font-weight:bold;">[ RETURN TO AUTHORIZATION GATE ]</a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  14 => [
    'ex1' => <<<'EOT'
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 14 Project: The 'Remember Me' Vault Token";

session_start();

$validDatabaseToken = "7a4f9x1wB_secure_hash_string";
$msg = null;

// The Auto-Login Engine!
if (empty($_SESSION['vault_access']) && isset($_COOKIE['remember_me'])) {
    
    // DB Check simulation: SELECT user_id FROM tokens WHERE token = ?
    if ($_COOKIE['remember_me'] === $validDatabaseToken) {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = 'phantom_admin';
        $msg = "[AUTHD] Session fully reconstructed via cryptographic cookie payload.";
    } else {
        // Punish invalid tokens by invalidating them
        setcookie('remember_me', '', time() - 3600, '/');
    }
}

// Routes
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'home';

if ($page === 'set_cookie') {
    // Simulating checking the 'Remember Me' box
    setcookie('remember_me', $validDatabaseToken, time() + 3600, '/', '', false, true); // true = HttpOnly
    header("Location: ?page=home&status=cookie_set");
    exit;
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    setcookie('remember_me', '', time() - 3600, '/'); // Nuke the remember token too!
    header("Location: ?page=home");
    exit;
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Persistent Vault Authentication</h2>
</div>

<?php if ($msg): ?>
    <div class="success-box"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if (($_GET['status'] ?? '') === 'cookie_set'): ?>
    <div class="info-box">Long-term Cookie deployed. Close this browser and reopen it, and the system will bypass the login automatically.</div>
<?php endif; ?>

<?php if (!empty($_SESSION['vault_access'])): ?>
    <div class="content-box" style="text-align:center;">
        <h3>Welcome inside the Vault, <?= htmlspecialchars($_SESSION['user']) ?></h3>
        <p>You are fully authenticated.</p>
        <a href="?page=logout"><button style="background:red;">Logout completely (Erases Cookies)</button></a>
    </div>
<?php else: ?>
    <div class="error-box" style="text-align:center;">
        <h3>Authorization Check Failed</h3>
        <p>You have no active session and no Cookie payload.</p>
        <a href="?page=set_cookie"><button>Simulate 'Remember Me' Login</button></a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  15 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 15: File Systems, Streams, and Exclusive Locks";

$logFile = __DIR__ . '/audit_temp.log';
$status = null;
$logHistory = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proper File Stream Usage
    $handle = fopen($logFile, 'a'); // Open for appending
    
    if ($handle) {
        // Critical: Using LOCK_EX to prevent File Corruption if 1,000 users hit this instantly!
        if (flock($handle, LOCK_EX)) {
            $msg = sprintf("[%s] Security Ping from User\n", date('H:i:s'));
            fwrite($handle, $msg);
            flock($handle, LOCK_UN); // Release the lock immediately to free up server
            $status = "Audit Log appended safely.";
        } else {
            $status = "CRITICAL ERROR: Failed to acquire file lock.";
        }
        fclose($handle); // Always clean up your handles!
    }
}

// Read logic utilizing memory efficiency
if (file_exists($logFile)) {
    $readHandle = fopen($logFile, 'r');
    if ($readHandle) {
        // fgets reads one line at a time. This prevents RAM exhaustion on a 10GB file!
        while (($line = fgets($readHandle)) !== false) {
            $logHistory[] = trim($line);
        }
        fclose($readHandle);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Native File Streams</h2>
    <p>Using <code>fopen()</code> and <code>flock()</code> guarantees that we never suffer from race conditions under heavy load.</p>
</div>

<?php if ($status): ?>
    <div class="success-box"><?= htmlspecialchars($status) ?></div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit">Ping the Network Audit Log</button>
</form>

<?php if ($logHistory): ?>
    <h3>Live Server Log Tracking:</h3>
    <pre style="background:#000; color:#0f0; padding:15px;">
<?php foreach ($logHistory as $entry): ?>
>> <?= htmlspecialchars($entry) . "\n" ?>
<?php endforeach; ?>
    </pre>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  16 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 16: File Upload Security Deep Dive";

$status = null;
$errorStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['payload'])) {
    
    $file = $_FILES['payload'];
    
    // 1. Base engine check
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorStatus = "Upload Engine Failure Code: " . $file['error'];
    } else {
        // 2. DO NOT TRUST THE EXTENSION OR THE CLIENT'S MIME TYPE! ($file['type'])
        // Use PHP's internal finfo_file to read the ACTUAL bytes of the file memory!
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowedType = 'application/pdf';

        if ($realMimeType !== $allowedType) {
            $errorStatus = "SECURITY CHECK FAILED: Expected PDF, but received [{$realMimeType}]. Payloads blocked.";
        } else {
            // 3. Cryptographic Renaming (Never use the user's name format!)
            $safeName = bin2hex(random_bytes(16)) . '.pdf';
            $uploadDir = __DIR__ . '/temp_secure/';
            @mkdir($uploadDir, 0755); // Suppress warning if exists
            
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
                $status = "File verified mathematically, renamed to [{$safeName}], and transferred to Vault.";
            } else {
                $errorStatus = "Internal System error moving the temporary file to persistent storage.";
            }
        }
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Impenetrable Upload Engine</h2>
    <p>File uploads are terrifying. An attacker can upload <code>shell.php</code> disguised as <code>image.png</code> and take over the server instantly. We must combat this deeply.</p>
</div>

<?php if ($status): ?>
    <div class="success-box"><?= htmlspecialchars($status) ?></div>
<?php endif; ?>
<?php if ($errorStatus): ?>
    <div class="error-box"><?= htmlspecialchars($errorStatus) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="content-box" style="background:var(--hover-bg);">
    <p style="margin-top:0;"><strong>Mandatory Format:</strong> Valid PDF Document Only.</p>
    
    <!-- Tell the browser the soft-limit (Doesn't override php.ini limits!) -->
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000"> 
    
    <label>Select Target Document:</label>
    <input type="file" name="payload" required>
    
    <button type="submit">Establish Secure Transfer</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 16 Project: Vault Deposit Endpoint";

$vaultStorage = __DIR__ . '/private_vault_data';
$msg = null;

// Initializing the Vault Area
if (!is_dir($vaultStorage)) { @mkdir($vaultStorage, 0700); }

// Creating the execution blocker!
$htaccessNode = "Order Deny,Allow\nDeny from all";
if (!file_exists("$vaultStorage/.htaccess")) {
    file_put_contents("$vaultStorage/.htaccess", $htaccessNode);
}

// Processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['vault_doc'])) {
    $tmpName = $_FILES['vault_doc']['tmp_name'];
    
    // Ensure the file is a legal PHP upload (Prevents manipulating $tmpName)
    if (is_uploaded_file($tmpName)) {
        // We strip absolutely everything except letters and numbers
        $rawName = $_FILES['vault_doc']['name'];
        $safeOriginalName = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $rawName);
        
        $destination = $vaultStorage . '/' . date('Y_m_d_His_') . $safeOriginalName;
        
        if (move_uploaded_file($tmpName, $destination)) {
            $msg = "Payload `{$safeOriginalName}` injected into private storage successfully.";
        }
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Secure Vault Document Deposit</h2>
    <p>Anything placed in the vault is heavily guarded. A custom `.htaccess` file prevents arbitrary remote execution.</p>
</div>

<?php if ($msg): ?>
    <div class="success-box"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="content-box">
    <label>Identify file to lock:</label>
    <input type="file" name="vault_doc" required>
    <button type="submit" style="width:100%;">Encrypt & Deposit</button>
</form>

<div class="info-box">
    <strong>Infrastructure Note:</strong> Check the <code>private_vault_data</code> folder. The generated <code>.htaccess</code> forcefully breaks HTTP access, protecting our documents from public exposure even if they guess the file name!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  17 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 17: Object-Oriented Frameworking (OOP Intro)";

// Encapsulation Concept
class CoreEngine {
    // Properties represent data
    private float $cpuUsage = 0.0;
    private string $hostname;

    // Initialization constructor
    public function __construct(string $hostname) {
        $this->hostname = $hostname;
    }

    // Methods represent actions/abilities
    public function spikeCpu(float $amount): void {
        if ($amount < 0) throw new InvalidArgumentException("Spike cannot be negative.");
        $this->cpuUsage += $amount;
    }

    public function getStatus(): array {
        return [
            'host' => $this->hostname,
            'load' => $this->cpuUsage . '%'
        ];
    }
}

// Memory instantiation
$serverAlpha = new CoreEngine('SERVER_ALPHA_NODE');
$serverAlpha->spikeCpu(45.5);
// $serverAlpha->cpuUsage = 200; // Will crash script! Property is private.

$statusData = $serverAlpha->getStatus();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Architecting Abstractions (Classes & Objects)</h2>
    <p>Using Objects stops other scripts from randomly altering sensitive data. We build APIs around the data (Encapsulation).</p>
</div>

<h3>Server Status Retrieval:</h3>
<table>
    <tr><th>Engine Host Identifier</th><th>Core Load CPU (%)</th></tr>
    <tr>
        <td><code><?= htmlspecialchars($statusData['host']) ?></code></td>
        <td style="<?= (float)$statusData['load'] > 40 ? 'color:red; font-weight:bold;' : '' ?>">
            <?= htmlspecialchars($statusData['load']) ?>
        </td>
    </tr>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 17 Project: Character Generator API Base";

class BaseCharacter {
    private string $name;
    private int $hp;
    private int $strength;
    private int $agility;

    public function __construct(string $name) {
        $this->name = $name;
        $this->rollStats();
    }

    // A private internal action that the controller cannot call publicly
    private function rollStats(): void {
        $this->hp = random_int(80, 150);
        $this->strength = random_int(5, 20);
        $this->agility = random_int(5, 20);
    }

    public function getProfile(): array {
        return [
            'name' => $this->name,
            'hp' => $this->hp,
            'str' => $this->strength,
            'agi' => $this->agility
        ];
    }
}

$player = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawName = trim($_POST['char_name'] ?? '');
    if (!empty($rawName)) {
        // Instantiate using form class logic!
        $player = new BaseCharacter(htmlspecialchars($rawName));
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Object Instantiation Pipeline</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identify New Combatant Name:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="char_name" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Generate Entity</button>
    </div>
</form>

<?php if ($player): ?>
    <?php $heroStruct = $player->getProfile(); ?>
    <div class="success-box">
        <h3 style="margin-top:0;">Entity Generated Natively:</h3>
        <table>
            <tr><th>Identifier</th><th>Vitality (HP)</th><th>Strength Base</th><th>Agility Base</th></tr>
            <tr>
                <td><strong><?= htmlspecialchars($heroStruct['name']) ?></strong></td>
                <td><?= $heroStruct['hp'] ?></td>
                <td><?= $heroStruct['str'] ?></td>
                <td><?= $heroStruct['agi'] ?></td>
            </tr>
        </table>
        
        <p style="font-size:0.8em; margin-bottom:0;"><em>We cannot manually change the HP to 9999 from the controller because the property is encapsulated (Private)!</em></p>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  18 => [
    'ex1' => <<<'EOT'
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 18 Project: The Inventory Subsystem";

class Item {
    public function __construct(
        public readonly string $name,
        public readonly int $weight
    ) {}
}

class InventoryEngine {
    private array $items = [];

    // Requires an Item object (Dependency Injection Type Hint)
    public function push(Item $payload): void {
        $this->items[] = $payload;
    }

    public function calculateEncumbrance(): int {
        return array_reduce($this->items, fn($sum, $item) => $sum + $item->weight, 0);
    }
    
    public function list(): array {
        return $this->items;
    }
}

// Application Orchestration
$satchel = new InventoryEngine();
$satchel->push(new Item('Steel Broadsword', 12));
$satchel->push(new Item('Health Potion', 1));
$satchel->push(new Item('Heavy Iron Greaves', 18));
// $satchel->push("Fake Item String"); // Will FATAL CRASH instantly!

$totalWeight = $satchel->calculateEncumbrance();
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Strict Object Injection (Type Hinting)</h2>
    <p>By forcing specific Objects across functions, we eliminate 90% of structural bugs seamlessly.</p>
</div>

<h3>Satchel Contents:</h3>
<table>
    <tr><th>Item Nomenclature</th><th>Weight (Lbs)</th></tr>
    <?php foreach ($satchel->list() as $i): ?>
        <tr>
            <td><code><?= htmlspecialchars($i->name) ?></code></td>
            <td><?= $i->weight ?></td>
        </tr>
    <?php endforeach; ?>
    <tr style="background:var(--hover-bg); font-weight:bold;">
        <td>Total Engine Encumbrance</td>
        <td style="<?= $totalWeight > 30 ? 'color:red;' : '' ?>"><?= $totalWeight ?></td>
    </tr>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  19 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 19: Inheritance Architecture & Overriding";

class StandardDocument {
    // Protected allows Children to manipulate it (Private completely blocks children!)
    protected string $title;
    
    public function __construct(string $title) {
        $this->title = $title;
    }
    
    public function renderContent(): string {
        return "Rendering [{$this->title}] via Default Engine.";
    }
}

// Child extending the Engine
class SecurePdfDocument extends StandardDocument {
    
    public function renderContent(): string {
        // Polymorphism! Run the parent's logic, then augment it.
        $base = parent::renderContent();
        return "<b style='color:green;'>[ENCRYPTED]</b> " . $base . " -> Converted to strictly formatted PDF binary.";
    }
}

$docs = [
    new StandardDocument("Open Source Report"),
    new SecurePdfDocument("Classified Operations Brief")
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Polymorphism (Many Forms)</h2>
    <p>We call the exact same method function name, but the Object determines how deeply to process it!</p>
</div>

<ul style="list-style-type:none; padding:0;">
    <?php foreach ($docs as $doc): ?>
        <li class="content-box" style="margin-bottom:10px;">
            <?= $doc->renderContent() ?> <br>
            <small><code>Instance check - Is SecurePdf? <?= ($doc instanceof SecurePdfDocument ? 'Yes' : 'No') ?></code></small>
        </li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 19 Project: Subclasses & Races";

class BaseEntity {
    public function __construct(
        protected string $name,
        protected int $mana = 50,
        protected int $health = 100
    ) {}

    public function combatAction(): string {
        return "{$this->name} initiates a standard physical attack structure.";
    }
    
    public function getDetails(): array {
        return ['name'=>$this->name, 'hp'=>$this->health, 'mp'=>$this->mana];
    }
}

class Wizard extends BaseEntity {
    public function __construct(string $name) {
        // Run parent construction first, then mutate immediately
        parent::__construct($name);
        $this->health -= 40;  // Fragile
        $this->mana += 200;   // Powerful!
    }

    public function combatAction(): string {
        if ($this->mana >= 50) {
            $this->mana -= 50;
            return "{$this->name} casts HELLFIRE! (-50 MP)";
        }
        return parent::combatAction(); // Fallback if out of mana
    }
}

// Orchestration
$entities = [
    new BaseEntity("Town Guard"),
    new Wizard("Gandalf The Great")
];

// Determine if we should simulate an attack round
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // We hackily drain Gandalf's mana to test the fallback using session/state logic 
    // but here we just loop it intensely
    $combatLogs = [];
    foreach ($entities as $e) {
        $combatLogs[] = $e->combatAction();
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Subclass Augmentation</h2>
</div>

<div style="display:flex; justify-content:space-between; gap:20px; text-transform:uppercase;">
    <?php foreach ($entities as $e): $data = $e->getDetails(); ?>
        <div class="info-box" style="flex:1;">
            <strong><?= htmlspecialchars($data['name']) ?></strong><br>
            HP: <?= $data['hp'] ?> | MP: <?= $data['mp'] ?>
        </div>
    <?php endforeach; ?>
</div>

<form method="POST" style="margin-top:20px;">
    <button type="submit" style="width:100%;">Execute Turn Combat</button>
</form>

<?php if (isset($combatLogs)): ?>
    <div class="content-box" style="margin-top:20px; background:#000; color:#0f0;">
        <?php foreach ($combatLogs as $log): ?>
            <div>>> <?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  20 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 20: Interfaces, Abstracts, and Horizontal Traits";

// 1. Interface: A pure contract requirement
interface PaymentGatewayInterface {
    public function processPayload(float $amount): string;
}

// 2. Abstract Class: Partial implementation blueprint
abstract class LoggerBase {
    protected string $type;
    public function __construct(string $type) { $this->type = $type; }
    
    abstract public function triggerLog(string $msg): string; // MUST BE FINISHED BY CHILDREN
}

// 3. Trait: Code injection horizontally across entirely unrelated classes!
trait AuditStamper {
    public function getStamp(): string {
        return " [AUDIT: " . time() . "] ";
    }
}

// Compilation: Everything combined!
class StripeEngine extends LoggerBase implements PaymentGatewayInterface {
    use AuditStamper;

    public function processPayload(float $amount): string {
        return "Stripe Execution: Charging $$amount" . $this->getStamp();
    }
    
    public function triggerLog(string $msg): string {
        return "[{$this->type}] Logged internal node -> " . $msg;
    }
}

$engine = new StripeEngine('CRITICAL_FINANCE');
$result1 = $engine->processPayload(150.00);
$result2 = $engine->triggerLog('Payment succeeded');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Engine Contracts & Traits</h2>
    <p>To build a framework like Laravel or Symfony, we rely intensely on Interfaces so we can swap out dependencies seamlessly.</p>
</div>

<h3>Compiled Outputs:</h3>
<ul>
    <li><?= htmlspecialchars($result1) ?></li>
    <li><?= htmlspecialchars($result2) ?></li>
</ul>

<div class="info-box">
    <strong>Architecture Note:</strong> The object fulfills the Interface Contract, extends the Abstract Database, and utilizes the Trait injection all flawlessly!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 20 Project: Solid System Architecture Engine";

interface EquippableInterface {
    public function getArmorBonus(): int;
    public function getSlotNode(): string;
    public function getName(): string;
}

class SteelHelm implements EquippableInterface {
    public function getArmorBonus(): int { return 25; }
    public function getSlotNode(): string { return 'HEAD'; }
    public function getName(): string { return 'Steel Heavy Helm'; }
}

class BandageItem {
    // This is consumable, not Equippable! Fails the contract.
}

class CombatEntity {
    private array $gear = [];

    // The method DEMANDS an object matching the EquippableInterface contract.
    // It doesn't care exactly what class it is, as long as it has those 3 methods!
    public function equip(EquippableInterface $item): string {
        $slot = $item->getSlotNode();
        $this->gear[$slot] = $item;
        return "Success: Attached {$item->getName()} to layer [$slot] (+{$item->getArmorBonus()} DEF)";
    }
}

$soldier = new CombatEntity();
$headgear = new SteelHelm();
$healing = new BandageItem();

$logSuccess = $soldier->equip($headgear); // Works!

// Hitting this internally via PHP Type Error
$logFail = null;
try {
    // We force a reflection bypass or just simulate for safety
    // $soldier->equip($healing); // FATAL ERROR!
    $logFail = "FATAL ERROR TYPE EXCEPTION: BandageItem cannot be passed to equip(), does not implement EquippableInterface!";
} catch (TypeError $e) {
    // Handled normally in PHP 8 if configured
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Rigid Interface Type Hinting (S.O.L.I.D.)</h2>
</div>

<h3>Hardware Attachment Flow:</h3>
<div class="success-box">
    <strong>Entity System Action:</strong> <?= htmlspecialchars($logSuccess) ?>
</div>

<div class="error-box">
    <strong>Engine Rejection:</strong> <?= htmlspecialchars($logFail) ?>
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
echo "Professional Layouts generated & applied to Weeks 11-20.\n";
