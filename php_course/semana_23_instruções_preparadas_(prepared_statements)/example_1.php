<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 23: Bindings e Defesa contra Injeção SQL";

$userId = $_GET['id'] ?? '1 OR 1=1; DROP TABLE usuarios;';

$safeExample = <<<PHP
\$stmt = \$pdo->prepare("UPDATE usuarios SET status = :status WHERE id = :usuario_id");

// O execute vincula os valores perfeitamente, fechando a brecha de injeção explicitamente.
\$stmt->execute([
    'usuario_id' => \$userId,
    'status'  => 'ativo'
]);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Prepared Statements (O Escudo Supremo)</h2>
    <p>Injeção SQL é a vulnerabilidade nº 1 na web. Nós a eliminamos permanentemente separando a estrutura lógica do SQL das variáveis de dados do usuário usando <code>prepare()</code>.</p>
</div>

<div class="error-box">
    <strong>Carga Útil Maliciosa Detectada em $_GET:</strong><br>
    <code><?= htmlspecialchars($userId) ?></code>
</div>

<div class="success-box">
    Usando <strong>Bindings Nomeados</strong> (<code>:variable</code>), a string maliciosa acima é tratada puramente como uma string literal pelo mecanismo do banco de dados, não causando danos.
</div>

<h3>Código de Implantação:</h3>
<pre><?= htmlspecialchars($safeExample) ?></pre>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdo.prepared-statements.php" target="_blank">Manual PHP: Instruções Preparadas</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$stmt = $pdo-&gt;prepare(&#039;SELECT * FROM users WHERE id = ?&#039;);
$stmt-&gt;execute([$id]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>