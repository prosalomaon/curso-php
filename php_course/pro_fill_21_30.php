<?php
/**
 * Professional PHP Code Populate Tool - Weeks 21 to 30
 * Focus: Database (PDO) and MVC Integrations with Professional Layouts.
 */

$examples = [
    21 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 21: Relational Database Schemas";

$schemaCode = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    role ENUM('USER', 'ADMIN') DEFAULT 'USER',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    CONSTRAINT fk_post_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;
SQL;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>MySQL / MariaDB Standardization</h2>
    <p>PHP relies on rock-solid database schema designs. Use InnoDB and utf8mb4 encoding to fully support modern Unicode formats (like emojis) and Foreign Constraints.</p>
</div>

<h3>Foundational 1-to-Many Architecture</h3>
<pre><?= htmlspecialchars($schemaCode) ?></pre>

<div class="info-box">
    <strong>Relational Integrity:</strong> The <code>ON DELETE CASCADE</code> instructs the database engine to instantly wipe all <code>posts</code> belonging to a user if the user's ID is deleted, preventing "Orphaned Records" safely without PHP intervening.
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 21 Project: Blog Database Bootstrap";

$tables = [
    'categories' => "
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
)",
    'articles' => "
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NULL,
    title VARCHAR(200) NOT NULL,
    body TEXT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
)"
];

