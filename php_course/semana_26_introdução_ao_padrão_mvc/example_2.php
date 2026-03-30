<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 26: Extrator de API JSON";

class ArtigoApiController {
    // 1. Um método global que força a arquitetura de cabeçalho JSON
    protected function generateJson(array $payload, int $status = 200): void {
        // http_response_code($status);
        // header('Content-Type: application/json');
        echo json_encode(['status_code' => $status, 'data' => $payload], JSON_PRETTY_PRINT);
    }

    public function retrieve(int $id) {
        $mockModelData = ['id' => $id, 'titulo' => 'Mudança de Paradigma MVC', 'tipo' => 'Tutorial'];
        $this->generateJson($mockModelData, 200);
    }
}

$controllerObject = new ArtigoApiController();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Construindo Controladores Base</h2>
</div>

<h3>Execução de Recuperação de Endpoint de API:</h3>
<pre class="content-box" style="background:#000; color:#0f0;">
<?php $controllerObject->retrieve(505); ?>
</pre>

<div class="info-box">
    A lógica da aplicação herda de forma limpa. Um <code>BaseController</code> pode conter métodos universais como <code>redirect()</code>, <code>validate()</code> ou <code>generateJson()</code>!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.architecture.php" target="_blank">Manual PHP: Padrão MVC</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
// Router invoca o Controller, passa dados do Model para a View
$controller = new UserController(new UserModel());
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>