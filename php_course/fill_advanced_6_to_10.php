<?php
/**
 * Advanced PHP Code Populate Tool - Weeks 6 to 10
 * Technical level (pre-university), 1.5-hour classes. Includes edge cases and actual projects.
 */

$examples = [
    6 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 6: Arrays Deep Dive (1.5 Hours)
 * Topics:
 * - Arrays as Ordered Maps
 * - Destructuring (List / [])
 * - Array Spread Operator (...)
 * - Multidimensional Arrays & Reference Assignment
 */

// 1. Array as Maps and Destructuring
$person = ['name' => 'Alice', 'role' => 'Admin', 'age' => 28];
// PHP 7.1+ Short Array Syntax Destructuring
['name' => $n, 'role' => $r] = $person;
echo "Destructured: Name=$n, Role=$r<br>\n";

// 2. Spread Operator (PHP 7.4+)
$baseSkills = ['HTML', 'CSS'];
$advancedSkills = ['PHP', ...$baseSkills, 'SQL']; // Merges Arrays natively
echo "Spread skills: " . implode(', ', $advancedSkills) . "<br>\n";

// 3. Array Manipulation (Push, Pop, Shift, Unshift)
array_push($advancedSkills, 'Git');
$firstItem = array_shift($advancedSkills); // Removes 'PHP'
echo "Removed $firstItem. Array is now: " . json_encode($advancedSkills) . "<br>\n";

// 4. Multidimensional Arrays reference assignment
$matrix = [
    ['id' => 1, 'v' => 10],
    ['id' => 2, 'v' => 20]
];

// Changing a multidimensional value by reference
$ref =& $matrix[0]['v']; // Connect $ref to the memory location
$ref = 999;
unset($ref); // IMPORTANT: Always unset references to avoid bugs!

echo "Matrix cell [0]['v'] modified via reference: {$matrix[0]['v']}<br>\n";

// 5. Examining bounds and strict parsing
$hash = [ 1 => 'A', '1' => 'B', 1.5 => 'C', true => 'D' ];
// PHP silently casts keys. '1', 1.5, and true all cast to Integer 1. 
// Thus, the array only holds ONE element!
print_r($hash);
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 6 Project: CLI Quiz Game - Data Structure Prep
 * 
 * We build the core data structure for our upcoming interactive quiz game.
 * Using multidimensional arrays to map Questions -> Options -> Answers.
 */

$quizData = [
    [
        'question' => "What does PHP stand for?",
        'options' => [
            'A' => "Personal Home Page",
            'B' => "PHP: Hypertext Preprocessor",
            'C' => "Private Hosting Platform"
        ],
        'correct' => 'B',
        'points' => 10
    ],
    [
        'question' => "Which operator is the Spaceship operator?",
        'options' => [
            'A' => "??",
            'B' => "||",
            'C' => "<=>"
        ],
        'correct' => 'C',
        'points' => 15
    ]
];

// Dynamically rendering the game prep check
echo "<h2>System Validation Checklist</h2><ul>";

foreach ($quizData as $idx => $q) {
    $isValid = isset($q['question'], $q['options'], $q['correct']);
    $color = $isValid ? 'green' : 'red';
    $status = $isValid ? 'OK' : 'BROKEN';
    
    echo "<li style='color:$color'>Question " . ($idx + 1) . ": $status (Worth {$q['points']} pts)</li>";
}
echo "</ul>";

echo "<em>Ready to build the looping logic next week!</em>";
EOT
    ],
    7 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 7: Loops, Complexity, and Recursion (1.5 Hours)
 * Topics:
 * - Nested Loops Performance
 * - Break and Continue with levels (break 2)
 * - Do-While limitations
 * - Intro to Recursion vs While loops
 */

// 1. Break and Continue across levels
echo "Searching a 2D grid:<br>\n";
$grid = [
    [1, 2, 3],
    [4, 99, 6],
    [7, 8, 9]
];

