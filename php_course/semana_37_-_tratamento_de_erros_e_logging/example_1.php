<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 37: Variáveis de Ambiente (.env)";

$envMock = <<<ENV
APP_NAME="Etec Pro Framework"
APP_ENV=production
APP_DEBUG=false

DB_HOST=127.0.0.1
DB_PORT=3306
DB_USER=root
DB_PASS=C0mpl3xP@ss!
ENV;

// Simulando a função nativa getenv do PHP (na qual o $_ENV se baseia)
$mockEnvVars = [
    'APP_ENV' => 'production',
    'DB_HOST' => '127.0.0.1'
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Configuração de Ambiente de App 12-Factor</h2>
    <p>Senhas nunca devem ser digitadas nos arquivos da base de código PHP. Nós as lemos implicitamente do Sistema Operacional Hospedeiro usando arquivos `.env`.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Conteúdo do Arquivo <code>.env</code></h3>
        <pre><?= htmlspecialchars($envMock) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Lógica de Extração</h3>
        <pre>
$env = $_ENV['APP_ENV'] ?? 'local';
$host = getenv('DB_HOST');

if ($env === 'production') {
    // Ocultar impressão de erros nativa!
    ini_set('display_errors', '0');
}
        </pre>
    </div>
</div>

<div class="error-box">
    <strong>CRÍTICO:</strong> Arquivos <code>.env</code> devem obrigatoriamente ser listados no <code>.gitignore</code>! Nunca envie estruturas de banco de dados para o GitHub!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.errorfunc.php" target="_blank">Manual PHP: Tratamento de Erros</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
try {
    // lógica arriscada
} catch (Exception $e) {
    error_log($e-&gt;getMessage());
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>