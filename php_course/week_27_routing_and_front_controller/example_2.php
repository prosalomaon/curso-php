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


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/reserved.variables.server.php" target="_blank">PHP Manual: Routing</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$uri = parse_url($_SERVER[&#039;REQUEST_URI&#039;], PHP_URL_PATH);
if ($uri === &#039;/about&#039;) { require &#039;about.php&#039;; }
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>