<?php
/**
 * Advanced PHP Code Populate Tool - Weeks 21 to 30
 * Technical level (pre-university), 1.5-hour classes. Includes edge cases and actual projects.
 */

$examples = [
    21 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 21: Relational Databases and SQL Deep Architectures (1.5 Hours)
 * Topics:
 * - Data Normalization (1NF, 2NF, 3NF)
 * - Indexes, UNIQUE constraints, and Foreign Keys
 * - PHP's role in Database Migrations
 */

// This file contains theoretical schema design concepts.
// We use PHP strings to simulate a schema migration script.

$migrationSchema = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Indexing for fast lookups on auth processes
    INDEX(username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    
    -- Foreign Key enforcing Relational Integrity at the database level!
    CONSTRAINT fk_post_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE -- If user is deleted, their posts die too.
    ON UPDATE CASCADE
) ENGINE=InnoDB;
SQL;

echo "<h3>Database Schema Concept</h3>";
echo "Always use InnoDB with utf8mb4 encoding to fully support modern chars and emojis!<br>";
echo "<pre>" . htmlspecialchars($migrationSchema) . "</pre>";
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 21 Project: Blog CMS Core - Schema Setup
 * 
 * We build an actual PHP script capable of bootstrapping our Blog's database.
 * NOTE: For safety in this environment, we just print the queries rather than run them.
 */

$tables = [
    'categories' => "
        CREATE TABLE categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(100) NOT NULL UNIQUE
        )
    ",
    'articles' => "
        CREATE TABLE articles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NULL,
            title VARCHAR(200) NOT NULL,
            body TEXT,
            published BOOLEAN DEFAULT FALSE,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        )
    "
];

echo "<h3>CMS Bootstrap Script</h3>";
echo "<p>Running migration sequentially to respect Foreign Key constraints:</p>";

foreach ($tables as $name => $query) {
    echo "<strong>Migrating table: $name</strong><br>";
    echo "<code style='display:block; background:#f4f4f4; padding:10px; margin-bottom:15px;'>";
    echo nl2br(htmlspecialchars(trim($query)));
    echo "</code>";
}
echo "<p style='color:green;'>System ready for PDO integration.</p>";
EOT
    ],
    22 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 22: Advanced PDO Connections and Configurations (1.5 Hours)
 * Topics:
 * - DSN architecture
 * - PDO Error Modes (Exceptions vs Warnings)
 * - PDO Fetch Modes (ASSOC, OBJ, CLASS)
 * - Emulated Prepares (And why to turn them off)
 */

class DatabaseManager {
    private static ?PDO $instance = null; // Singleton Pattern

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=localhost;dbname=test_db;charset=utf8mb4";
            $user = "root";
            $pass = "";
            
            $options = [
                // 1. ALWAYS throw exceptions on errors
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // 2. Fetch as associative arrays by default (fastest and cleanest)
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // 3. Disable native emulated prepares to enforce REAL prepared statements internally
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Do NOT echo $e->getMessage() in production, it leaks DB credentials!
                // Log it instead and show generic error.
                die("Database Connection Error. Please try again later.");
            }
        }
        return self::$instance;
    }
}

echo "<h3>Database connection class loaded.</h3>";
echo "Singleton guarantees we never open more than 1 connection per page load!";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 22 Project: Blog CMS Core - API Fetching
 * 
 * Using our PDO Singleton to pull records. 
 * Showcasing PDO::FETCH_OBJ vs PDO::FETCH_CLASS.
 */

// Simulated PDO Environment for educational preview
class MockPDOStatement {
    public function fetchAll(int $mode = PDO::FETCH_ASSOC): array {
        if ($mode === PDO::FETCH_OBJ) {
            return [ (object)['id'=>1, 'title'=>'PDO Rocks'], (object)['id'=>2, 'title'=>'Security'] ];
        }
        return [ ['id'=>1, 'title'=>'PDO Rocks'], ['id'=>2, 'title'=>'Security'] ];
    }
}

echo "<h3>Retrieving Data Formats</h3>";

$stmt = new MockPDOStatement(); // normally: $pdo->query("SELECT * FROM articles");

echo "<strong>1. As Arrays (Default, Fast):</strong><br><pre>";
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
echo "</pre>";

echo "<strong>2. As Anonymous Objects (Clean Syntax ->title instead of ['title']):</strong><br><pre>";
print_r($stmt->fetchAll(PDO::FETCH_OBJ));
echo "</pre>";

