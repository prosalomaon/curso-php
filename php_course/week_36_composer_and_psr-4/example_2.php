<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 36 Project: Advanced Extranet cURL Payload";

$curlCode = <<<PHP
\$ch = curl_init("https://api.stripe.com/v1/charges");

// Configure massive cURL payload
curl_setopt_array(\$ch, [
    CURLOPT_RETURNTRANSFER => true, // Return data instead of printing!
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['amount' => 2000, 'currency' => 'usd']),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer sk_test_secretKey123", /* JWT or Bearer Auth */
        "Accept: application/json"
    ],
    CURLOPT_TIMEOUT => 10,
]);

\$apiResult = curl_exec(\$ch);

if(curl_errno(\$ch)) {
    throw new Exception("cURL Critical Error: " . curl_error(\$ch));
}

\$httpCode = curl_getinfo(\$ch, CURLINFO_HTTP_CODE);
curl_close(\$ch);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Client URL (cURL) Infrastructure Engine</h2>
    <p>For complex API communication (OAuth, JWT Bearer tokens, multipart forms), cURL provides absolute low-level structural control.</p>
</div>

<h3>Mock Configuration Mapping:</h3>
<pre><?= htmlspecialchars($curlCode) ?></pre>

<div class="info-box">
    In modern PHP 8+, Developers often install <strong>GuzzleHTTP</strong> via Composer, which totally wraps the nasty <code>curl_setopt</code> logic into beautiful Object-Oriented methods (<code>$client->post('/charges', ['json' => $data]);</code>).
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.namespaces.rationale.php" target="_blank">PHP Manual: Composer &amp; PSR-4</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
require &#039;vendor/autoload.php&#039;;
use App\Models\User;
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>