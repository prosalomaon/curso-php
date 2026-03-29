<?php

$examples = [
    21 => [
        'ex1' => "<?php\n// Week 21: Connecting to MySQL/MariaDB with mysqli (procedural)\n\$conn = mysqli_connect('localhost', 'root', '', 'test_db');\nif (!\$conn) {\n    die('Connection failed: ' . mysqli_connect_error());\n}\necho 'Connected successfully to the database using mysqli!';\nmysqli_close(\$conn);\n",
        'ex2' => "<?php\n// Week 21: Basic SQL Query concepts\n// SQL: CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50));\n// SQL: INSERT INTO users (username) VALUES ('admin');\n// SQL: SELECT * FROM users;\necho 'We discussed designing the schema for our Blog CMS today.';\n"
    ],
    22 => [
        'ex1' => "<?php\n// Week 22: Connecting with PDO (PHP Data Objects)\n\$dsn = 'mysql:host=localhost;dbname=test_db;charset=utf8mb4';\n\$user = 'root';\n\$pass = '';\ntry {\n    \$pdo = new PDO(\$dsn, \$user, \$pass);\n    \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n    echo 'Connected to the database via PDO!';\n} catch (PDOException \$e) {\n    echo 'Connection failed: ' . \$e->getMessage();\n}\n",
        'ex2' => "<?php\n// Week 22: PDO Fetch Methods\n// Assume \$pdo is connected.\n/*\n\$stmt = \$pdo->query('SELECT * FROM users');\nwhile (\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) {\n    echo \$row['username'] . \"\\n\";\n}\n*/\necho 'Using PDO::FETCH_ASSOC is the standard way to retrieve rows as an array.';\n"
    ],
    23 => [
        'ex1' => "<?php\n// Week 23: PDO Prepared Statements (Positional vs Named)\n// Assume \$pdo is connected.\n/*\n\$stmt = \$pdo->prepare('SELECT * FROM users WHERE email = ? AND status = ?');\n\$stmt->execute(['test@example.com', 'active']);\n\$user = \$stmt->fetch();\n*/\necho 'Prepared statements protect against SQL Injection \\n';\n",
        'ex2' => "<?php\n// Week 23: Inserting with Prepared Statements\n// Assume \$pdo is connected.\n/*\n\$sql = \"INSERT INTO posts (title, content) VALUES (:title, :content)\";\n\$stmt = \$pdo->prepare(\$sql);\n\$stmt->execute([\n    'title' => 'My First Post',\n    'content' => 'Hello World!'\n]);\necho 'New post ID: ' . \$pdo->lastInsertId();\n*/\necho 'Named parameters make code very readable.';\n"
    ],
    24 => [
        'ex1' => "<?php\n// Week 24: CRUD - Update and Delete\n// Assume \$pdo is connected.\n/*\n// UPDATE\n\$stmt = \$pdo->prepare('UPDATE users SET status = ? WHERE id = ?');\n\$stmt->execute(['inactive', 5]);\necho \$stmt->rowCount() . ' rows updated.';\n*/\necho 'Learning how to update rows securely.\\n';\n",
        'ex2' => "<?php\n// Week 24: Real-world CRUD implementation\n// Let's create a simple function to handle deletion\n/*\nfunction deleteUser(PDO \$pdo, int \$userId) {\n    \$stmt = \$pdo->prepare('DELETE FROM users WHERE id = :id');\n    \$stmt->execute(['id' => \$userId]);\n    return \$stmt->rowCount() > 0;\n}\n*/\necho 'Abstracting CRUD operations into functions or classes cleans up our codebase.';\n"
    ],
    25 => [
        'ex1' => "<?php\n// Week 25: Relational Queries (INNER JOIN)\n// SQL syntax showcase\n/*\nSELECT posts.title, users.username \nFROM posts \nINNER JOIN users ON posts.user_id = users.id;\n*/\necho 'JOINs allow us to combine data from multiple tables effectively.';\n",
        'ex2' => "<?php\n// Week 25: Left Join vs Right Join\n/*\nSELECT users.username, posts.title\nFROM users\nLEFT JOIN posts ON users.id = posts.user_id;\n// This returns ALL users, even those without posts.\n*/\necho 'Left joins are useful for finding orphans or optional relations.';\n"
    ],
    26 => [
        'ex1' => "<?php\n// Week 26: Defining the MVC Pattern\n// Model: Handles Data Logic\n// View: Handles Presentation\n// Controller: Orchestrates Model and View\n\necho 'MVC separates concerns, making our app scalable.';\n",
        'ex2' => "<?php\n// Week 26: A basic Controller\nclass PostController {\n    public function index() {\n        // \$posts = PostModel::getAll();\n        // require 'views/post_list.php';\n        echo 'Controller routing to view...';\n    }\n}\n"
    ],
    27 => [
        'ex1' => "<?php\n// Week 27: Basic Routing Strategy\n\$uri = parse_url(\$_SERVER['REQUEST_URI'], PHP_URL_PATH);\n\$uri = basename(\$uri);\n\nswitch (\$uri) {\n    case 'home':\n        echo 'Home Page';\n        break;\n    case 'about':\n        echo 'About Page';\n        break;\n    default:\n        echo '404 Not Found';\n}\n",
        'ex2' => "<?php\n// Week 27: Front Controller Pattern\n// index.php receives all requests\nclass Router {\n    public function route(\$url) {\n        // Maps /post/edit/5 to PostController->edit(5)\n        echo \"Routing \$url...\";\n    }\n}\n"
    ],
    28 => [
        'ex1' => "<?php\n// Week 28: Basic View Separation\n// In controller:\n\$pageTitle = 'My Blog';\n\$content = 'Welcome to the blog index.';\n// include 'layout.php';\n\necho 'Views should NOT contain database logic, only HTML and simple display PHP.';\n",
        'ex2' => "<?php\n// Week 28: Output Escaping in Views\n\$username = '<script>alert(\"XSS\")</script>';\n\n// We must ALWAYS escape output in the view\nfunction e(\$string) {\n    return htmlspecialchars(\$string, ENT_QUOTES, 'UTF-8');\n}\n\necho \"<h1>Profile: \" . e(\$username) . \"</h1>\";\n"
    ],
    29 => [
        'ex1' => "<?php\n// Week 29: User Registration and Password Hashing\n\$password = 'SuperSecret123';\n\n// Hash the password\n\$hash = password_hash(\$password, PASSWORD_BCRYPT);\n\necho \"Original: \$password \\n\";\necho \"Hashed: \$hash \\n\";\n// Save \$hash to the database\n",
        'ex2' => "<?php\n// Week 29: Verifying Hashes\n\$inputPassword = 'SuperSecret123';\n\$dbHash = password_hash('SuperSecret123', PASSWORD_BCRYPT);\n\nif (password_verify(\$inputPassword, \$dbHash)) {\n    echo 'Password is correct!';\n} else {\n    echo 'Invalid credentials.';\n}\n"
    ],
    30 => [
        'ex1' => "<?php\n// Week 30: The Login Flow\nsession_start();\n\n// Abstracted Login Function\nfunction loginUser(\$userId) {\n    \$_SESSION['user_id'] = \$userId;\n    \$_SESSION['logged_in_time'] = time();\n    // Prevent Session Fixation:\n    session_regenerate_id(true);\n}\necho \"Logging in and regenerating session ID prevents fixation attacks.\";\n",
        'ex2' => "<?php\n// Week 30: Checking Auth State Middleware\nsession_start();\nfunction requireLogin() {\n    if (!isset(\$_SESSION['user_id'])) {\n        header('Location: /login.php');\n        exit;\n    }\n}\n// requireLogin(); \necho \"Protecting routes using simple session checks.\";\n"
    ],
    31 => [
        'ex1' => "<?php\n// Week 31: Authorization (Roles & Permissions)\nfunction hasRole(\$role) {\n    return isset(\$_SESSION['role']) && \$_SESSION['role'] === \$role;\n}\n\n// \$_SESSION['role'] = 'editor';\nif (hasRole('admin')) {\n    echo 'Admin Panel';\n} else {\n    echo 'Insufficient permissions.';\n}\n",
        'ex2' => "<?php\n// Week 31: Resource-level Permissions\nfunction canEditPost(\$userId, \$postOwnerId, \$userRole) {\n    if (\$userRole === 'admin') return true;\n    if (\$userId === \$postOwnerId) return true;\n    return false;\n}\n\necho \"Resource permissions ensure users can only modify their own data.\";\n"
    ],
    32 => [
        'ex1' => "<?php\n// Week 32: Web Security - CSRF\nsession_start();\nif (empty(\$_SESSION['csrf_token'])) {\n    \$_SESSION['csrf_token'] = bin2hex(random_bytes(32));\n}\n?>\n<form method='POST' action='/transfer'>\n    <input type='hidden' name='csrf_token' value='<?php echo \$_SESSION['csrf_token']; ?>'>\n    <button type='submit'>Transfer Money</button>\n</form>\n",
        'ex2' => "<?php\n// Week 32: Validating CSRF Token\nsession_start();\nif (\$_SERVER['REQUEST_METHOD'] === 'POST') {\n    if (!isset(\$_POST['csrf_token']) || \$_POST['csrf_token'] !== \$_SESSION['csrf_token']) {\n        die('CSRF Token Validation Failed.');\n    }\n    echo 'Form processed securely.';\n}\n"
    ],
    33 => [
        'ex1' => "<?php\n// Week 33: JSON and APIs\n\$data = [\n    'status' => 'success',\n    'users' => [\n        ['id' => 1, 'name' => 'Alice'],\n        ['id' => 2, 'name' => 'Bob']\n    ]\n];\n\nheader('Content-Type: application/json');\necho json_encode(\$data);\n",
        'ex2' => "<?php\n// Week 33: Decoding JSON POST requests\n\$jsonInput = '{\"name\": \"Alice\", \"age\": 25}';\n\$decodedContent = json_decode(\$jsonInput, true);\n\necho 'json_decode converts a JSON string to an associative array: ' . \$decodedContent['name'];\n"
    ],
    34 => [
        'ex1' => "<?php\n// Week 34: Consuming APIs with file_get_contents\n// This works if allow_url_fopen is enabled\n/*\n\$apiUrl = 'https://jsonplaceholder.typicode.com/posts/1';\n\$response = file_get_contents(\$apiUrl);\n\$data = json_decode(\$response, true);\necho 'Post Title: ' . \$data['title'];\n*/\necho 'Fetching API data simply.';\n",
        'ex2' => "<?php\n// Week 34: Consuming APIs with cURL\n/*\n\$ch = curl_init('https://jsonplaceholder.typicode.com/users/1');\ncurl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);\n\$response = curl_exec(\$ch);\ncurl_close(\$ch);\n\n\$user = json_decode(\$response, true);\necho 'User Name: ' . (\$user['name'] ?? 'Not found');\n*/\necho 'cURL gives advanced options to handle API requests.';\n"
    ],
    35 => [
        'ex1' => "<?php\n// Week 35: Building a REST API endpoint\nheader('Content-Type: application/json');\n\$method = \$_SERVER['REQUEST_METHOD'] ?? 'GET';\n\nif (\$method === 'GET') {\n    echo json_encode(['message' => 'Fetched data']);\n} elseif (\$method === 'POST') {\n    echo json_encode(['message' => 'Created data']);\n}\n",
        'ex2' => "<?php\n// Week 35: API Token Authentication\n\$authHeader = 'Bearer YOUR_SECRET_TOKEN'; // Example\n\nif (strpos(\$authHeader, 'Bearer ') === 0) {\n    \$token = substr(\$authHeader, 7);\n    if (\$token === 'YOUR_SECRET_TOKEN') {\n        echo 'Authenticated successfully.';\n    } else {\n        http_response_code(401);\n        echo 'Invalid Token.';\n    }\n} else {\n    http_response_code(401);\n    echo 'Missing Token.';\n}\n"
    ],
    36 => [
        'ex1' => "<?php\n// Week 36: Composer Setup\n// 1. Install Composer\n// 2. Run `composer init`\n// 3. Require packages like `composer require phpmailer/phpmailer`\necho \"Composer solves dependency management in modern PHP projects.\\n\";\n",
        'ex2' => "<?php\n// Week 36: PSR-4 Autoloading\n// Use namespaces to structure code\n// \n// namespace App\\Controllers;\n// class UserController {}\n// \n// In composer.json:\n// \"autoload\": { \"psr-4\": { \"App\\\\\": \"src/\" } }\n//\n// require 'vendor/autoload.php';\necho \"Using vendor/autoload.php includes all packages and your PSR-4 classes automatically.\";\n"
    ],
    37 => [
        'ex1' => "<?php\n// Week 37: Exceptions Pipeline\nfunction divide(\$a, \$b) {\n    if (\$b == 0) {\n        throw new Exception(\"Division by zero\");\n    }\n    return \$a / \$b;\n}\n\ntry {\n    echo divide(10, 0);\n} catch (Exception \$e) {\n    echo 'Caught exception: ' . \$e->getMessage();\n} finally {\n    echo \"\\nCleanup can happen here.\";\n}\n",
        'ex2' => "<?php\n// Week 37: Logging\n// Creating a simple log function\nfunction appLog(\$message) {\n    \$date = date('Y-m-d H:i:s');\n    @file_put_contents('app.log', \"[\$date] \$message\\n\", FILE_APPEND);\n}\n\nappLog('Application started successfully.');\necho 'Logged message to app.log';\n"
    ],
    38 => [
        'ex1' => "<?php\n// Week 38: Date and Time Basics\necho 'Current Timestamp: ' . time() . \"\\n\";\necho 'Formatted Date: ' . date('Y-m-d H:i:s') . \"\\n\";\n\$future = strtotime('+1 week');\necho 'Next week: ' . date('Y-m-d', \$future) . \"\\n\";\n",
        'ex2' => "<?php\n// Week 38: DateTime Classes\n\$date = new DateTime('now', new DateTimeZone('America/New_York'));\necho \"NY Time: \" . \$date->format('Y-m-d H:i:s') . \"\\n\";\n\n\$date->modify('+1 month');\necho \"Next Month: \" . \$date->format('Y-m-d H:i:s') . \"\\n\";\n"
    ],
    39 => [
        'ex1' => "<?php\n// Week 39: Final Project Architecture\n// We will combine Routing, MVC, PDO, and Auth into a single framework.\necho \"Structuring directories:\\n- public/index.php\\n- src/Controllers\\n- src/Models\\n- views/\\n- config/database.php\";\n",
        'ex2' => "<?php\n// Week 39: Application Entry Point\n// require '../vendor/autoload.php';\n// \$router = new Core\\Router();\n// \$router->loadRoutes('../routes.php');\n// \$router->dispatch();\necho \"A clean entry point is vital for a robust application.\";\n"
    ],
    40 => [
        'ex1' => "<?php\n// Week 40: Final Project Polish\n// Add input validation on all edges\n// Ensure all secrets are in .env files\n// Set up error logging appropriately\necho \"The final 10% of a project takes 90% of the time!\";\n",
        'ex2' => "<?php\n// Week 40: Deployment Checks\n// 1. Turn display_errors off in php.ini\n// 2. Ensure folder permissions are correct for uploads/logs\n// 3. Migrate database to production server\necho \"Congratulations on completing your PHP Journey!\";\n"
    ]
];

$dirs = array_filter(glob(__DIR__ . '/week_*'), 'is_dir');
foreach ($dirs as $dir) {
    preg_match('/week_(\d+)/', basename($dir), $matches);
    if (!isset($matches[1])) continue;
    $weekNum = (int)$matches[1];
    
    if (isset($examples[$weekNum])) {
        file_put_contents($dir . '/example_1.php', $examples[$weekNum]['ex1']);
        file_put_contents($dir . '/example_2.php', $examples[$weekNum]['ex2']);
    }
}
echo "Weeks 21-40 examples populated.\\n";