echo "<i>Next week, we secure inputs with Prepared Statements!</i>";
EOT
    ],
    23 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 23: Executing Queries & Prepared Statements (1.5 Hours)
 * Topics:
 * - SQL Injection Mechanics
 * - Positional (?) vs Named (:param) Bindings
 * - bindParam vs execute([]) memory nuances
 */

// WARNING: Classic SQL Injection Example!
// $user_id = $_GET['id']; // Imagine this is: "1 OR 1=1; DROP TABLE users;"
// $sql = "SELECT * FROM users WHERE id = " . $user_id;

echo "<h3>Defense via Prepared Statements</h3>";

/*
// 1. Positional Binding
$stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
$stmt->execute(['active', 42]); // Extremely simple array matching

// 2. Named Binding (Preferred for large queries)
$stmt2 = $pdo->prepare("UPDATE users SET status = :status WHERE id = :user_id");
$stmt2->execute([
    'user_id' => 42,
    'status'  => 'active'
]);

// 3. bindParam vs bindValue
$stmt3 = $pdo->prepare("SELECT * FROM users WHERE score > :score");
$scoreLimit = 50;

// bindParam binds the VARIABLE by reference. If $scoreLimit changes later, the query changes!
$stmt3->bindParam(':score', $scoreLimit, PDO::PARAM_INT);

// bindValue binds the exact VALUE at this moment in time.
*/
echo "Always use Prepared Statements. They separate the SQL syntax logic from the User Data payload!";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 23 Project: Blog CMS Core - Safe Articles
 * 
 * Securing a complex Search query using LIKE with Prepared Statements.
 */

$searchTerm = '%PHP%'; // The % wildcard must be baked into the PHP string!

/*
  // Database logic concept:
  $sql = "SELECT id, title FROM articles WHERE title LIKE :search OR body LIKE :search";
  $stmt = $pdo->prepare($sql);
  
  // We can safely pass the wildcard string into execute
  $stmt->execute(['search' => $searchTerm]);
  $results = $stmt->fetchAll();
*/

echo "<h3>Search System Simulated Logic</h3>";
echo "When doing a <code>LIKE</code> query, you <strong>cannot</strong> do <code>LIKE '%:search%'</code> in SQL.<br>";
echo "You must format the string in PHP first: <code>\$term = '%' . \$_GET['q'] . '%';</code><br>";
echo "Then bind <code>\$term</code> directly to <code>:search</code>.";
EOT
    ],
    24 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 24: Advanced CRUD Operations & Transactions (1.5 Hours)
 * Topics:
 * - UPSERT (Insert ... On Duplicate Key Update)
 * - Transactions (commit & rollback)
 * - lastInsertId nuances
 */

// 1. Transactions! Crucial for operations touching multiple tables simultaneously.
/*
try {
    $pdo->beginTransaction();

    // Deduct money from Account A
    $pdo->exec("UPDATE accounts SET balance = balance - 100 WHERE id = 1");
    // Add money to Account B
    $pdo->exec("UPDATE accounts SET balance = balance + 100 WHERE id = 2");
    
    // Create an audit log entry
    $pdo->exec("INSERT INTO logs (action) VALUES ('Transfer 1 to 2')");

    $pdo->commit(); // Save all changes atomically
    echo "Transfer successful.";

} catch (Exception $e) {
    $pdo->rollBack(); // On ANY error, revert the entire batch!
    echo "Transfer failed. Nothing was saved.";
}
*/

echo "<h3>Transactions guarantee ACID compliance.</h3>";
echo "If part of the operation fails, <code>rollBack()</code> undoes the whole block.";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 24 Project: Blog CMS Core - Author Publishing Check
 * 
 * Implementing an advanced CRUD flow checking conditions before deleting.
 */

class ArticleManager {
    // Simulated DB Method
    public function deleteArticle(int $articleId, int $currentUserId): bool {
        /*
        // 1. Verify existence AND ownership in one query before deletion
        $stmt = $pdo->prepare("SELECT id FROM articles WHERE id = :id AND author_id = :uid LIMIT 1");
        $stmt->execute(['id' => $articleId, 'uid' => $currentUserId]);
        
        if (!$stmt->fetch()) {
            throw new Exception("Article not found or you don't have permission.");
        }

        // 2. Execute deletion
        $delStmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
        return $delStmt->execute(['id' => $articleId]);
        */
        
        echo "[LOG] Verified ownership of Article #$articleId for User #$currentUserId...<br>";
        echo "[LOG] Article Details and Associations purged safely.<br>";
        return true;
    }
}