$found = false;
foreach ($grid as $y => $row) {
    foreach ($row as $x => $val) {
        if ($val === 99) {
            echo "Found 99 at coordinates ($x, $y)! Halting completely.<br>\n";
            $found = true;
            break 2; // Breaks out of BOTH foreach loops
        }
    }
}

// 2. Recursion vs While
// Factorial with while
function factorial_while($n) {
    $result = 1;
    while ($n > 1) {
        $result *= $n;
        $n--;
    }
    return $result;
}

// Factorial with Recursion
function factorial_recursive($n) {
    if ($n <= 1) return 1;
    return $n * factorial_recursive($n - 1);
}

echo "While Factorial of 5: " . factorial_while(5) . "<br>\n";
echo "Recursive Factorial of 5: " . factorial_recursive(5) . "<br>\n";

// 3. Infinite loop guards (time_limit)
// set_time_limit(5); // Useful in huge while loops downloading files.
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 7 Project: CLI Quiz Game - Core Loop
 * 
 * Instead of hardcoding HTML rendering, we simulate the interaction loop.
 * Note: Since this is run via a browser in this setup, we simulate CLI input.
 */

$simulatedInput = ['B', 'A']; // Pretend the user typed these in CLI
$quizData = [
    ['question' => "PHP is backend?", 'ans' => 'Y'],
    ['question' => "CSS is backend?", 'ans' => 'N']
];

$score = 0;
$i = 0;

// 1. A typical While loop for processing dynamic stacks
echo "<pre>Starting Quiz Simulation...\n";

while ($i < count($quizData)) {
    $q = $quizData[$i];
    $input = $simulatedInput[$i] ?? 'N/A'; // Simulate fetching input
    
    echo "Q: {$q['question']} (User typed: $input)\n";
    
    if ($input === $q['ans']) {
        echo " -> Correct!\n";
        $score++;
    } else {
        echo " -> Wrong! The answer was {$q['ans']}\n";
    }
    
    $i++;
}

echo "\nFinal Score: $score / " . count($quizData) . "</pre>";
EOT
    ],
    8 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 8: Advanced Foreach and Higher-Order Array Functions (1.5 Hours)
 * Topics:
 * - Modifying values in Foreach (& reference pitfall)
 * - array_map
 * - array_filter
 * - array_reduce
 */

// 1. The Foreach Reference Pitfall
$nums = [1, 2, 3];
foreach ($nums as &$val) {
    $val *= 2; // Double the array
}
// DANGER: $val is still referencing the LAST element of $nums
// If we run another foreach using $val, it overwrites the last element in $nums!
// Always unset immediately:
unset($val); 

// 2. array_map (Transforming data)
$prices = [10.00, 25.50, 9.99];
$taxRate = 1.05;

// Using arrow functions (fn) for succinct maps
$pricesWithTax = array_map(fn($p) => round($p * $taxRate, 2), $prices);
echo "Prices with Tax: " . implode(', ', $pricesWithTax) . "<br>\n";

// 3. array_filter (Removing data)
// Keeps only elements where the callback returns true
$validPrices = array_filter($pricesWithTax, fn($p) => $p > 10.00);
echo "Prices > \$10: " . implode(', ', $validPrices) . "<br>\n";

// 4. array_reduce (Accumulating data)
// Summing an array, or building a single string from an array
$totalSum = array_reduce($pricesWithTax, fn($carry, $item) => $carry + $item, 0.0);
echo "Total Sum: \$" . number_format($totalSum, 2) . "<br>\n";

// 5. Array key manipulation: array_column, array_combine etc.
$users = [['id' => 10, 'name' => 'Bob'], ['id' => 11, 'name' => 'Alice']];
$ids = array_column($users, 'id');
echo "Extracted IDs: " . implode(', ', $ids);
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 8 Project: CLI Quiz Game - Analytics
 * 
 * Using array_reduce and array_filter to extract statistics 
 * from our completed Quiz Game data.
 */

