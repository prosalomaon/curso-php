<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 14: O Token 'Lembrar de Mim' do Cofre";

session_start();

$validDatabaseToken = "7a4f9x1wB_secure_hash_string";
$msg = null;

// The Auto-Login Engine!
if (empty($_SESSION['vault_access']) && isset($_COOKIE['remember_me'])) {
    
    // DB Check simulation: SELECT user_id FROM tokens WHERE token = ?
    if ($_COOKIE['remember_me'] === $validDatabaseToken) {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = 'phantom_admin';
        $msg = "[AUTHD] Sessão totalmente reconstruída via carga criptográfica de cookie.";
    } else {
        // Punish invalid tokens by invalidating them
        setcookie('remember_me', '', time() - 3600, '/');
    }
}

// Routes
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'home';

if ($page === 'set_cookie') {
    // Simulating checking the 'Remember Me' box
    setcookie('remember_me', $validDatabaseToken, time() + 3600, '/', '', false, true); // true = HttpOnly
    header("Location: ?page=home&status=cookie_set");
    exit;
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    setcookie('remember_me', '', time() - 3600, '/'); // Nuke the remember token too!
    header("Location: ?page=home");
    exit;
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Autenticação Persistente do Cofre</h2>
</div>

<?php if ($msg): ?>
    <div class="success-box"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if (($_GET['status'] ?? '') === 'cookie_set'): ?>
    <div class="info-box">Cookie de longo prazo implantado. Feche este navegador e reabra-o, e o sistema ignorará o login automaticamente.</div>
<?php endif; ?>

<?php if (!empty($_SESSION['vault_access'])): ?>
    <div class="content-box" style="text-align:center;">
        <h3>Bem-vindo ao Cofre, <?= htmlspecialchars($_SESSION['user']) ?></h3>
        <p>Você está totalmente autenticado.</p>
        <a href="?page=logout"><button style="background:red;">Sair completamente (Apaga Cookies)</button></a>
    </div>
<?php else: ?>
    <div class="error-box" style="text-align:center;">
        <h3>Verificação de Autorização Falhou</h3>
        <p>Você não tem sessão ativa e nenhuma carga de Cookie.</p>
        <a href="?page=set_cookie"><button>Simular Login 'Lembrar de Mim'</button></a>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.cookies.php" target="_blank">Manual PHP: Cookies</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
setcookie(&#039;theme&#039;, &#039;dark&#039;, time() + 3600, &#039;/&#039;, &#039;&#039;, true, true);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>