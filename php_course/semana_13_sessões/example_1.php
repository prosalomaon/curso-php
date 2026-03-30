<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 13: Segurança de Sessão e Gerenciamento de Estado";

// 1. Mandatory Security Directives BEFORE opening the session engine!
session_set_cookie_params([
    'lifetime' => 3600, // TimeToLive (Seconds)
    'path' => '/',
    'domain' => '', 
    'secure' => false,  // True in production! Prevents interception over HTTP.
    'httponly' => true, // Prevents XSS Javascript from reading the session.
    'samesite' => 'Lax'
]);

session_start();
$actionLog = [];

if (isset($_GET['login']) && empty($_SESSION['user_id'])) {
    // Session Fixation Prevention
    session_regenerate_id(true); 
    $_SESSION['user_id'] = mt_rand(1000, 9999);
    $_SESSION['role'] = 'SUPER_ADMIN';
    $actionLog[] = "Autenticação Autorizada. Identidade da Sessão completamente regenerada.";
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/'); // Nuke the client-side reference
    $actionLog[] = "Sessão purgada. Cookie do cliente destruído. Re-execução necessária.";
}

$stateActive = !empty($_SESSION['user_id']);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Ciclo de Vida de Sessão Seguro</h2>
    <p>O PHP lida com a mecânica da sessão automaticamente, mas requer ajuste fino rigoroso para evitar explorações de Sequestro (Hijacking) e Fixação.</p>
</div>

<?php foreach ($actionLog as $log): ?>
    <div class="success-box"><?= htmlspecialchars($log) ?></div>
<?php endforeach; ?>

<div class="info-box">
    <strong>Ponteiro Interno (ID da Sessão):</strong> <code><?= htmlspecialchars(session_id() ?: 'NENHUM') ?></code><br>
    <?php if ($stateActive): ?>
        <strong>ID do Usuário:</strong> <?= $_SESSION['user_id'] ?> |
        <strong>Função Global:</strong> <?= $_SESSION['role'] ?>
    <?php else: ?>
        <strong>Estado de Auth:</strong> CONVIDADO NÃO IDENTIFICADO
    <?php endif; ?>
</div>

<div style="display:flex; gap:10px;">
    <?php if (!$stateActive): ?>
        <a href="?login=1"><button>Simular Login Seguro</button></a>
    <?php else: ?>
        <a href="?logout=1"><button style="background:red;">Purgar Sessão (Logout)</button></a>
    <?php endif; ?>
</div>


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