// Simulated Game History
$history = [
    ['q' => 1, 'correct' => true, 'time_sec' => 5],
    ['q' => 2, 'correct' => false, 'time_sec' => 15],
    ['q' => 3, 'correct' => true, 'time_sec' => 8],
    ['q' => 4, 'correct' => true, 'time_sec' => 12],
];

// 1. Calculate accuracy using array_filter
$correctAnswers = array_filter($history, fn($entry) => $entry['correct'] === true);
$accuracy = (count($correctAnswers) / count($history)) * 100;

// 2. Calculate total time using array_reduce
$totalTime = array_reduce($history, fn($sum, $entry) => $sum + $entry['time_sec'], 0);

// 3. Find the longest question using array_reduce as a comparator
$longestQuestion = array_reduce($history, function($carry, $entry) {
    return ($entry['time_sec'] > $carry['time_sec']) ? $entry : $carry;
}, ['time_sec' => 0]); 

echo "<h2>Quiz Analytics Report</h2>";
echo "<ul>";
echo "<li>Accuracy: " . number_format($accuracy, 1) . "%</li>";
echo "<li>Total Time Taken: {$totalTime} seconds</li>";
echo "<li>Most Difficult Question based on time: Question #{$longestQuestion['q']} ({$longestQuestion['time_sec']}s)</li>";
echo "</ul>";
EOT
    ],
    9 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 9: Deep Dive into Functions (1.5 Hours)
 * Topics:
 * - Return Types & Union Types (PHP 8)
 * - Variadic Arguments (...$args)
 * - Named Arguments (PHP 8)
 * - Pass by Reference vs Value
 */

// 1. Union Types and Strict Returns
// This function can accept INT or FLOAT, and return INT or FLOAT
function calculateArea(int|float $width, int|float $height): int|float {
    return $width * $height;
}
echo "Area: " . calculateArea(5.5, 10) . "<br>\n";

// 2. Variadic Arguments
// Accepts any number of arguments and packs them into an array
function sumAll(int ...$numbers): int {
    return array_sum($numbers); // Much cleaner than func_get_args()
}
echo "Sum of 1,2,3,4,5 = " . sumAll(1, 2, 3, 4, 5) . "<br>\n";

// 3. Named Arguments (PHP 8)
// You can skip optional parameters by explicitly naming the argument you want to set.
function setCookiePrefs(string $name, int $expires = 0, string $path = '', bool $secure = false) {
    return "Cookie $name set. Secure: " . ($secure ? 'Yes' : 'No') . "<br>\n";
}
// Skipping 'expires' and 'path' entirely!
echo setCookiePrefs(name: 'session_token', secure: true);

// 4. Pass by Reference
function modifyString(string &$text) {
    $text = strtoupper($text) . "_MODIFIED";
}
$original = "hello";
modifyString($original);
echo "Original variable after ref pass: $original <br>\n";
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

/**
 * Week 9 Project: Task Manager Web App - Abstraction
 * 
 * We abstract common HTML structures into reusable render functions.
 * Building the foundation of a View engine.
 */

/**
 * Renders an abstract HTML component dynamically.
 * 
 * @param string $title
 * @param string $content HTML content
 * @param array $styles Optional CSS inline styles
 */
function renderCard(string $title, string $content, array $styles = []): string {
    // Convert array styles to string: ['color' => 'red'] -> "color:red;"
    $styleString = array_reduce(array_keys($styles), function($carry, $key) use ($styles) {
        return $carry . htmlspecialchars($key) . ':' . htmlspecialchars($styles[$key]) . ';';
    }, '');

    $safeTitle = htmlspecialchars($title);
    
    // Heredoc for complex HTML return
    return <<<HTML
    <div style="border:1px solid #ddd; padding:15px; border-radius:5px; margin-bottom:15px; {$styleString}">
        <h3 style="margin-top:0;">{$safeTitle}</h3>
        <div>$content</div>
    </div>
HTML;
}

echo "<h2>Task Manager UI Test</h2>";

