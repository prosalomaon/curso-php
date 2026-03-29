<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 36: Consuming External APIs";

// We will use stream_context as an alternative to cURL for basic fetches!
$resultData = null;
$errorLog = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = "https://jsonplaceholder.typicode.com/posts/1"; // Public fake API
    
    // Setting up the HTTP config natively in PHP without cURL
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: EtecProfessionalPHP/1.0\r\n" .
                        "Accept: application/json\r\n",
            'timeout' => 5
        ]
    ];
    
    $context = stream_context_create($options);
    
    // The @ suppresses warnings so we can catch them cleanly for the UI
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        $errorLog = "Network Outage: Unable to connect cleanly to Typicode API.";
    } else {
        // We decode safely to an Associative Array (true argument)
        $resultData = json_decode($response, true);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Stream Context fetching (Server-side fetch)</h2>
    <p>PHP can act as the "Browser", connecting to other services (Stripe, Twilio) from the backend privately.</p>
</div>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;">Fetch External HTTPS Endpoint natively</button>
</form>

<?php if ($errorLog): ?>
    <div class="error-box"><?= htmlspecialchars($errorLog) ?></div>
<?php endif; ?>

<?php if ($resultData): ?>
    <div class="success-box">
        <h3>Payload Decoded:</h3>
        <table>
            <tr><th>Identifier</th><td><?= $resultData['id'] ?></td></tr>
            <tr><th>Resource Title</th><td><?= htmlspecialchars($resultData['title']) ?></td></tr>
            <tr><th>Content Body</th><td><?= htmlspecialchars($resultData['body']) ?></td></tr>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>