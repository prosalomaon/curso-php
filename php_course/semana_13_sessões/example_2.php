<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 13: Roteador de Cofre de Arquivos Seguro";

session_start();
$authError = null;
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'login';

// Form Logic Check
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Hardcoded dev credentials
    if ($user === 'admin' && $pass === 'secret') {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = $user;
        
        // Post-Redirect-Get implementation
        header("Location: ?page=vault_dashboard");
        exit;
    } else {
        $authError = "Falha Crítica de Autenticação: As credenciais não correspondem ao banco de dados.";
    }
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
    exit;
}

// Router Gate
$isVaultViewing = ($page === 'vault_dashboard');
if ($isVaultViewing && empty($_SESSION['vault_access'])) {
    // 403 Forbidden Simulation
    http_response_code(403);
    $page = '403';
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->

<?php if ($page === 'login'): ?>
    <div class="content-box">
        <h2>Autenticação do Cofre de Arquivos</h2>
    </div>

    <?php if ($authError): ?>
        <div class="error-box"><?= htmlspecialchars($authError) ?></div>
    <?php endif; ?>

    <form method="POST" class="content-box" style="margin: 0 auto; max-width:400px; background:var(--hover-bg);">
        <label>Identificação do Operador:</label>
        <input type="text" name="username" required>
        
        <label>Frase de Passagem:</label>
        <input type="password" name="password" required>
        
        <button type="submit" style="width:100%;">Autorizar Acesso</button>
        <small style="display:block; text-align:center; margin-top:15px;">Alvo: admin / secret</small>
    </form>

<?php elseif ($page === 'vault_dashboard'): ?>
    <div class="success-box" style="text-align:center;">
        <h2 style="margin:0;">ACESSO AO COFRE CONCEDIDO</h2>
        <p style="text-transform:uppercase;">OPERADOR: <?= htmlspecialchars($_SESSION['user']) ?></p>
    </div>
    
    <table style="width:100%; font-family:monospace;">
        <tr><th>Nome do Arquivo</th><th>Nível de Segurança</th><th>Ações</th></tr>
        <tr><td>infraestrutura_core.pdf</td><td>NÍVEL_OMEGA</td><td>[CRIPTOGRAFADO]</td></tr>
        <tr><td>hashes_clientes.csv</td><td>NÍVEL_ALPHA</td><td>[CRIPTOGRAFADO]</td></tr>
    </table>
    
    <div style="text-align:center;">
        <a href="?page=logout"><button style="background:red;">Encerrar Sessão</button></a>
    </div>

<?php elseif ($page === '403'): ?>
    <div class="error-box" style="text-align:center; padding:50px;">
        <h1 style="font-size:3em; margin:0;">HTTP 403</h1>
        <p>PROIBIDO: Você deve realizar a autenticação para visualizar este setor.</p>
        <a href="?page=login" style="color:var(--text-color); font-weight:bold;">[ RETORNAR AO PORTÃO DE AUTORIZAÇÃO ]</a>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.sessions.php" target="_blank">Manual PHP: Sessões</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
session_start();
$_SESSION[&#039;user_id&#039;] = 404;
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>