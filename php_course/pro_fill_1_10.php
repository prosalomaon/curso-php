<?php
/**
 * Professional PHP Code Populate Tool - Weeks 1 to 10
 * Separates MVC logic from Views. Includes sleek UI via header/footer.
 */

$examples = [
    1 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 1: PHP Syntax & Architecture";
$systemVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown CLI';
$currentDate = date('Y-m-d H:i:s');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Welcome to the Professional Environment</h2>
    <p>PHP gives us incredible flexibility to interact with server configuration dynamically.</p>
</div>

<div class="info-box">
    <strong>System Properties Loaded Separately:</strong>
    <ul>
        <li><strong>PHP Engine Version:</strong> <?= htmlspecialchars($systemVersion) ?></li>
        <li><strong>Web Server:</strong> <?= htmlspecialchars($serverSoftware) ?></li>
        <li><strong>Execution Timestamp:</strong> <?= htmlspecialchars($currentDate) ?></li>
    </ul>
</div>

<p><em>Notice how clean this source code is compared to legacy echo statements!</em></p>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 1 Project: Dynamic Bio Page";

// Initializing state for our frontend app
$profile = [
    'name' => 'Jane Doe',
    'profession' => 'Senior Backend Engineer',
    'skills' => ['PHP 8', 'Architecture', 'CSS Design', 'Database Modeling'],
    'available_for_hire' => true
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2 style="font-size: 2em; margin-bottom: 0;"><?= htmlspecialchars($profile['name']) ?></h2>
    <p style="text-transform: uppercase; font-weight: bold; color: #555;"><?= htmlspecialchars($profile['profession']) ?></p>
    <hr>
    
    <h3>Core Competencies:</h3>
    <ul>
        <?php foreach ($profile['skills'] as $skill): ?>
            <li><?= htmlspecialchars($skill) ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($profile['available_for_hire']): ?>
        <div class="success-box">
            <strong>Open to Work:</strong> Currently accepting new architectural contracts.
        </div>
    <?php else: ?>
        <div class="error-box">
            <strong>Unavailable:</strong> Currently fully booked on major projects.
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    2 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 2: Scalar Types & Memory in PHP 8";

$dataTypes = [
    ['type' => 'Integer', 'value' => 404, 'check' => is_int(404)],
    ['type' => 'Float', 'value' => 3.14159, 'check' => is_float(3.14159)],
    ['type' => 'String', 'value' => "Interpolated Data", 'check' => is_string("Interpolated Data")],
    ['type' => 'Boolean', 'value' => true, 'check' => is_bool(true)],
    ['type' => 'Null', 'value' => null, 'check' => is_null(null)]
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Memory Layout and Scalars</h2>
    <p>PHP uses the Zend Engine engine to allocate memory dynamically, but we should enforce strict types in professional codebases to prevent coercion flaws.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Data Type Name</th>
            <th>Raw Script Value</th>
            <th>Strict Type Check Passed?</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataTypes as $var): ?>
        <tr>
            <td><strong><?= htmlspecialchars($var['type']) ?></strong></td>
            <td><code><?= htmlspecialchars(var_export($var['value'], true)) ?></code></td>
            <td><?= $var['check'] ? '<span style="color:green">YES</span>' : '<span style="color:red">NO</span>' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 2 Project: Web App Form Challenge";
$message = null;
$error = null;

// Form Handling Logic MUST occur before headers/html
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedAnswer = trim($_POST['answer'] ?? '');
    
    // Strict typing logic evaluation
    if (strtolower($submittedAnswer) === 'elephant') {
        $message = "Correct! The PHP mascot is indeed the elePHPant!";
    } else if (empty($submittedAnswer)) {
        $error = "You left the answer blank!";
    } else {
        $error = "'{$submittedAnswer}' is incorrect. Think gray and heavy.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Interactive Developer Quiz</h2>
    <p>Using <code>$_POST</code> separated entirely from the View template!</p>
</div>

<?php if ($message): ?>
    <div class="success-box"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-box"><strong>Failure:</strong> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label for="answer"><strong>Question:</strong> What animal is the official mascot of the PHP language?</label>
    <input type="text" id="answer" name="answer" placeholder="Type your answer here..." autocomplete="off">
    
    <button type="submit">Validate Answer</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    3 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 3: The Match Expression & Strictness";

$httpCode = 404;

// PHP 8 'match' expression is cleaner than switch, returns a value, and uses strict === comparison!
$responseMeaning = match($httpCode) {
    200, 201 => "Success: Application processing finished gracefully.",
    400 => "Client Error: Bad Request generated by invalid input.",
    403 => "Security Lockout: Access is strictly forbidden.",
    404 => "Routing Error: Missing resource.",
    500 => "Critical Infrastructure Failure.",
    default => "Unknown HTTP status."
};
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Server Response Handler</h2>
    <p>Evaluating standard server codes using the PHP 8+ strict <code>match()</code> structure.</p>
</div>

<div class="info-box">
    <strong>Simulated Traffic:</strong> Returning HTTP <code><?= htmlspecialchars((string)$httpCode) ?></code><br>
    <strong>System Diagnosis:</strong> <?= htmlspecialchars($responseMeaning) ?>
</div>

<h3>Strict vs Loose Comparison Hazards</h3>
<table>
    <tr><th>Condition</th><th>Loose (==)</th><th>Strict (===)</th></tr>
    <tr><td><code>"" == 0</code></td><td><span style="color:red">TRUE (Bad)</span></td><td><span style="color:green">FALSE (Safe)</span></td></tr>
    <tr><td><code>"123" == 123</code></td><td><span style="color:red">TRUE</span></td><td><span style="color:green">FALSE</span></td></tr>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 3 Project: Content Security Gate";
$gateStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs via robust filters
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $subscribe = isset($_POST['subscribe']); // Checkbox presence

    if ($age === false) {
        $gateStatus = ['status' => 'error', 'msg' => 'Invalid integer provided for age.'];
    } elseif ($age < 18) {
        $gateStatus = ['status' => 'error', 'msg' => 'Access Denied: You must be 18 or older to view the professional network.'];
    } elseif (!$subscribe) {
        $gateStatus = ['status' => 'info', 'msg' => 'Access Granted, but please consider subscribing to our tech newsletter!'];
    } else {
        $gateStatus = ['status' => 'success', 'msg' => 'Access Granted: Welcome, Pro Member.'];
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Infrastructure Authentication Gate</h2>
    <p>Utilizing compound conditionals and boolean logic securely.</p>
</div>

<?php if ($gateStatus): ?>
    <div class="<?= htmlspecialchars($gateStatus['status']) ?>-box">
        <?= htmlspecialchars($gateStatus['msg']) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <label><strong>Enter your Age:</strong></label>
    <input type="number" name="age" required min="1" max="120">
    
    <div style="margin-bottom: 20px;">
        <input type="checkbox" name="subscribe" id="sub" value="1">
        <label for="sub" style="font-weight:bold;">Opt-in to the Professional Technical Newsletter (Agrees to ToS)</label>
    </div>

    <button type="submit">Attempt Login</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    4 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 4: Advanced Typing and Functions";

/**
 * Calculates a discount. Enforces types strongly.
 * Using Union Types (int|float) available since PHP 8.
 */
function applyDiscount(float|int $price, float $discountRate): float {
    if ($price < 0 || $discountRate < 0) {
        throw new InvalidArgumentException("Prices and rates cannot be negative.");
    }
    return $price - ($price * $discountRate);
}

// Data Array for Views
$products = [
    ['name' => 'Enterprise Server', 'original' => 1500, 'rate' => 0.15],
    ['name' => 'Mechanical Keyboard', 'original' => 200, 'rate' => 0.05],
    ['name' => 'Algorithm E-Book', 'original' => 45, 'rate' => 0.50],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Union Types and Strict Math</h2>
    <p>Using <code>declare(strict_types=1)</code> ensures no accidental passing of `"150"` (string) instead of `150` (int) down the application stack.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Hardware / Asset</th>
            <th>Original Price</th>
            <th>Discount Applied</th>
            <th>Final Cost</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
            <td>$<?= number_format((float)$p['original'], 2) ?></td>
            <td><?= $p['rate'] * 100 ?>% OFF</td>
            <td style="color: green; font-weight: bold;">
                $<?= number_format(applyDiscount($p['original'], $p['rate']), 2) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 4 Project: Custom String Formatter Tool";

$results = null;

/**
 * A utility class-like function generator to clean user text!
 */
function sanitizeAndFormatText(string $rawInput): array {
    $clean = strip_tags(trim($rawInput)); // Security: strip HTML
    return [
        'original' => $rawInput,
        'uppercase' => strtoupper($clean),
        'word_count' => str_word_count($clean),
        'slug' => strtolower(str_replace(' ', '-', $clean))
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['rawText'] ?? '';
    if (!empty($input)) {
        $results = sanitizeAndFormatText($input);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Data Formatting Pipeline</h2>
    <p>Submit any messy string below, and see the engine parse it cleanly via separated functions.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Paste text here (Try adding HTML like &lt;b&gt;):</label>
    <textarea name="rawText" rows="4"></textarea>
    <button type="submit">Process Text</button>
</form>

<?php if ($results): ?>
    <h3>Output Pipeline:</h3>
    <table>
        <tr><th>Original Payload:</th><td><code><?= htmlspecialchars($results['original']) ?></code></td></tr>
        <tr><th>Upper Transformation:</th><td><strong><?= htmlspecialchars($results['uppercase']) ?></strong></td></tr>
        <tr><th>Total Words Parsed:</th><td><?= htmlspecialchars((string)$results['word_count']) ?></td></tr>
        <tr><th>URL Friendly Slug:</th><td><code><?= htmlspecialchars($results['slug']) ?></code></td></tr>
    </table>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    5 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 5: Scopes, References, and Statics";

$counterData = [];

// Static variables REMEMBER their state across function calls within the same script execution!
function incrementCounter(string $label): int {
    static $calls = 0; 
    $calls++;
    return $calls;
}

// Using references (&) allows modifying variables directly in memory!
$globalTitle = "App Name";
function renameApp(string &$appRef, string $newName): void {
    $appRef = strtoupper($newName); 
}

$counterData[] = "Call 1 -> Returned: " . incrementCounter("X");
$counterData[] = "Call 2 -> Returned: " . incrementCounter("X");
$counterData[] = "Call 3 -> Returned: " . incrementCounter("X");

$before = $globalTitle;
renameApp($globalTitle, "Awesome ETEC Platform");
$after = $globalTitle;

// --- END LOGIC ---
require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Memory Modification Strategies</h2>
</div>

<h3>Static Function Variables:</h3>
<p>Unlike normal local variables which reset when the function ends, <code>static</code> remembers its value.</p>
<pre>
<?php foreach ($counterData as $log): ?>
<?= htmlspecialchars($log) . "\n" ?>
<?php endforeach; ?>
</pre>

<h3>Passing by Reference:</h3>
<p>Passing a variable with <code>&amp;</code> allows the function to mutate the original property memory space.</p>
<table style="width:50%;">
    <tr><th>State Before:</th><td><code><?= htmlspecialchars($before) ?></code></td></tr>
    <tr><th>State After:</th><td><strong><?= htmlspecialchars($after) ?></strong></td></tr>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
// We simulate cross-request global state using Sessions!
session_start();

$pageTitle = "Week 5 Project: Advanced Session Scoping Matrix";

// Setup state
if (!isset($_SESSION['player_score'])) {
    $_SESSION['player_score'] = 0;
}

$action = $_POST['action'] ?? '';

if ($action === 'score') {
    $_SESSION['player_score'] += 10;
} elseif ($action === 'reset') {
    $_SESSION['player_score'] = 0;
}

$currentScore = $_SESSION['player_score'];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Persistent Scoping Server</h2>
    <p>PHP scripts die when the page loads. To keep data alive globally across requests, we hook into <code>$_SESSION</code>.</p>
</div>

<div class="info-box" style="text-align: center;">
    <h3>CURRENT APPLICATION STATE:</h3>
    <h1 style="font-size: 4em; margin:10px 0; color:var(--text-color);"><?= htmlspecialchars((string)$currentScore) ?></h1>
    <p>Your session ID: <code><?= htmlspecialchars(session_id()) ?></code></p>
</div>

<div style="display:flex; gap:10px; justify-content:center;">
    <form method="POST">
        <input type="hidden" name="action" value="score">
        <button type="submit" style="background:#155724; border-color:#155724;">+10 Score Points</button>
    </form>
    
    <form method="POST">
        <input type="hidden" name="action" value="reset">
        <button type="submit" style="background:#721c24; border-color:#721c24;">Hard Reset Core</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    6 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 6: Complex Arrays & Deconstruction";

$frameworks = ['Laravel', 'Symfony', 'CodeIgniter'];
$authConfig = [
    'driver' => 'JWT',
    'lifetime' => 7200,
    'secure' => true,
    'routes' => ['/api/user', '/api/admin']
];

// PHP 7.1+ Array Destructuring! Very clean syntax.
[$fw1, $fw2] = $frameworks;

// Associative Destructuring
['driver' => $drv, 'lifetime' => $lt] = $authConfig;

// PHP 7.4+ Spread Operator (...)
$newFrameworks = ['Phalcon', ...$frameworks, 'Slim'];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Modern Array Architecture</h2>
    <p>Arrays are foundational in PHP. Let's look at advanced destructuring.</p>
</div>

<h3>List Assignment Destructuring:</h3>
<div class="success-box">
    Grabbed directly off the array memory layout:<br>
    <strong>Primary:</strong> <?= htmlspecialchars($fw1) ?> <br>
    <strong>Secondary:</strong> <?= htmlspecialchars($fw2) ?> 
</div>

<h3>Extracted Map Variables:</h3>
<p>Variables <code>$drv</code> and <code>$lt</code> created instantly from the hash map keys:</p>
<ul>
    <li>Driver Engine: <strong><?= htmlspecialchars($drv) ?></strong></li>
    <li>Session Lifetime: <strong><?= htmlspecialchars((string)$lt) ?>s</strong></li>
</ul>

<h3>Array Spread Merging (...):</h3>
<pre><?= htmlspecialchars(print_r($newFrameworks, true)) ?></pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 6 Project: Task List Application";

// Simple state
$tasks = [
    'Critical Error Patch',
    'Write Authentication API',
    'Design Login Modal Forms'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['new_task'])) {
    // Sanitize and append
    $safeTask = strip_tags(trim($_POST['new_task']));
    // Prepend to top of array
    array_unshift($tasks, $safeTask);
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Volatile Task Queue</h2>
    <p>Using arrays to track state (Resets on refresh since we aren't using Session or DB yet).</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>New System Feature Request:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="new_task" style="margin-bottom:0;" autocomplete="off" required>
        <button type="submit" style="white-space:nowrap;">Queue Task</button>
    </div>
</form>

<h3>Pending System Queue:</h3>
<ul>
    <?php foreach ($tasks as $index => $item): ?>
    <li style="padding:10px; border-bottom:1px dashed var(--border-color);">
        <code>[ID:<?= $index ?>]</code> <strong><?= htmlspecialchars($item) ?></strong>
    </li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    7 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 7: Multidimensional Data Architecture";

// Simulating a parsed JSON API response
$databaseRaw = [
    'schema_version' => '1.5',
    'users' => [
        ['id' => 10, 'role' => 'dev', 'tags' => ['c#', 'php']],
        ['id' => 11, 'role' => 'admin', 'tags' => ['hr_manager', 'payroll']]
    ]
];

// Rebuilding data structurally via iteration
$hrPersonnel = [];
foreach ($databaseRaw['users'] as $user) {
    if (in_array('hr_manager', $user['tags'])) {
        $hrPersonnel[] = $user;
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Deep Matrix Navigation</h2>
    <p>How do we parse deeper level arrays representing Database Joins or JSON bodies?</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1; min-width:300px;">
        <h3>Incoming Payload:</h3>
        <pre><?= htmlspecialchars(print_r($databaseRaw, true)) ?></pre>
    </div>
    
    <div style="flex:1; min-width:300px;">
        <h3>Filtered Results (HR Tag):</h3>
        <?php if (empty($hrPersonnel)): ?>
            <p>No HR personnel found.</p>
        <?php else: ?>
            <ul>
            <?php foreach ($hrPersonnel as $hr): ?>
                <li>
                    <strong>Found ID:</strong> <?= $hr['id'] ?> <br>
                    <strong>Clearance:</strong> <?= strtoupper($hr['role']) ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 7 Project: Analytics Dashboard Engine";

// Huge dataset representing daily visitors across platforms
$analytics = [
    '2026-10-01' => ['web' => 450, 'ios' => 200, 'android' => 310],
    '2026-10-02' => ['web' => 520, 'ios' => 215, 'android' => 305],
    '2026-10-03' => ['web' => 490, 'ios' => 250, 'android' => 340],
];

// Logic engine to boil it down into actionable insights
$totals = ['web' => 0, 'ios' => 0, 'android' => 0, 'global' => 0];

foreach ($analytics as $date => $metrics) {
    $totals['web'] += $metrics['web'];
    $totals['ios'] += $metrics['ios'];
    $totals['android'] += $metrics['android'];
    
    // Total aggregate for the day
    $totals['global'] += ($metrics['web'] + $metrics['ios'] + $metrics['android']);
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Aggregated Traffic Intelligence</h2>
    <p>Using multi-dimensional mapping to summarize terabytes of log data.</p>
</div>

<table>
    <thead>
        <tr><th>Timestamp</th><th>Web Route</th><th>iOS Route</th><th>Android Route</th><th>Day Total</th></tr>
    </thead>
    <tbody>
        <?php foreach ($analytics as $date => $metrics): ?>
            <?php $dayTotal = array_sum($metrics); ?>
            <tr>
                <td><strong><?= htmlspecialchars($date) ?></strong></td>
                <td><?= $metrics['web'] ?></td>
                <td><?= $metrics['ios'] ?></td>
                <td><?= $metrics['android'] ?></td>
                <td style="font-weight:bold;"><?= $dayTotal ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr style="background:var(--hover-bg);">
            <td><strong>TOTAL SUMMARY</strong></td>
            <td><strong><?= $totals['web'] ?></strong></td>
            <td><strong><?= $totals['ios'] ?></strong></td>
            <td><strong><?= $totals['android'] ?></strong></td>
            <td style="color:var(--text-color); font-size:1.2em;"><strong><?= $totals['global'] ?></strong></td>
        </tr>
    </tfoot>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    8 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 8: Advanced Iterator Loops";

// In real applications, massive DB queries shouldn't be loaded into memory.
// Generators use the `yield` keyword to spit out items efficiently!
function generateCpuSpike(int $limit): Generator {
    for ($i = 1; $i <= $limit; $i++) {
        // Yield pauses exactly here and gives memory to the frontend
        yield $i => rand(1000, 9999);
    }
}

$startMemory = memory_get_usage();
$generator = generateCpuSpike(100);
// At this exact line, PHP hasn't used any memory to hold the 100 random numbers!
$endMemory = memory_get_usage();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Loop Memory Management (The Yield Iterator)</h2>
    <p>If you build an API pulling 5 million records into an array, the server crashes. We loop iterators using <code>yield</code> instead.</p>
</div>

<div class="info-box">
    <strong>Memory Setup Cost:</strong> <?= $endMemory - $startMemory ?> bytes.<br>
    <em>Because the loop hasn't run yet, RAM usage is almost zero!</em>
</div>

<div style="height:200px; overflow-y:scroll; border:1px solid var(--border-color); padding:10px; background:#fff;">
    <?php foreach ($generator as $index => $randomNumber): ?>
        <code>[ID:<?= str_pad((string)$index, 3, '0', STR_PAD_LEFT) ?>] Hash: <?= $randomNumber ?></code><br>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 8 Project: HTML Table Visualizer Tool";

$gridSize = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gridSize = filter_input(INPUT_POST, 'grid', FILTER_VALIDATE_INT) ?: 0;
    // Hard limit to avoid user crashing the PHP script
    $gridSize = min($gridSize, 20); 
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Dynamic Multi-Iteration Matrix Render</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Generate a matrix grid safely up to 20x20:</label>
    <div style="display:flex; gap:10px;">
        <input type="number" name="grid" min="1" max="20" required value="<?= $gridSize ?: 5 ?>">
        <button type="submit" style="white-space:nowrap;">Build Grid Layout</button>
    </div>
</form>

<?php if ($gridSize > 0): ?>
    <h3>Live Render:</h3>
    <table style="text-align:center;">
        <?php for ($row = 1; $row <= $gridSize; $row++): ?>
            <tr>
                <?php for ($col = 1; $col <= $gridSize; $col++): ?>
                    <?php 
                        // Highlighting the diagonal line
                        $isDiagonal = ($row === $col);
                        $bg = $isDiagonal ? 'var(--text-color)' : 'transparent';
                        $color = $isDiagonal ? 'var(--bg-color)' : 'var(--text-color)';
                    ?>
                    <td style="background:<?= $bg ?>; color:<?= $color ?>; border:1px solid var(--border-color); padding:5px;">
                        <?= $row ?>x<?= $col ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    9 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 9: Control Flow (Break & Continue)";

// Network timeout simulation list
$networkRequests = [
    ['ip' => '192.168.1.1', 'status' => 'success', 'time' => 12],
    ['ip' => '192.168.1.2', 'status' => 'timeout', 'time' => 5000],
    ['ip' => '192.168.1.3', 'status' => 'success', 'time' => 15],
    ['ip' => '10.0.0.99', 'status' => 'FATAL_KERNEL_PANIC', 'time' => 0],
    ['ip' => '192.168.1.5', 'status' => 'success', 'time' => 10], // Won't be reached
];

$logs = [];
foreach ($networkRequests as $req) {
    if ($req['status'] === 'timeout') {
        $logs[] = "[WARNING] Skipping Server {$req['ip']} - Timeout.";
        continue; // Skip the rest of this singular loop block, move to next!
    }
    
    if ($req['status'] === 'FATAL_KERNEL_PANIC') {
        $logs[] = "[CRITICAL] Entire deployment aborted due to Kernel Panic on {$req['ip']}.";
        break; // Destroys the entire foreach loop instantly!
    }
    
    $logs[] = "[OK] Pinging {$req['ip']} finished in {$req['time']}ms.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Command Structure Breaks</h2>
    <p>Controlling large data loops gracefully.</p>
</div>

<h3>Deployment Engine Output Log:</h3>
<ul style="list-style-type:none; padding:0;">
    <?php foreach ($logs as $logStr): ?>
        <?php
            $color = 'var(--text-color)';
            if (str_contains($logStr, '[WARNING]')) $color = 'orange';
            if (str_contains($logStr, '[CRITICAL]')) $color = 'red';
        ?>
        <li style="color:<?= $color ?>; font-weight:bold; margin-bottom:10px;">
            <?= htmlspecialchars($logStr) ?>
        </li>
    <?php endforeach; ?>
</ul>

<div class="error-box">Notice how <code>192.168.1.5</code> was never pinged because we broke the loop early.</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 9 Project: Security Search Protocol";

$userDatabase = [
    'alice@example.com', 'admin@example.com', 'bob@example.com', 
    'charlie@example.com', 'malory@example.com'
];

$searchTerm = $_POST['email'] ?? '';
$searchResult = null;
$searchedPaths = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    foreach ($userDatabase as $index => $email) {
        $searchedPaths++; // Keep track of how many rows we looked at
        
        if ($email === $searchTerm) {
            $searchResult = "FOUND User ID #$index for $email";
            break; // IMMEDIATE OPTIMIZATION. Don't check the rest of the array!
        }
    }
    if (!$searchResult) $searchResult = "FAILED: User $searchTerm not found.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Optimized Array Searching</h2>
    <p>Using <code>break</code> to prevent unnecessary CPU cycles in search protocols.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Find specific User Email (Bob, Alice, Admin...):</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="email" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Run Database Check</button>
    </div>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <?php if (str_starts_with($searchResult, 'FOUND')): ?>
        <div class="success-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php else: ?>
        <div class="error-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php endif; ?>
    
    <div class="info-box">
        <strong>Engine Metrics:</strong> Searched exactly <strong><?= $searchedPaths ?></strong> rows before stopping algorithm execution.<br>
        <em>If we didn't use break, it would have scanned all 5 rows every time!</em>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    10 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 10: Higher-Order Array Functions";

// Raw API Data
$prices = [10.50, 42.00, 5.25, 100.00];

// 1. array_map (Modifying every element) -> Applying $5 Shipping to all
$withShipping = array_map(fn($price) => $price + 5.00, $prices);

// 2. array_filter (Removing elements) -> Keeping only items above $20
$expensiveItems = array_filter($prices, fn($price) => $price > 20.00);

// 3. array_reduce (Boiling down to one value) -> Summing the cart total
$cartTotal = array_reduce($prices, fn($carry, $price) => $carry + $price, 0.0);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Functional Programming Mechanics</h2>
    <p>PHP has incredibly powerful higher-order functions that eliminate the need for writing raw <code>foreach</code> loops manually.</p>
</div>

<table>
    <tr><th>Raw Prices ($)</th><th>Map (+5 Shipping)</th><th>Filter (Only > $20)</th></tr>
    <tr>
        <td><pre><?= htmlspecialchars(print_r($prices, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($withShipping, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($expensiveItems, true)) ?></pre></td>
    </tr>
</table>

<div class="success-box" style="text-align: center;">
    <h3>Final Cart Reduce Total:</h3>
    <h1>$<?= number_format($cartTotal, 2) ?></h1>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 10 Project: Complex Database Filters";

// Simulated complex SQL Joins into an architecture array
$tasks = [
    ['id' => 1, 'priority' => 'high', 'completed' => true, 'tag' => 'auth'],
    ['id' => 2, 'priority' => 'low', 'completed' => false, 'tag' => 'ui'],
    ['id' => 3, 'priority' => 'high', 'completed' => false, 'tag' => 'database'],
    ['id' => 4, 'priority' => 'medium', 'completed' => false, 'tag' => 'auth'],
];

// Chain them: Find all INCOMPLETE tasks, then grab ONLY their TAG names as a clean list!
$pendingTasks = array_filter($tasks, fn($t) => !$t['completed']);
$pendingTags  = array_map(fn($t) => strtoupper($t['tag']), $pendingTasks);

// Make the tags unique using another built in
$uniquePendingTags = array_unique($pendingTags);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Data Pipeline Architecture</h2>
    <p>In highly advanced architectures, we chain filter/map actions to isolate exact data slices from complex structures.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    
    <div class="content-box" style="flex:1;">
        <h3>Original Data Struct:</h3>
        <pre><?= htmlspecialchars(var_export($tasks, true)) ?></pre>
    </div>
    
    <div class="info-box" style="flex:1;">
        <h3>Actionable Pipeline Output:</h3>
        <p>The system needs to know which departments owe work. We filtered completed tasks out, grouped their keys, and removed duplicates instantly natively:</p>
        
        <ul style="margin-top:20px;">
            <?php foreach ($uniquePendingTags as $deptCode): ?>
                <li style="font-weight:bold; color:red; margin-bottom:10px;">
                    WORK PENDING IN MODULE: [<?= htmlspecialchars($deptCode) ?>]
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
</div>

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
echo "Professional Layouts generated & applied to Weeks 1-10.\n";
