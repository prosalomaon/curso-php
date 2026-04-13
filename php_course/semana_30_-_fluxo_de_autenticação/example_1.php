<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 30: Middleware de Autenticação e Guards de Sessão";

session_start();

function auth_middleware() {
    if (empty($_SESSION['authenticated'])) {
        // Simulação de Desvio de Fluxo (Redirect)
        return false;
    }
    return true;
}

$isProtectedAreaAccessible = auth_middleware();
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>O Padrão Interceptor (Middleware)</h2>
    <p>Middleware atua como um bouncer em um clube. Ele verifica seus cookies/sessão ANTES de permitir que o Controlador principal comece a processar lógica sensível.</p>
</div>

<?php if (!$isProtectedAreaAccessible): ?>
    <div class="error-box" style="text-align:center; padding:20px;">
        <h3 style="margin-top:0;">ACESSO NEGADO: Middleware de Bloco 401</h3>
        <p>Você não possui o token de sessão necessário para visualizar esta zona protegida.</p>
        <a href="?login_sim=1"><button>Simular Login de Middleware</button></a>
    </div>
    <?php if (isset($_GET['login_sim'])) { $_SESSION['authenticated'] = true; header("Location: ?"); exit; } ?>
<?php else: ?>
    <div class="success-box">
        <h3>CONTROLE DE ACESSO CONCEDIDO</h3>
        <p>O middleware verificou sua sessão e permitiu que o controlador renderizasse este conteúdo privado.</p>
        <a href="?logout_sim=1"><button style="background:red;">Simular Logout de Middleware</button></a>
    </div>
    <?php if (isset($_GET['logout_sim'])) { session_destroy(); header("Location: ?"); exit; } ?>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/function.password-verify.php" target="_blank">Manual PHP: Autenticação</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
if (password_verify($tentativaSenha, $hashUsuario)) {
    $_SESSION[&#039;auth&#039;] = true;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>