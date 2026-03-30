<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 21: Bootstrap de Banco de Dados de Blog";

$tables = [
    'categorias' => "
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
)",
    'artigos' => "
CREATE TABLE artigos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NULL,
    titulo VARCHAR(200) NOT NULL,
    corpo TEXT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
)"
];

$simulatedLogs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($tables as $name => $query) {
        $simulatedLogs[] = "Nó de destino migrado: [{$name}]";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mecanismo de Bootstrap de Esquema CMS</h2>
</div>

<?php if ($simulatedLogs): ?>
    <div class="content-box" style="background:#000; color:#0f0;">
        <?php foreach ($simulatedLogs as $log): ?>
            <div>>> <?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
        <div style="margin-top:10px; color:yellow;">Sistema configurado para inserção PDO com sucesso.</div>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;" <?= $simulatedLogs ? 'disabled' : '' ?>>Executar Migrações do Sistema</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.pdo.php" target="_blank">Manual PHP: Básico de SQL</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL
);</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>