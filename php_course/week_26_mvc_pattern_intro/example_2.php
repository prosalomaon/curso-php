<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 26 Project: JSON API Extractor";

class ArticleApiController {
    // 1. A global method that forces JSON header architecture
    protected function generateJson(array $payload, int $status = 200): void {
        // http_response_code($status);
        // header('Content-Type: application/json');
        echo json_encode(['status_code' => $status, 'data' => $payload], JSON_PRETTY_PRINT);
    }

    public function retrieve(int $id) {
        $mockModelData = ['id' => $id, 'title' => 'MVC Paradigm Shift', 'type' => 'Tutorial'];
        $this->generateJson($mockModelData, 200);
    }
}

$controllerObject = new ArticleApiController();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Constructing Base Controllers</h2>
</div>

<h3>API Endpoint Retrieval Execution:</h3>
<pre class="content-box" style="background:#000; color:#0f0;">
<?php $controllerObject->retrieve(505); ?>
</pre>

<div class="info-box">
    The application logic inherits cleanly. A <code>BaseController</code> can contain universal methods like <code>redirect()</code>, <code>validate()</code>, or <code>generateJson()</code>!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.architecture.php" target="_blank">PHP Manual: MVC Pattern</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
// Router invokes Controller, passes Model data to View
$controller = new UserController(new UserModel());
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>