echo renderCard(
    title: "Finish PHP HW", 
    content: "<p>Complete the Array exercises for Chapter 2.</p>",
    styles: ['background-color' => '#fff3cd', 'border-color' => '#ffeeba'] // Warning format
);

echo renderCard(
    title: "Deploy App", 
    content: "<p>Push code to production server.</p>",
    styles: ['background-color' => '#d4edda', 'border-color' => '#c3e6cb'] // Success format
);
EOT
    ],
    10 => [
        'ex1' => <<<'EOT'
<?php
/**
 * Week 10: State, Scope, and Anonymous Functions (1.5 Hours)
 * Topics:
 * - Static Variables inside Functions
 * - Closures and `use` keyword
 * - Arrow Functions (`fn() =>`)
 * - Callback passing
 */

// 1. Static Variables inside Functions
// Static variables maintain their state between function calls, 
// unlike normal local variables which are wiped.
function incrementCounter() {
    static $count = 0; // Initialized ONLY the first time
    $count++;
    return $count;
}
echo "Call 1: " . incrementCounter() . "<br>\n"; // 1
echo "Call 2: " . incrementCounter() . "<br>\n"; // 2
echo "Call 3: " . incrementCounter() . "<br>\n"; // 3

// 2. Closures and State (use)
$taxRate = 0.20;
// We pass $taxRate into the closure via `use`. 
// To allow the closure to modify the external variable, we would use `use (&$taxRate)`
$applyTax = function($amount) use ($taxRate) {
    return $amount + ($amount * $taxRate);
};
echo "Applying 20% tax to $100: $" . $applyTax(100) . "<br>\n";

// 3. Arrow Functions
// PHP 7.4 introduced arrow functions. They AUTO-CAPTURE variables from the parent scope by value!
$taxRate2 = 0.15;
$applyTaxArrow = fn($amount) => $amount + ($amount * $taxRate2); // No `use` needed!
echo "Applying 15% tax to $100: $" . $applyTaxArrow(100) . "<br>\n";

// 4. Passing function as a parameter (Callback)
function executeWithLog(callable $action, $value) {
    echo "[LOG] Executing action... <br>\n";
    $result = $action($value);
    echo "[LOG] Finished with result: $result <br>\n";
}
executeWithLog(fn($v) => strtoupper($v), "hello world");
EOT,
        'ex2' => <<<'EOT'
<?php
/**
 * Week 10 Project: Task Manager Web App - Filtering Engine
 * 
 * We build a powerful engine to filter tasks based on arbitrary user-defined rules
 * using Higher-Order Functions and Closures.
 */

$tasks = [
    ['id' => 1, 'title' => 'Learn PHP', 'completed' => true,  'priority' => 1],
    ['id' => 2, 'title' => 'Build App', 'completed' => false, 'priority' => 1],
    ['id' => 3, 'title' => 'Go to Gym', 'completed' => false, 'priority' => 2],
    ['id' => 4, 'title' => 'Buy Milk',  'completed' => true,  'priority' => 3],
];

/**
 * Filter factory function: Returns a closure configured to filter a specific status.
 */
function createStatusFilter(bool $isCompleted): Closure {
    return fn($task) => $task['completed'] === $isCompleted;
}

/**
 * Filter factory for priority.
 */
function createPriorityFilter(int $priorityLevel): Closure {
    return fn($task) => $task['priority'] === $priorityLevel;
}

// Instantiate our rules
$filterCompleted = createStatusFilter(true);
$filterHighPriority = createPriorityFilter(1);

// Execute filters
$completedTasks = array_filter($tasks, $filterCompleted);
$highPriorityTasks = array_filter($tasks, $filterHighPriority);

echo "<h3>Completed Tasks:</h3><ul>";
foreach ($completedTasks as $t) echo "<li>{$t['title']}</li>";
echo "</ul>";

echo "<h3>High Priority Tasks:</h3><ul>";
foreach ($highPriorityTasks as $t) echo "<li>{$t['title']}</li>";
echo "</ul>";
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
echo "Advanced Weeks 6-10 examples populated successfully.\n";
