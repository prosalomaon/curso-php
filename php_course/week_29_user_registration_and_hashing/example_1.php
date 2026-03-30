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

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/function.password-hash.php" target="_blank">PHP Manual: Password Hashing</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$hash = password_hash(&#039;super_secret_123&#039;, PASSWORD_ARGON2ID);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>