<?php
/**
 * Advanced PHP Code Populate Tool - Weeks 1 to 5
 * Technical level (pre-university), 1.5-hour classes. Includes edge cases and actual projects.
 */

$examples = [
    1 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 1: Introduction, Output, and Environment (1.5 Hours)
 * 
 * Topics:
 * - echo vs print vs printf vs var_dump
 * - PHP Tags: <?php, <?=
 * - Quotations and Escaping
 * - Heredoc & Nowdoc
 */

// 1. Echo and Print
// echo is a language construct, slightly faster, can take multiple parameters.
echo "Echo parameter 1", " ... parameter 2\n<br>";

// print behaves like a function and returns 1. Useful in expressions.
$result = print("Print returns a value\n<br>");
echo " Result of print: $result \n<br>";

// 2. printf - Formatted output
// Very useful for strict formatting.
$pi = 3.14159;
printf("PI to two decimal places is: %.2f\n<br>", $pi);

// 3. Quotes
$course = 'PHP';
echo 'Single quotes do NOT parse variables like $course\n<br>'; // Literal string
echo "Double quotes DO parse variables like $course\n<br>"; // Parses variables and special chars

// 4. Multi-line Strings
// Heredoc (acts like double quotes)
$heredoc = <<<EOL
This is a Heredoc string.
We are learning $course.
It spans multiple lines easily.
EOL;
echo nl2br($heredoc) . "<br>";

// Nowdoc (acts like single quotes)
$nowdoc = <<<'EOL'
This is a Nowdoc string.
Variables like $course are NOT parsed.
EOL;
echo nl2br($nowdoc) . "<br>";
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 1 Project: Personal Bio Page - Skeleton and Logic Setup
 * 
 * Real-world integration: We are building the base of a dynamic Bio Page.
 * Instead of static HTML, we use PHP to dynamically set greetings based on time.
 */

date_default_timezone_set('America/Sao_Paulo');
$currentHour = (int)date('H');

// Determine greeting based on the hour (Edge cases handled)
if ($currentHour >= 5 && $currentHour < 12) {
    $greeting = 'Good Morning';
    $theme = 'morning-theme'; // Could be used for CSS classes later
} elseif ($currentHour >= 12 && $currentHour < 18) {
    $greeting = 'Good Afternoon';
    $theme = 'afternoon-theme';
} else {
    $greeting = 'Good Evening';
    $theme = 'evening-theme';
}

$pageTitle = "My Personal Bio";
$fullName = "Student Name";
$profession = "Aspiring Software Engineer";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
        .morning-theme { background-color: #fdf6e3; color: #333; }
        .afternoon-theme { background-color: #fffaf0; color: #444; }
        .evening-theme { background-color: #2c3e50; color: #ecf0f1; }
        .bio-card { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
    </style>
</head>
<body class="<?= $theme ?>">
    <div class="bio-card">
        <h1><?= $greeting ?>, I am <?= htmlspecialchars($fullName) ?></h1>
        <h3><?= htmlspecialchars($profession) ?></h3>
        <p>This is my dynamically generated PHP bio page. The theme updates based on the current server time.</p>
        <p><small>Current Server Time: <?= date('Y-m-d H:i:s') ?></small></p>
    </div>
</body>
</html>
EOT
    ],
    2 => [
        'ex1' => <<<'EOT'
<?php
// Strict types enforce that the types given to functions match exactly what was declared.
declare(strict_types=1);

/**
 * Week 2: Advanced Variables, Types, and Constants (1.5 Hours)
 * Topics:
 * - Strict Types
 * - Type Casting vs Type Juggling
 * - Constants (define vs const)
 * - Magic Constants
 */

// 1. Constants
define('MAX_LOGIN_ATTEMPTS', 3); // Defined at runtime
const APP_ENV = 'development'; // Defined at compile time, slightly faster

echo "Environment: " . APP_ENV . "\n<br>";

// 2. Type Casting vs Juggling
$stringNumber = "120.5";
$integer = (int)$stringNumber; // Explicit cast (truncates 0.5)
$float = (float)$stringNumber; // Explicit cast to float

echo "Integer string '120.5' casted identically to int: " . $integer . "\n<br>";

// 3. Strict Typing in Functions
// Because we have `declare(strict_types=1)` at the top, passing a string to this function
// will cause a Fatal TypeError, stopping bad data early in our app!
function calculateTax(float $amount, float $rate): float {
    return $amount * $rate;
}

try {
    echo "Tax: " . calculateTax(100.50, 0.05) . "\n<br>";
    // Uncommenting the below line will crash the script because '0.05' is a string.
    // echo "Tax String: " . calculateTax(100.50, '0.05'); 
} catch (TypeError $e) {
    echo "Caught Strict Type Error: " . $e->getMessage() . "\n<br>";
}

// 4. Magic Constants (Constants that change depending on context)
echo "This code is in directory: " . __DIR__ . "\n<br>";
echo "Current File: " . __FILE__ . "\n<br>";
echo "Current Line: " . __LINE__ . "\n<br>";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 2 Project: Personal Bio Page - Data Structure & Typing
 * 
 * We now extract the bio data into properly typed variables and constants.
 */

const SITE_NAME = 'My Modern Resume';

$firstName = 'Jane';
$lastName = 'Doe';
$birthYear = 2005;
$currentYear = (int)date('Y'); // Cast to strictly be an integer

$isAvailableForHire = true;
$expectedSalary = 4500.50; // Float

// Calculating age dynamically
$age = $currentYear - $birthYear;

// An array structuring our skills (We will cover arrays deeply later, but good for overview)
$skills = ['PHP 8', 'HTML5', 'CSS3', 'JavaScript'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= SITE_NAME ?> | <?= htmlspecialchars($firstName . ' ' . $lastName) ?></title>
</head>
<body style="font-family: Arial, sans-serif; margin: 40px;">

    <h1><?= htmlspecialchars($firstName) ?> <?= htmlspecialchars($lastName) ?></h1>
    <p>Age: <?= $age ?> years old</p>
    <p>Status: <?= $isAvailableForHire ? '<strong style="color:green;">Available for Hire</strong>' : '<strong style="color:red;">Currently Employed</strong>' ?></p>
    
    <h2>Expected Salary</h2>
    <p>$<?= number_format($expectedSalary, 2) ?> USD / Month</p>

    <h2>Top Skills</h2>
    <ul>
        <?php foreach ($skills as $skill): ?>
            <li><?= htmlspecialchars($skill) ?></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
EOT
    ],
    3 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 3: Operators Deep Dive (1.5 Hours)
 * Topics:
 * - Spaceship Operator (<=>)
 * - Null Coalescing Operator (??)
 * - Null Coalescing Assignment (??=)
 * - Execution Operators (``)
 * - Bitwise Operators
 */

// 1. Spaceship Operator (<=>) for sorting algorithms
// Returns -1 if left is smaller, 0 if equal, 1 if left is greater.
echo "1 <=> 2 equals " . (1 <=> 2) . "\n<br>"; // -1
echo "2 <=> 2 equals " . (2 <=> 2) . "\n<br>"; // 0
echo "3 <=> 2 equals " . (3 <=> 2) . "\n<br>"; // 1

// 2. Null Coalescing Operator (??)
// Safely retrieves a value if it exists and is not null; otherwise, sets a default.
// Much cleaner than `isset($var) ? $var : 'default'`
$userData = ['username' => 'admin']; // 'email' is missing
$email = $userData['email'] ?? 'no-reply@example.com';
echo "Email assigned via ??: $email \n<br>";

// 3. Null Coalescing Assignment (??=) (PHP 7.4+)
// Sets the variable ONLY if it is currently null or undefined.
$settings = ['theme' => 'dark'];
$settings['theme'] ??= 'light'; // Won't change because 'dark' exists
$settings['font'] ??= 'Arial';  // Will be set because 'font' didn't exist
echo "Theme: {$settings['theme']}, Font: {$settings['font']} \n<br>";

// 4. Execution Operators
// Runs command line code. Disabled in restrictive environments.
try {
    // $output = `dir`; // Windows
    $output = `echo Hello from CLI`; // Works across OS generally
    echo "CLI Execution Output: $output \n<br>";
} catch (Exception $e) {}

// 5. Bitwise Operators (Used in advanced low-level formatting or permissions)
// AND (&), OR (|), XOR (^), NOT (~), Shift Left (<<), Shift Right (>>)
$read = 1;    // 0001
$write = 2;   // 0010
$execute = 4; // 0100

// Assigning read and execute
$userPermission = $read | $execute; // 0101 (5)
if ($userPermission & $read) echo "User can read!\n<br>";
if (!($userPermission & $write)) echo "User CANNOT write!\n<br>"; 
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 3 Project: Bio Page Advanced Logic
 * 
 * Using Null Coalescing, Spaceship operators, and dynamic data handling
 * to calculate project history and handle missing configurations.
 */

// Simulated database row (Notice missing 'portfolio_url')
$bioData = [
    'experience_years' => 3,
    'github_stars' => 150,
    'competitor_stars' => 120,
];

// Fallbacks using Null Coalescing
$portfolioUrl = $bioData['portfolio_url'] ?? 'Not setup yet';

// Compare our skills using the Spaceship Operator
$comparison = $bioData['github_stars'] <=> $bioData['competitor_stars'];
if ($comparison === 1) {
    $statusText = "I have more stars than the competitor! 🚀";
} elseif ($comparison === -1) {
    $statusText = "I have fewer stars than the competitor. Keep grinding! 💻";
} else {
    $statusText = "We have the exact same number of stars! 🤝";
}

?>
<!DOCTYPE html>
<html>
<head><title>Bio Stats</title></head>
<body>
    <h2>Portfolio Link: <?= htmlspecialchars($portfolioUrl) ?></h2>
    <div style="padding: 15px; border-left: 5px solid blue; background: #f0f8ff;">
        <strong>Github Rivalry Status:</strong> <?= $statusText ?>
    </div>
</body>
</html>
EOT
    ],
    4 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 4: Advanced Strings and Regular Expressions (1.5 Hours)
 * Topics:
 * - Multibyte Strings (mb_*)
 * - Regex matching (preg_match)
 * - Regex replacing (preg_replace)
 * - String parsing
 */

// 1. Multibyte Strings
// Standard strlen() counts bytes, which breaks on emoji and special characters.
$stringWithEmoji = "Açúcar ☕";
echo "Normal strlen: " . strlen($stringWithEmoji) . "\n<br>";     // 11 (incorrect logic length)
echo "Multibyte mb_strlen: " . mb_strlen($stringWithEmoji) . "\n<br>"; // 8 (correct character length)

// 2. Regular Expressions (preg_match)
// Verifying a strict phone number format: (XXX) XXX-XXXX
$phone = '(123) 456-7890';
$pattern = '/^\(\d{3}\)\s\d{3}-\d{4}$/';

if (preg_match($pattern, $phone)) {
    echo "Phone $phone is VALID.\n<br>";
} else {
    echo "Phone $phone is INVALID.\n<br>";
}

// 3. Regex Replacing (preg_replace)
// Masking an email address for privacy
$email = "johndoe@example.com";
// Replaces characters before the @ that aren't the first character with '*'
$maskedEmail = preg_replace('/(?<=.).(?=.*@)/', '*', $email);
echo "Masked Email: $maskedEmail \n<br>";

// 4. Extracting data
$text = "Contact me at 555-0101 or 555-0202.";
preg_match_all('/\d{3}-\d{4}/', $text, $matches);
echo "Extracted Phone Numbers: \n<br>";
print_r($matches[0]);
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 4 Project: Bio Page Formatter
 * 
 * Cleaning up user-submitted text for the biography block.
 * Using Regex to strip bad words and format spacing.
 */

// Unformatted input containing excess spaces, bad words (heck, darn), and unformatted lists.
$rawAboutMe = "I   am a    developer. I work extremely darn hard. My skills include PHP- HTML- and CSS. What the heck !";

// 1. Strip multiple consecutive spaces down to one space.
$cleanSpaces = preg_replace('/\s+/', ' ', $rawAboutMe);

// 2. Censor inappropriate words
$badWords = ['darn', 'heck', 'shoot'];
$regexBadWords = '/\b(' . implode('|', $badWords) . ')\b/i';
$censoredText = preg_replace($regexBadWords, '****', $cleanSpaces);

// 3. Format "PHP- HTML- CSS" to a bulleted list conceptually by replacing hyphens conditionally.
// (In a real app, lists should be handled via array structures, but this is a regex exercise)
$listReplaced = preg_replace('/-\s*/', ', ', $censoredText);
$listReplaced = trim($listReplaced, " ,"); // remove trailing commas

?>
<!DOCTYPE html>
<html>
<head><title>Bio Text Processor</title></head>
<body>
    <h3>Original Bio</h3>
    <p><?= htmlspecialchars($rawAboutMe) ?></p>

    <h3>Processed Bio (Cleaned & Censored)</h3>
    <p style="color: darkgreen; border: 1px dashed green; padding: 10px;">
        <?= htmlspecialchars($listReplaced) ?>
    </p>
</body>
</html>
EOT
    ],
    5 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 5: Advanced Control Structures & Alternative Syntax (1.5 Hours)
 * Topics:
 * - Match vs Switch Performance & Strictness
 * - Alternative Syntax for Templates
 * - Goto statement (And why to avoid it)
 */

// 1. Match vs Switch
// switch uses loose comparison (==) which can cause bugs. Match uses strict (===).

$status = '200'; // String

// Switch will match because '200' == 200
switch ($status) {
    case 200:
        echo "Switch: OK (Loose Match)\n<br>";
        break;
}

// Match will fail if strict type doesn't match unless we catch it.
try {
    $message = match($status) {
        200 => 'OK',
        '200' => 'String OK',
        404 => 'Not Found',
        default => 'Unknown Server Error' // Match forces you to handle unhandled cases!
    };
    echo "Match Result: $message \n<br>";
} catch (UnhandledMatchError $e) {
    echo "Strict Match Failed!\n<br>";
}

// 2. Goto statement
// Generally considered bad practice because it creates "spaghetti code"
// But it exists in PHP. It is ONLY valid in the same file/context.
echo "Starting process...\n<br>";
if (true) {
    goto end_process;
}
echo "This will be skipped.\n<br>";

end_process:
echo "Process ended via goto jump.\n<br>";

// 3. Alternative Syntax (Demoed in example_2 for templating)
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 5 Project: Number Guessing Game / CLI Quiz Logic Prep
 * 
 * While the actual game runs best in CLI (Terminal), we'll build the logic flow
 * using alternative syntax designed for templating (HTML rendering).
 */

// Simulating game state
$gameActive = true;
$score = 85;
$guessesLeft = 3;
$messages = ["Try a lower number!", "Almost there!", "Don't give up!"];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Game State Template</title>
    <style>
        .container { background: #333; color: #fff; padding: 20px; font-family: monospace; }
        .win { color: #00ff00; }
        .lose { color: #ff0000; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Alternative IF Syntax: Much cleaner in HTML than {} braces -->
        <?php if ($gameActive): ?>
            <h2>Game is currently active!</h2>
            
            <p>Guesses remaining: <?= $guessesLeft ?></p>
            
            <!-- Alternative FOR Syntax -->
            <ul>
            <?php for ($i = 0; $i < $guessesLeft; $i++): ?>
                <li>Guess Slot <?= $i + 1 ?> Available</li>
            <?php endfor; ?>
            </ul>

            <!-- Alternative FOREACH Syntax -->
            <hr>
            <h4>Recent Hints:</h4>
            <?php foreach ($messages as $hint): ?>
                <blockquote>- <?= htmlspecialchars($hint) ?></blockquote>
            <?php endforeach; ?>

        <?php elseif ($score >= 80): ?>
            <h2 class="win">You won the game with a score of <?= $score ?>!</h2>
        <?php else: ?>
            <h2 class="lose">Game Over. Please try again.</h2>
        <?php endif; ?>
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
echo "Advanced Weeks 1-5 examples populated successfully.\n";
