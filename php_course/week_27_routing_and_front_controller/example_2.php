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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>