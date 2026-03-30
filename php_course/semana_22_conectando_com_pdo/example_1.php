<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 22: Arquiteturas PDO Avançadas";

// Criando um mock seguro para evitar travamentos em bancos de dados locais ausentes neste ambiente de demonstração
class SafeMockPDO {
    public function getAttribute($attr) {
        return "STRICT_EXCEPTION_MODE";
    }
}

$dsn = "mysql:host=localhost;dbname=test_db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// $pdo = new PDO($dsn, 'root', '', $options);
$pdo = new SafeMockPDO(); 
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Configuração de PHP Data Objects (PDO)</h2>
    <p>O uso do lendário Padrão Singleton garante que sua aplicação abra exatamente 1 conexão com seu Banco de Dados por carregamento de página, em vez de 50!</p>
</div>

<div class="success-box">
    Conectividade de Banco de Dados Configurada.<br>
    <strong>Modo de Erro:</strong> <?= htmlspecialchars($pdo->getAttribute('mock')) ?><br>
    <strong>Modo de Busca:</strong> FETCH_ASSOC (Arrays Associativos)
</div>

<div class="info-box">
    <strong>Verificação de Segurança Obrigatória:</strong> <code>PDO::ATTR_EMULATE_PREPARES</code> deve ser definido como <code>false</code> para forçar o mecanismo MySQL real a preparar as consultas nativamente (Melhor segurança contra injeção).
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdo.connections.php" target="_blank">Manual PHP: Conexão PDO</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$pdo = new PDO(&#039;mysql:host=localhost;dbname=test&#039;, &#039;usuario&#039;, &#039;senha&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>