$manager = new ArticleManager();
$manager->deleteArticle(55, 1);
EOT
    ],
    25 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 25: Relational Queries JOINs Deep Dive (1.5 Hours)
 * Topics:
 * - INNER, LEFT, RIGHT JOIN differences
 * - GROUP BY and Aggregate Functions (COUNT, AVG)
 * - N+1 Query Problem in PHP applications
 */

// The N+1 Problem:
// Bad Idea:
// 1. SELECT * FROM users (Gets 100 users) -> 1 Query
// 2. PHP Foreach loop over users:
//      3. SELECT * FROM posts WHERE user_id = $id -> 100 Queries!
// Total: 101 Database hits! Extremely slow.

echo "<h3>Solving N+1 Performance Nightmares</h3>";
echo "<p>Instead of looping arrays to run queries, use <strong>JOINs</strong> or <strong>IN()</strong> statements.</p>";

$optimizedQuery = <<<SQL
-- Efficiently get all users and sum up their post count in ONE database hit
SELECT 
    users.id, 
    users.username, 
    COUNT(posts.id) as total_posts 
FROM users 
LEFT JOIN posts ON users.id = posts.user_id 
GROUP BY users.id;
SQL;

echo "<pre>$optimizedQuery</pre>";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 25 Project: Blog CMS Advanced - Tags & Many-to-Many
 * 
 * Implementing a Pivot Table visualization to handle Articles <-> Tags.
 */

/*
SCHEMA Conceptualization:
Table `articles`: id, title
Table `tags`: id, tag_name
Pivot Table `article_tags`: article_id, tag_id
*/

$manyToManyQuery = <<<SQL
-- Get Article '1' and ALL its associated Tags
SELECT tags.tag_name 
FROM tags
INNER JOIN article_tags ON tags.id = article_tags.tag_id
WHERE article_tags.article_id = 1;
SQL;

echo "<h3>Many-to-Many Relationships</h3>";
echo "<p>To link two systems that have multiple items of each other (Posts have many Tags, Tags have many Posts), a <strong>Pivot Table</strong> is strictly required.</p>";
echo "<code>" . nl2br($manyToManyQuery) . "</code>";
EOT
    ],
    26 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 26: The Model-View-Controller (MVC) Architecture (1.5 Hours)
 * Topics:
 * - Separation of Concerns
 * - Fat Models vs Skinny Controllers
 * - The View Layer (Templating intro)
 */

// Controller: Interprets the HTTP Request and orchestrates
class UserController {
    public function showProfile(int $id) {
        // 1. Fetch data from Model
        $userModel = new UserModel();
        $user = $userModel->findById($id);

        if (!$user) {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        // 2. Pass data to View
        $view = new View('profile_template');
        $view->render(['user' => $user]);
    }
}

// Model: Handles database connection and business logic
class UserModel {
    public function findById(int $id): ?array {
        // Database call simulation
        return $id === 1 ? ['name' => 'Alice', 'role' => 'Admin'] : null;
    }
}

// View: Handles presentation logic exclusively (No SQL allowed!)
class View {
    private string $template;
    public function __construct(string $template) { $this->template = $template; }
    
    public function render(array $data) {
        extract($data); // Converts ['user' => ...] into $user variable
        // Normally: require "views/{$this->template}.php";
        echo "RENDERING TEMPLATE: <h1>Welcome {$user['name']}</h1>";
    }
}

$app = new UserController();
$app->showProfile(1);
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 26 Project: Blog CMS Advanced - Building the Core Controllers
 * 
 * Setting up a robust BaseController that all other controllers extend.
 */

abstract class BaseController {
    protected function jsonResponse(array $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function validateRequest(array $requiredFields, array $payload): bool {
        foreach ($requiredFields as $field) {
            if (empty($payload[$field])) return false;
        }
        return true;
    }
}

class ArticleController extends BaseController {
    public function create() {
        if (!$this->validateRequest(['title', 'content'], $_POST)) {
            $this->jsonResponse(['error' => 'Missing fields'], 400);
        }
        $this->jsonResponse(['message' => 'Article Created!', 'id' => 99], 201);
    }
}

echo "<h3>API Controller Ready</h3>";
echo "Inheritance allows <code>ArticleController</code> to instantly send JSON or validate rules using parent methods.";
// Simulated request:
// $_POST['title'] = 'My API';
// (new ArticleController())->create();
EOT
    ],
    27 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 27: Routing & The Front Controller Pattern (1.5 Hours)
 * Topics:
 * - Single Entry Point (index.php) via Apache/Nginx Rules
 * - Dynamic Route Dispatching
 * - Regex Route Params (e.g. /user/{id})
 */

class SimpleRouter {
    private array $routes = [];

