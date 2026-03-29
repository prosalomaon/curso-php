<?php

$examples = [
    1 => [
        'ex1' => "<?php\n// Week 1: Basic echo and print\necho '<h1>Welcome to PHP!</h1>';\nprint '<p>PHP is a server-side scripting language.</p>';\n",
        'ex2' => "<?php\n// Week 1: Mixing PHP with HTML\n\$title = 'Personal Bio';\n\$name = 'Future PHP Expert';\n?>\n<!DOCTYPE html>\n<html>\n<head><title><?= \$title ?></title></head>\n<body>\n    <h1>Hello, my name is <?= \$name ?>.</h1>\n    <p>I am starting my PHP journey today!</p>\n</body>\n</html>\n"
    ],
    2 => [
        'ex1' => "<?php\n// Week 2: Variables and Data Types\n\$name = 'Alice'; // String\n\$age = 28;     // Integer\n\$gpa = 3.9;    // Float\n\$isActive = true; // Boolean\n\nvar_dump(\$name, \$age, \$gpa, \$isActive);\n",
        'ex2' => "<?php\n// Week 2: Type Casting and Constants\ndefine('PI', 3.14159);\n\n\$numberString = '100';\n\$total = (int)\$numberString + 50;\n\necho \"Total: \$total, Pi is roughly \" . PI . \"\\n\";\n"
    ],
    3 => [
        'ex1' => "<?php\n// Week 3: Arithmetic and Assignment Operators\n\$a = 15;\n\$b = 4;\n\necho 'Addition: ' . (\$a + \$b) . \"\\n\";\necho 'Modulo: ' . (\$a % \$b) . \"\\n\";\n\$a += 5; // \$a is now 20\necho 'New A: ' . \$a . \"\\n\";\n",
        'ex2' => "<?php\n// Week 3: Comparison and Logical Operators\n\$isLogged = true;\n\$hasPermission = false;\n\nif (\$isLogged && !\$hasPermission) {\n    echo 'Access Denied: You need permission.\\n';\n}\nif (10 === '10') {\n    echo 'Strict equals.\\n';\n} else {\n    echo 'Not strict equals.\\n';\n}\n"
    ],
    4 => [
        'ex1' => "<?php\n// Week 4: String Interpolation and Length\n\$user = 'Bob';\necho \"Welcome back, {\$user}!\\n\"; // Double quotes interpolate\necho 'String length: ' . strlen(\$user) . \"\\n\";\n",
        'ex2' => "<?php\n// Week 4: String Functions\n\$sentence = 'The quick brown fox jumps over the lazy dog.';\necho strtoupper(\$sentence) . \"\\n\";\necho str_replace('fox', 'cat', \$sentence) . \"\\n\";\necho 'Position of fox: ' . strpos(\$sentence, 'fox') . \"\\n\";\n"
    ],
    5 => [
        'ex1' => "<?php\n// Week 5: If, Else, Elseif\n\$score = 85;\nif (\$score >= 90) {\n    echo 'Grade: A\\n';\n} elseif (\$score >= 80) {\n    echo 'Grade: B\\n';\n} else {\n    echo 'Grade: C or below\\n';\n}\n",
        'ex2' => "<?php\n// Week 5: Switch and Match (PHP 8)\n\$role = 'editor';\n\nswitch (\$role) {\n    case 'admin':\n        echo 'Full Dashboard Access\\n';\n        break;\n    case 'editor':\n        echo 'Can edit posts\\n';\n        break;\n    default:\n        echo 'Visitor Access\\n';\n}\n\n// PHP 8 Match expression\n\$access = match(\$role) {\n    'admin' => 'Level 1',\n    'editor' => 'Level 2',\n    default => 'Level 3'\n};\necho \"Match Result: \$access\\n\";\n"
    ],
    6 => [
        'ex1' => "<?php\n// Week 6: Indexed Arrays\n\$colors = ['Red', 'Green', 'Blue'];\n\$colors[] = 'Yellow'; // Append\n\nprint_r(\$colors);\necho 'The second color is ' . \$colors[1] . \"\\n\";\n",
        'ex2' => "<?php\n// Week 6: Associative Arrays\n\$user = [\n    'name' => 'John Doe',\n    'email' => 'john@example.com',\n    'role' => 'subscriber'\n];\n\necho \"User {\$user['name']} has role: {\$user['role']}\\n\";\nvar_dump(array_keys(\$user));\n"
    ],
    7 => [
        'ex1' => "<?php\n// Week 7: For Loop\nfor (\$i = 1; \$i <= 5; \$i++) {\n    echo \"Iteration \$i\\n\";\n}\n",
        'ex2' => "<?php\n// Week 7: While and Do-While Loops\n\$count = 0;\nwhile (\$count < 3) {\n    echo \"While count: \$count\\n\";\n    \$count++;\n}\n\n\$doCount = 0;\ndo {\n    echo \"Do-while always runs at least once. Count: \$doCount\\n\";\n    \$doCount++;\n} while (\$doCount < 2);\n"
    ],
    8 => [
        'ex1' => "<?php\n// Week 8: Foreach Loop\n\$fruits = ['Apple', 'Banana', 'Orange'];\nforeach (\$fruits as \$fruit) {\n    echo \"I like \$fruit!\\n\";\n}\n\n\$user = ['name' => 'Alice', 'age' => 25];\nforeach (\$user as \$key => \$value) {\n    echo ucfirst(\$key) . ': ' . \$value . \"\\n\";\n}\n",
        'ex2' => "<?php\n// Week 8: Array Functions\n\$numbers = [5, 2, 8, 1];\nsort(\$numbers);\nprint_r(\$numbers);\n\n\$filtered = array_filter(\$numbers, fn(\$n) => \$n > 3);\nprint_r(\$filtered);\necho 'Total items: ' . count(\$numbers) . \"\\n\";\n"
    ],
    9 => [
        'ex1' => "<?php\n// Week 9: User-Defined Functions\nfunction greetUser(\$name) {\n    return \"Hello, \$name! Welcome to our app.\\n\";\n}\n\necho greetUser('Admin');\necho greetUser('Guest');\n",
        'ex2' => "<?php\n// Week 9: Type Hinting and Default Arguments\nfunction addNumbers(int \$a, int \$b = 10): int {\n    return \$a + \$b;\n}\n\necho '5 + 10 = ' . addNumbers(5) . \"\\n\";\necho '5 + 20 = ' . addNumbers(5, 20) . \"\\n\";\n"
    ],
    10 => [
        'ex1' => "<?php\n// Week 10: Variable Scope (Global and Local)\n\$globalVar = 'I am global';\n\nfunction testScope() {\n    global \$globalVar;\n    \$localVar = 'I am local';\n    echo \"Inside: \$globalVar | \$localVar\\n\";\n}\n\ntestScope();\n",
        'ex2' => "<?php\n// Week 10: Anonymous Functions and Closures\n\$multiplier = 3;\n\n\$triple = function(\$num) use (\$multiplier) {\n    return \$num * \$multiplier;\n};\n\necho \"5 tripled is \" . \$triple(5) . \"\\n\";\n"
    ],
    11 => [
        'ex1' => "<?php\n// Week 11: Superglobals (\$_SERVER and \$_GET)\necho 'Your IP: ' . (\$_SERVER['REMOTE_ADDR'] ?? 'Unknown') . \"\\n\";\necho 'Browser: ' . (\$_SERVER['HTTP_USER_AGENT'] ?? 'Unknown') . \"\\n\";\n\n\$name = \$_GET['name'] ?? 'Guest';\necho \"Welcome, \$name!\\n\";\n",
        'ex2' => "<?php\n// Week 11: Superglobals (\$_POST)\nif (\$_SERVER['REQUEST_METHOD'] === 'POST') {\n    \$username = \$_POST['username'] ?? '';\n    echo \"Form submitted with username: \$username\\n\";\n}\n?>\n<form method='POST'>\n    <input type='text' name='username' placeholder='Username'>\n    <button type='submit'>Submit</button>\n</form>\n"
    ],
    12 => [
        'ex1' => "<?php\n// Week 12: Basic Form Validation\n\$error = '';\nif (\$_SERVER['REQUEST_METHOD'] === 'POST') {\n    if (empty(\$_POST['email'])) {\n        \$error = 'Email is required.';\n    } elseif (!filter_var(\$_POST['email'], FILTER_VALIDATE_EMAIL)) {\n        \$error = 'Invalid email format.';\n    } else {\n        echo 'Valid email: ' . htmlspecialchars(\$_POST['email']);\n    }\n}\n?>\n<form method='POST'>\n    <?= \$error ? \"<p style='color:red'>\$error</p>\" : '' ?>\n    <input type='email' name='email'>\n    <button type='submit'>Validate</button>\n</form>\n",
        'ex2' => "<?php\n// Week 12: Sanitization\n\$dirtyInput = \"<script>alert('hack');</script> Hello!\";\n\n\$cleanHTML = htmlspecialchars(\$dirtyInput, ENT_QUOTES, 'UTF-8');\n\$noTags = strip_tags(\$dirtyInput);\n\necho \"Clean HTML: \$cleanHTML \\n\";\necho \"No tags: \$noTags \\n\";\n"
    ],
    13 => [
        'ex1' => "<?php\n// Week 13: Sessions\nsession_start();\n\n\$_SESSION['user_id'] = 42;\n\$_SESSION['username'] = 'john_doe';\n\necho 'Session variables are set. Refresh the page to see them persist.\\n';\n",
        'ex2' => "<?php\n// Week 13: Reading and Destroying Sessions\nsession_start();\n\nif (isset(\$_SESSION['username'])) {\n    echo \"Welcome back, {\$_SESSION['username']}!\\n\";\n} else {\n    echo \"Please log in.\\n\";\n}\n"
    ],
    14 => [
        'ex1' => "<?php\n// Week 14: Setting and Reading Cookies\n\$cookieName = 'user_preference';\n\$cookieValue = 'dark_mode';\n\nsetcookie(\$cookieName, \$cookieValue, time() + (86400 * 30), '/');\n\nif (isset(\$_COOKIE[\$cookieName])) {\n    echo \"Your preference is: \" . \$_COOKIE[\$cookieName];\n} else {\n    echo \"Cookie not set. Refresh to see it.\";\n}\n",
        'ex2' => "<?php\n// Week 14: Deleting Cookies\n\$cookieName = 'user_preference';\n\nsetcookie(\$cookieName, '', time() - 3600, '/');\n\necho \"Cookie '{\$cookieName}' has been deleted.\\n\";\n"
    ],
    15 => [
        'ex1' => "<?php\n// Week 15: File System Basics\n\$file = 'data.txt';\n\nfile_put_contents(\$file, \"Hello, this is a test line.\\n\");\n\n\$content = file_get_contents(\$file);\necho \"File Content: \\n\" . \$content;\n",
        'ex2' => "<?php\n// Week 15: File Appending\n\$file = 'data.txt';\n\nfile_put_contents(\$file, \"Appending another line.\\n\", FILE_APPEND);\n\nif (file_exists(\$file)) {\n    echo \"File size: \" . filesize(\$file) . \" bytes.\\n\";\n}\n"
    ],
    16 => [
        'ex1' => "<?php\n// Week 16: File Uploads\nif (\$_SERVER['REQUEST_METHOD'] === 'POST' && isset(\$_FILES['avatar'])) {\n    \$uploadDir = __DIR__ . '/uploads/';\n    if (!is_dir(\$uploadDir)) mkdir(\$uploadDir);\n    \n    \$targetFile = \$uploadDir . basename(\$_FILES['avatar']['name']);\n    if (move_uploaded_file(\$_FILES['avatar']['tmp_name'], \$targetFile)) {\n        echo \"File uploaded successfully.\";\n    } else {\n        echo \"Upload failed.\";\n    }\n}\n?>\n<form method='POST' enctype='multipart/form-data'>\n    <input type='file' name='avatar'>\n    <button type='submit'>Upload</button>\n</form>\n",
        'ex2' => "<?php\n// Week 16: Secure File Uploads\nif (\$_SERVER['REQUEST_METHOD'] === 'POST' && isset(\$_FILES['avatar'])) {\n    \$fileInfo = finfo_open(FILEINFO_MIME_TYPE);\n    \$mimeType = finfo_file(\$fileInfo, \$_FILES['avatar']['tmp_name']);\n    finfo_close(\$fileInfo);\n    \n    \$allowedTypes = ['image/jpeg', 'image/png'];\n    if (in_array(\$mimeType, \$allowedTypes)) {\n        echo \"Valid image type!\";\n    } else {\n        echo \"Error: Invalid file type.\";\n    }\n}\n"
    ],
    17 => [
        'ex1' => "<?php\n// Week 17: Intro to OOP\nclass User {\n    public \$name;\n    \n    public function sayHello() {\n        return \"Hello, my name is {\$this->name}.\";\n    }\n}\n\n\$user1 = new User();\n\$user1->name = 'Alice';\necho \$user1->sayHello();\n",
        'ex2' => "<?php\n// Week 17: Multiple Objects\nclass User {\n    public \$name;\n    public function sayHello() {\n        return \"Hello, my name is {\$this->name}.\";\n    }\n}\n\$user2 = new User();\n\$user2->name = 'Bob';\n\necho \$user2->sayHello();\n"
    ],
    18 => [
        'ex1' => "<?php\n// Week 18: Constructors and Visibility\nclass Product {\n    private \$price;\n    public \$name;\n    \n    public function __construct(\$name, \$price) {\n        \$this->name = \$name;\n        \$this->setPrice(\$price);\n    }\n    \n    public function setPrice(\$price) {\n        if (\$price > 0) \$this->price = \$price;\n    }\n    \n    public function getPrice() {\n        return \$this->price;\n    }\n}\n\n\$laptop = new Product('Laptop', 999.99);\necho \$laptop->name . ' costs $' . \$laptop->getPrice();\n",
        'ex2' => "<?php\n// Week 18: PHP 8 Constructor Property Promotion\nclass Employee {\n    public function __construct(\n        public string \$name,\n        private float \$salary\n    ) {}\n    \n    public function getSalary(): float {\n        return \$this->salary;\n    }\n}\n\n\$emp = new Employee('Jane', 75000);\necho \$emp->name . ' earns ' . \$emp->getSalary();\n"
    ],
    19 => [
        'ex1' => "<?php\n// Week 19: Inheritance\nclass Animal {\n    public function sound() {\n        return \"Some generic sound\";\n    }\n}\n\nclass Dog extends Animal {\n    public function sound() {\n        return \"Woof!\";\n    }\n}\n\n\$dog = new Dog();\necho \$dog->sound(); // Output: Woof!\n",
        'ex2' => "<?php\n// Week 19: Protected visibility and parent::\nclass BankAccount {\n    protected \$balance = 0;\n    public function deposit(\$amount) { \$this->balance += \$amount; }\n}\n\nclass PremiumAccount extends BankAccount {\n    public function deposit(\$amount) {\n        parent::deposit(\$amount);\n        \$this->balance += 10; // Bonus\n    }\n    public function getBalance() { return \$this->balance; }\n}\n\n\$acc = new PremiumAccount();\n\$acc->deposit(100);\necho 'Balance: ' . \$acc->getBalance();\n"
    ],
    20 => [
        'ex1' => "<?php\n// Week 20: Interfaces\ninterface LoggerInterface {\n    public function log(string \$message);\n}\n\nclass FileLogger implements LoggerInterface {\n    public function log(string \$message) {\n        echo \"Logging to file: \$message\\n\";\n    }\n}\n\n\$logger = new FileLogger();\n\$logger->log('System started');\n",
        'ex2' => "<?php\n// Week 20: Abstract Classes\nabstract class Shape {\n    abstract public function getArea();\n}\n\nclass Square extends Shape {\n    private \$side;\n    public function __construct(\$side) { \$this->side = \$side; }\n    public function getArea() { return \$this->side * \$this->side; }\n}\n\n\$sq = new Square(5);\necho \"Area: \" . \$sq->getArea();\n"
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
echo "Weeks 1-20 examples populated.\\n";