$simulatedLogs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($tables as $name => $query) {
        $simulatedLogs[] = "Migrated target node: [{$name}]";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>CMS Schema Bootstrap Engine</h2>
</div>

<?php if ($simulatedLogs): ?>
    <div class="content-box" style="background:#000; color:#0f0;">
        <?php foreach ($simulatedLogs as $log): ?>
            <div>>> <?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
        <div style="margin-top:10px; color:yellow;">System configured for PDO insertion successfully.</div>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;" <?= $simulatedLogs ? 'disabled' : '' ?>>Execute System Migrations</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    22 => [
        'ex1' => <<<'EOT'
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 22 Project: PDO Fetch Abstractions";

class SimulatedStatement {
    public function fetchAll(int $mode = PDO::FETCH_ASSOC): array {
        if ($mode === PDO::FETCH_OBJ) {
            return [(object)['id'=>1, 'title'=>'PDO Engine Architecture']];
        }
        return [['id'=>1, 'title'=>'PDO Engine Architecture']];
    }
}

$stmt = new SimulatedStatement();
$assocOutput = $stmt->fetchAll(PDO::FETCH_ASSOC);
$objOutput = $stmt->fetchAll(PDO::FETCH_OBJ);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Retrieval Format Engine</h2>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Standard Arrays (FETCH_ASSOC)</h3>
        <p>Ultra-fast array hash mapping.</p>
        <pre><?= htmlspecialchars(print_r($assocOutput, true)) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Anonymous Objects (FETCH_OBJ)</h3>
        <p>Cleaner <code>$row->title</code> syntax mapping natively applied.</p>
        <pre><?= htmlspecialchars(print_r($objOutput, true)) ?></pre>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    23 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 23: Bindings & SQL Injection Defense";

$userId = $_GET['id'] ?? '1 OR 1=1; DROP TABLE users;';

$safeExample = <<<PHP
\$stmt = \$pdo->prepare("UPDATE users SET status = :status WHERE id = :user_id");

// Execute binds values perfectly, closing the injection loophole explicitly.
\$stmt->execute([
    'user_id' => \$userId,
    'status'  => 'active'
]);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Prepared Statements (The Ultimate Shield)</h2>
    <p>SQL Injection is the #1 vulnerability on the web. We kill it permanently by separating the SQL logic framework from the user's data variables using <code>prepare()</code>.</p>
</div>

<div class="error-box">
    <strong>Malicious Payload Detected in $_GET:</strong><br>
    <code><?= htmlspecialchars($userId) ?></code>
</div>

<div class="success-box">
    Using <strong>Named Bindings</strong> (<code>:variable</code>), the malicious string above is treated purely as a literal string by the database engine, causing no damage.
</div>

<h3>Deployment Code:</h3>
<pre><?= htmlspecialchars($safeExample) ?></pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 23 Project: Secure Article Search Engine";

$searchTerm = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$simulatedResults = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    // 1. The wildcard % must be appended in PHP, not in the raw SQL statement!
    $boundVariable = '%' . $searchTerm . '%';
    
    // 2. Simulated DB execution
    $simulatedResults = [
        ['id' => 44, 'title' => "Mastering {$searchTerm} Architecture"],
        ['id' => 99, 'title' => "Deploying {$searchTerm} to AWS"]
    ];
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>WILDCARD Integration Mapping</h2>
    <p>Using <code>LIKE</code> with PDO.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Search the Blog Database:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="query" required autocomplete="off" placeholder="Try searching 'PHP'">
        <button type="submit" style="white-space:nowrap;">Run Query</button>
    </div>
</form>

<?php if ($simulatedResults !== null): ?>
    <h3>Database Output (0.012s):</h3>
    <ul>
        <?php foreach ($simulatedResults as $row): ?>
            <li><strong>[Article #<?= $row['id'] ?>]</strong> <?= htmlspecialchars($row['title']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <div class="info-box" style="margin-top:20px;">
        <strong>Behind the scenes SQL Executed safely:</strong><br>
        <code>SELECT * FROM articles WHERE title LIKE :query</code><br>
        <em>Bound <code>:query</code> to <code>"<?= htmlspecialchars('%' . $searchTerm . '%') ?>"</code></em>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    24 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 24: ACID Compliance and Database Transactions";

$transactionCode = <<<PHP
try {
    \$pdo->beginTransaction();

    // Deduct money from Account A
    \$pdo->exec("UPDATE accounts SET balance = balance - 100 WHERE id = 1");
    
    // Add money to Account B
    \$pdo->exec("UPDATE accounts SET balance = balance + 100 WHERE id = 2");

    \$pdo->commit(); // Save all changes atomically

} catch (Exception \$e) {
    \$pdo->rollBack(); // On ANY error, revert the entire batch!
    throw \$e;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The <code>rollBack()</code> Safety Net</h2>
    <p>What happens if a script crashes natively half-way through transferring $10,000 from one user to another? Data corruption. Transactions fix this instantly.</p>
</div>

<h3>Atomic Consistency Code Block:</h3>
<pre><?= htmlspecialchars($transactionCode) ?></pre>

<div class="info-box">
    When deploying logic that touches multiple database tables simultaneously (e.g. creating a User AND assigning them a Profile), wrap it natively in a PDO Transaction!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 24 Project: Safe Deletion Workflows";

$articleId = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);
$currentUserId = 1; // Simulated session
$log = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $articleId) {
    // Stage 1: Verification Phase Simulation
    $ownerCheckPassed = ($articleId !== 999); // 999 simulates an un-owned article
    
    if (!$ownerCheckPassed) {
        $log = "ERROR: You lack authorization to delete Article #$articleId.";
    } else {
        // Stage 2: Execution Phase Simulation
        $log = "SUCCESS: Article #$articleId and all associated Tags completely wiped from Database.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Enforcing Ownership on DELETE</h2>
    <p>If you don't check <code>WHERE author_id = :uid</code> inside your delete queries, hackers simply change the ID to wipe someone else's data!</p>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCCESS') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($log) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="border-color:red;">
    <label>Select Target Article for Deletion:</label>
    <div style="display:flex; gap:10px;">
        <select name="delete_id">
            <option value="55">Normal Article #55 (Belongs to You)</option>
            <option value="999">Restricted Data #999 (Simulated Hacking Attempt)</option>
        </select>
        <button type="submit" style="background:red;">Execute Permanent Deletion</button>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    25 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 25: Relational JOINs & System Optimization";

$querySyntax = <<<SQL
SELECT 
    users.username, 
    COUNT(posts.id) as total_posts 
FROM users 
LEFT JOIN posts ON users.id = posts.user_id 
GROUP BY users.id;
SQL;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Database Relationships over loops (N+1 Crisis)</h2>
    <p>Running SQL Queries inside a PHP <code>foreach</code> loop is heavily forbidden in production. Instead, we use SQL <code>JOIN</code> syntax to grab interconnected data instantaneously!</p>
</div>

<h3>Aggregate Data Retrieval (Count total user posts)</h3>
<pre><?= htmlspecialchars($querySyntax) ?></pre>

<div class="info-box">
    This logic executes purely inside the MySQL/MariaDB RAM in 3 milliseconds, rather than PHP hammering the network with thousands of separate connection requests natively!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 25 Project: CMS Many-to-Many Architecture";

$manyToManySyntax = <<<SQL
SELECT tags.tag_name 
FROM tags
INNER JOIN article_tags ON tags.id = article_tags.tag_id
WHERE article_tags.article_id = :post_id;
SQL;

// Simulated Execution returned by PDO
$articleTags = ['Science', 'PHP Architecture', 'Backend Design'];

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Pivot Tables Context</h2>
    <p>Articles have multiple Tags. Tags have multiple Articles. We resolve this database nightmare using a Pivot Table (<code>article_tags</code>) natively mapped via an <code>INNER JOIN</code>.</p>
</div>

<h3>CMS Query Representation</h3>
<pre><?= htmlspecialchars($manyToManySyntax) ?></pre>

<div class="success-box">
    <strong>Tags linked to Article Rendered:</strong>
    <ul style="margin-bottom:0;">
        <?php foreach ($articleTags as $tag): ?>
            <li style="font-family:monospace;">~ <?= htmlspecialchars($tag) ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    26 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 26: Model-View-Controller (MVC) Pattern";

$architectureFlow = <<<TEXT
1. USER requests -> Router.
2. Router decides which CONTROLLER to deploy based on the URL.
3. Controller retrieves Data variables from the MODEL (Database).
4. Controller sanitizes and processes logic.
5. Controller injects Logic output into the VIEW (HTML).
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Total Separation of Concerns</h2>
    <p>Your PHP code has grown. MVC is the global standard for keeping huge codebases maintainable by splitting domains explicitly.</p>
</div>

<h3>The Lifecycle Matrix:</h3>
<pre><?= htmlspecialchars($architectureFlow) ?></pre>

<div class="info-box">
    <strong>Golden Rule:</strong> Views should absolutely NEVER execute SQL queries or manipulate raw business validation logic. They just print data formatting safely via <code>htmlspecialchars()</code>.
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 26 Project: JSON API Extractor";

class ArticleApiController {
    // 1. A global method that forces JSON header architecture
    protected function generateJson(array $payload, int $status = 200): void {
        // http_response_code($status);
        // header('Content-Type: application/json');
        echo json_encode(['status_code' => $status, 'data' => $payload], JSON_PRETTY_PRINT);
    }

    public function retrieve(int $id) {
        $mockModelData = ['id' => $id, 'title' => 'MVC Paradigm Shift', 'type' => 'Tutorial'];
        $this->generateJson($mockModelData, 200);
    }
}

$controllerObject = new ArticleApiController();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Constructing Base Controllers</h2>
</div>

<h3>API Endpoint Retrieval Execution:</h3>
<pre class="content-box" style="background:#000; color:#0f0;">
<?php $controllerObject->retrieve(505); ?>
</pre>

<div class="info-box">
    The application logic inherits cleanly. A <code>BaseController</code> can contain universal methods like <code>redirect()</code>, <code>validate()</code>, or <code>generateJson()</code>!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    27 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 27: The Front Controller & Dynamic Routing";

// Extract URI from the server map
$mockUri = '/user/edit/88'; // $_SERVER['REQUEST_URI']
$mockMethod = 'POST'; // $_SERVER['REQUEST_METHOD']

// 1. Defining route mapping
$routeEngineMap = [
    'GET /user/edit/{id}' => 'UserController@showEditForm',
    'POST /user/edit/{id}' => 'UserController@saveChanges',
];

$matchedAction = null;

// 2. Simple regex abstraction matcher
if (preg_match('#^/user/edit/(\d+)$#', $mockUri, $matches) && $mockMethod === 'POST') {
    $matchedAction = "Triggering Controller: [UserController], executing [saveChanges], passing Parameter Data: [" . $matches[1] . "]";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Single Entry Architecture (Front Controller)</h2>
    <p>Using `.htaccess` or Nginx, we route every single request (<code>/blog</code>, <code>/contact</code>) to a master <code>index.php</code> script that maps the URI perfectly!</p>
</div>

<div class="info-box">
    <strong>Incoming Client Payload Request:</strong> <code><?= $mockMethod ?> <?= $mockUri ?></code><br>
    <strong>Regex Dispatcher Result:</strong> <?= htmlspecialchars((string)$matchedAction) ?>
</div>

<h3>Defined Application Routes</h3>
<ul>
    <?php foreach ($routeEngineMap as $uri => $controllerString): ?>
        <li><code><strong><?= explode(' ', $uri)[0] ?></strong> <?= explode(' ', $uri)[1] ?></code> &rarr; <code><?= $controllerString ?></code></li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 27 Project: RESTful Verbs Configuration";

$restVerbs = [
    'index'   => ['method' => 'GET', 'uri' => '/products', 'desc' => 'List all product database records'],
    'create'  => ['method' => 'GET', 'uri' => '/products/create', 'desc' => 'Render the physical HTML Form'],
    'store'   => ['method' => 'POST','uri' => '/products', 'desc' => 'Accept POST payload and execute DB Insertion'],
    'show'    => ['method' => 'GET', 'uri' => '/products/{id}', 'desc' => 'Fetch and display a specific resource'],
    'edit'    => ['method' => 'GET', 'uri' => '/products/{id}/edit', 'desc' => 'Render pre-filled HTML Form'],
    'update'  => ['method' => 'PUT', 'uri' => '/products/{id}', 'desc' => 'Accept PUT payload and execute DB Modification'],
    'destroy' => ['method' => 'DELETE', 'uri' => '/products/{id}', 'desc' => 'Execute absolute elimination algorithms'],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>REST Standard Paradigms</h2>
    <p>Following absolute HTTP protocol specifications creates perfectly predictable URL architectures for the E-Commerce backbone.</p>
</div>

<table>
    <thead><tr><th>MVC Controller Call</th><th>Verb</th><th>URI Path</th><th>Operational Target</th></tr></thead>
    <tbody>
        <?php foreach ($restVerbs as $action => $details): ?>
        <tr>
            <td><strong><code><?= htmlspecialchars($action) ?>()</code></strong></td>
            <td style="font-weight:bold; color:var(--text-color);"><?= $details['method'] ?></td>
            <td><code><?= htmlspecialchars($details['uri']) ?></code></td>
            <td><?= htmlspecialchars($details['desc']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    28 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 28: View Engines & Global Helpers";

// Function mapping used exclusively in HTML views mapping
function e(?string $text): string {
    return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$maliciousDataAttempt = "<script>alert('Stealing cookies using XSS!');</script>";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The Presentation Layer (Views)</h2>
    <p>Views should never format raw data directly. A global helper like <code>e()</code> ensures we never accidentally leak HTML script nodes to the browser layout.</p>
</div>

<h3>Cross Site Scripting Mitigation Matrix:</h3>
<div style="border:1px solid var(--border-color); padding:10px; margin-bottom:10px;">
    <strong>Raw Attack Output Simulation:</strong><br>
    <code style="color:red;"><?= htmlspecialchars("echo \$maliciousDataAttempt;") ?></code>
</div>

<div class="success-box">
    <strong>Escaped Protection Engine:</strong><br>
    <code>e($maliciousDataAttempt)</code> outputs:<br><br>
    <b style="color:#155724; font-family:monospace;"><?= e($maliciousDataAttempt) ?></b>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 28 Project: Master Layout Wrappers";

$outputBufferingCode = <<<PHP
// 1. Pause browser screen output explicitly
ob_start();

// 2. Load the page data natively (e.g., login_form.php)
require 'views/' . \$viewName . '.php';

// 3. Dump buffer into a string variable
\$content = ob_get_clean();

// 4. Inject it into the Master Layout Frame
require 'layouts/master.php'; 
// (Inside master.php, we simply write: <?=\$content?> in the center of the HTML)
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Output Buffering Interception</h2>
    <p>How does a framework render the same header and footer globally without needing to literally copy-paste <code>require 'header.php'</code> into every single file? Using the super powerful <code>ob_start()</code> system.</p>
</div>

<h3>Internal Renderer Injection Script:</h3>
<pre><?= htmlspecialchars($outputBufferingCode) ?></pre>

<div class="info-box">
    <strong>Note:</strong> We are currently utilizing a basic version of this internally in the <code>php_course</code> folder to enforce our Black & White design!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    29 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 29: Cryptography & Password Hashing";

$plaintext = "SecureSystem__89";

// Hashing is SLOW aggressively to prevent Brute Force database cracking!
$options = ['cost' => 12];
$secureHashValue = password_hash($plaintext, PASSWORD_DEFAULT, $options);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Cryptographic Hash Generation algorithms</h2>
    <p>Using <code>md5()</code> or <code>sha1()</code> for passwords is critically dangerous. We use <code>password_hash()</code> because it generates random salt strings implicitly and loops dynamically to burn CPU intentionally.</p>
</div>

<table>
    <tr><th>Raw Value Map</th><th>Generated Hex Signature (BCRYPT usually)</th></tr>
    <tr>
        <td><code><?= htmlspecialchars($plaintext) ?></code></td>
        <td style="word-break:break-all;"><strong><?= htmlspecialchars($secureHashValue) ?></strong></td>
    </tr>
</table>

<div class="info-box">
    <strong>Constant-Time Assurance:</strong> Notice that BCRYPT strings contain the algorithm marker (<code>$2y$</code>) and the cost modifier (<code>12$</code>) natively bound to the signature.
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 29 Project: E-Commerce Registry";

$log = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'] ?? '';
    
    if (!$mail) {
        $log = "Validation Block: Malformed email structure identifier.";
    } elseif (strlen($pass) < 10) {
        $log = "Security Policy Block: Passphrase requires 10 characters absolute minimum length.";
    } else {
        // Generating the Hash!
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        
        $log = "SUCCESS: Registration algorithms passed.\nDatabase Insert Triggered:\nEmail: $mail\nHashed Node: $hashed";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Account Validation Endpoint</h2>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCCESS') ? 'success-box' : 'error-box' ?>">
        <?= nl2br(htmlspecialchars($log)) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identify Contact Origin (Email):</label>
    <input type="email" name="email" required autocomplete="off">
    
    <label>Cryptographic Passphrase Base:</label>
    <input type="password" name="password" required>
    
    <button type="submit" style="width:100%;">Create Account Node</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    30 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 30: Authentication State Checks";

// Simulated Database Data
$dbHashRecord = password_hash("CorrectH0rseBatteryStaple!", PASSWORD_DEFAULT, ['cost' => 10]);

// Simulated Form Data
$simulatedLoginAttempt = "CorrectH0rseBatteryStaple!";

$authGranted = password_verify($simulatedLoginAttempt, $dbHashRecord);

$rehashRequired = password_needs_rehash($dbHashRecord, PASSWORD_DEFAULT, ['cost' => 12]);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Verifying Hashes and Upgrading Salts</h2>
    <p>Since we extract salt hashes natively inside the BCRYPT text block, <code>password_verify()</code> can compare a raw string with an encrypted string mathematically.</p>
</div>

<?php if ($authGranted): ?>
    <div class="success-box">
        <h4>Verification Check Passed Gracefully!</h4>
        <p>The strings mathematically match using the correct internal cryptographic algorithms.</p>
    </div>
    
    <?php if ($rehashRequired): ?>
        <div class="info-box">
            <strong>System Tuning:</strong> The database hash was generated using older <code>cost 10</code>. The system is automatically upgrading the hash to <code>cost 12</code> natively in the background and updating the database!
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="error-box">Critical Security Failure. Payload manipulation detected.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 30 Project: Middleware Guard";

// We simulate middleware natively handling requests!
$mockSessionRole = 'CUSTOMER'; // They purchased items.

// Middleware Controller Pattern Matrix
$canAccessAdmin = false;
$middlewareLog = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mockSessionRole === 'SUPER_ADMIN') {
        $canAccessAdmin = true;
        $middlewareLog = "ACCESS GRANTED: Security gates bypassed successfully for System Admin.";
    } else {
        $middlewareLog = "HTTP 403 FORBIDDEN: Origin Role [" . $mockSessionRole . "] severely lacks the required security node constraints.";
    }
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>The Middleware Gateway Shield</h2>
    <p>Controllers should not manually check logic. A specific Middleware layer explicitly executes check states before the Controller is even legally allowed to boot.</p>
</div>

<?php if ($middlewareLog): ?>
    <div class="<?= $canAccessAdmin ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($middlewareLog) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="border-style:dashed;">
    <h3 style="margin-top:0;">Access the E-Commerce Admin Node</h3>
    <p>Target Route: <code>/admin/dashboard</code></p>
    <button type="submit" style="width:100%; <?= $middlewareLog && !$canAccessAdmin ? 'background:red;border-color:red;' : '' ?>">Execute Path Resolution</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ]
];

$dirs = array_filter(glob(__DIR__ . '/week_*'), 'is_dir');
foreach ($dirs as $dir) {
    preg_match('/week_0*(\d+)/', basename($dir), $matches);
    if (!isset($matches[1])) continue;
    $weekNum = (int)$matches[1];
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
echo "Professional Layouts generated & applied to Weeks 21-30.\n";