    public function get(string $path, callable|array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void {
        $uri = parse_url($uri, PHP_URL_PATH); // Strip queries '?page=2'
        
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            
            // If handler is an array like [UserController::class, 'index']
            if (is_array($handler)) {
                $controller = new $handler[0]();
                $action = $handler[1];
                $controller->$action();
            } else {
                call_user_func($handler);
            }
        } else {
            http_response_code(404);
            echo "404 - Route matched nothing.";
        }
    }
}

$router = new SimpleRouter();

// Registering a Closure Route
$router->get('/about', fn() => print("<h2>About Us Page</h2>"));

// Registering a Class Route (Simulated)
class HomeController { public function home() { echo "<h2>Homepage Controller</h2>"; } }
$router->get('/', [HomeController::class, 'home']);

echo "<h3>Front Controller Dispatch:</h3>";
// Simulating an incoming HTTP Request to '/'
$router->dispatch('GET', '/');
$router->dispatch('GET', '/about');
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 27 Project: Blog CMS Advanced - Restful Routes
 * 
 * Defining standard HTTP verbs mapping accurately to Controller targets.
 */

echo "<h3>RESTful Routing Standard</h3>";
echo "When building an MVC App, your routes should be predictable:<br><ul>";

$routeDefs = [
    "GET /articles"          => "ArticleController -> index()",
    "GET /articles/create"   => "ArticleController -> create()  (Shows HTML Form)",
    "POST /articles"         => "ArticleController -> store()   (Receives POST array)",
    "GET /articles/{id}"     => "ArticleController -> show(id)",
    "GET /articles/{id}/edit"=> "ArticleController -> edit(id)  (Shows HTML Edit Form)",
    "PUT /articles/{id}"     => "ArticleController -> update(id)",
    "DELETE /articles/{id}"  => "ArticleController -> destroy(id)",
];

foreach ($routeDefs as $route => $action) {
    echo "<li><strong>$route</strong> ➜ <code>$action</code></li>";
}
echo "</ul>";
EOT
    ],
    28 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 28: Templating & View Engines (1.5 Hours)
 * Topics:
 * - Output Buffering (ob_start)
 * - Layout Wrappers (Master Pages)
 * - Avoiding PHP complexity in HTML
 */

class TemplateEngine {
    private string $layout = '<html><head><title>APP</title></head><body>{{content}}</body></html>';

    public function render(string $viewPath, array $data = []): string {
        extract($data); // Expands array into local variables!

        // 1. Start capturing all output. Stop it from going to the browser directly.
        ob_start();
        
        // 2. Include the specific view file. It uses the $data variables!
        // include $viewPath; 
        
        // Simulating the view file executing:
        echo "<h1>Welcome back, {$username}</h1><p>You have {$alerts} notifications.</p>";
        
        // 3. Dump the captured buffer into a string, and wipe the buffer.
        $viewContent = ob_get_clean();

        // 4. Inject the specific view HTML into our Master Layout HTML.
        return str_replace('{{content}}', $viewContent, $this->layout);
    }
}

$engine = new TemplateEngine();
echo $engine->render('views/dashboard.php', [
    'username' => 'SuperAdmin',
    'alerts' => 4
]);
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 28 Project: Blog CMS Advanced - The View Macro
 * 
 * Setting up helper functions that live in our View layer for 
 * escaping variables safely globally.
 */

// A global helper function used exclusively inside templates to prevent XSS natively.
function e(?string $string): string {
    if ($string === null) return '';
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$maliciousInput = "<script>alert('Steal cookies');</script>";
$safeText = "O'Connor & Sons";

echo "<h3>Template Global Helper 'e()' test:</h3>";
echo "<strong>Raw Output (DANGEROUS):</strong><br>";
// In extreme environments, the line below would trigger XSS:
echo "<div style='color:red;'>$maliciousInput</div>"; 

echo "<strong>Escaped via e():</strong><br>";
echo "<div style='color:green;'>" . e($maliciousInput) . "</div>";
echo "<p>Handling tricky characters (Quotes/Ampersands): " . e($safeText) . "</p>";
EOT
    ],
    29 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 29: Cryptography, Registration, and Password Hashing (1.5 Hours)
 * Topics:
 * - password_hash() internals (Salting & Cost)
 * - BCRYPT vs ARGON2I vs ARGON2ID
 * - Timing Attacks
 */

// 1. Password Hashing
$password = "Hunter2_1995";

// Why not md5() or sha256()? Because they are fast. Fast is BAD for passwords!
// We want hashes to be SLOW to prevent brute force. PASSWORD_DEFAULT currently uses bcrypt.
$options = [
    'cost' => 12 // The higher the cost, the slower the hash generation (logarithmic scale)
];

$hash = password_hash($password, PASSWORD_DEFAULT, $options);

echo "<h3>Crypto Basics</h3>\n";
echo "<strong>Password:</strong> $password <br>\n";
echo "<strong>Secure Hash (Length 60 usually for bcrypt):</strong><br> <code style='word-break: break-all;'>$hash</code><br><br>\n";

// The hash contains the Algorithm, the Cost, the random Salt, and the Resulting Hash!
// e.g., $2y$12$RsaH.... 
// $2y = bcrypt, 12 = cost.

// 2. Timing Attacks
// Hackers can measure how long an operation takes to guess characters.
// hash_equals() is CONSTANT-TIME, making timing attacks impossible.
$knownSignature = "secure_token_123";
$userSignature = "secure_token_123";

if (hash_equals($knownSignature, $userSignature)) {
    echo "API Signatures match securely.<br>";
}
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 29 Project: Secure E-Commerce Backend - Registration System
 * 
 * Ensuring a user is inserted correctly to the DB with a safely hashed password.
 */

class RegistrationService {
    public function register(string $email, string $rawPassword) {
        
        // 1. Password complexity check
        if (strlen($rawPassword) < 8) {
            return "Password too weak. Must be 8+ chars.";
        }

        // 2. Filter email
        $cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email.";
        }

        // 3. Hash the password
        $hashed = password_hash($rawPassword, PASSWORD_ARGON2ID);

        // 4. Save to DB (Simulated)
        // $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
        // $stmt->execute([$cleanEmail, $hashed]);

        return "Successfully registered $cleanEmail. \n<br>Saved Hash: $hashed";
    }
}

$register = new RegistrationService();
echo "<h3>E-Commerce Registration Test</h3>";
echo $register->register('buyer@example.com', 'SecureStorePassw0rd!');
EOT
    ],
    30 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 30: Strong Authentication & Defense in Depth (1.5 Hours)
 * Topics:
 * - password_verify
 * - password_needs_rehash
 * - Multi-factor concepts
 * - Secure login state
 */

$password = "qwerty12345";
$dbHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]); 

echo "<h3>Login Verification</h3>";

// 1. Simple validation
if (password_verify("qwerty12345", $dbHash)) {
    echo "<span style='color:green;'>Password Verified successfully!</span><br>";
    
    // 2. Rehashing Check
    // If we updated our system from Cost 10 to Cost 12, we can rehash users transparently 
    // ON LOGIN because we have their raw password in memory right now!
    if (password_needs_rehash($dbHash, PASSWORD_BCRYPT, ['cost' => 12])) {
        $newHash = password_hash("qwerty12345", PASSWORD_BCRYPT, ['cost' => 12]);
        echo "Cost upgraded! New hash created. Saving to DB transparently...<br>";
        // Update DB with $newHash
    }

} else {
    echo "<span style='color:red;'>Access Denied.</span>";
}
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 30 Project: Secure E-Commerce Backend - Authentication Middleware
 * 
 * Guarding sensitive MVC Controllers using an AuthMiddleware pattern.
 */

class AuthMiddleware {
    public static function enforceAdmin(): void {
        session_start();
        
        // If not logged in at all
        if (empty($_SESSION['user_id'])) {
            http_response_code(401);
            die("<strong>401 Unauthorized:</strong> Please log in to view this portal.");
        }

        // If logged in, but not an admin
        if ($_SESSION['role'] !== 'ADMIN') {
            http_response_code(403);
            die("<strong>403 Forbidden:</strong> You lack the required permissions to access the Administrator Panel.");
        }
    }
}

// Simulating the user passing the exact data
$_SESSION['user_id'] = 999;
$_SESSION['role'] = 'CUSTOMER'; // They try to view the admin panel

echo "<h3>Accessing E-Commerce /admin/dashboard</h3>";
AuthMiddleware::enforceAdmin();

// This line won't execute due to the die() in the middleware!
echo "Welcome to the Admin Dashboard. Revenue: $1,000,000";
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
echo "Advanced Weeks 21-30 examples populated successfully.\n";
