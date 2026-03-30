<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 30: Listas de Controle de Acesso (ACL)";

class Guard {
    const ROLES = [
        'CONVIDADO' => 0,
        'EDITOR'  => 10,
        'ADMIN'   => 99
    ];

    public static function canAccess(string $userRole, int $requiredLevel): bool {
        $userLevel = self::ROLES[$userRole] ?? 0;
        return $userLevel >= $requiredLevel;
    }
}

$currentUserRole = $_GET['role'] ?? 'CONVIDADO';
$requiredAccess = 10; // Nível Editor ou Admin necessário

$accessAllowed = Guard::canAccess($currentUserRole, $requiredAccess);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Autorização Baseada em Funções (RBAC)</h2>
</div>

<div class="info-box">
    <strong>Permissão Necessária:</strong> Nível 10 (EDITOR)<br>
    <strong>Sua Identidade Atual:</strong> <code><?= htmlspecialchars($currentUserRole) ?></code>
</div>

<?php if ($accessAllowed): ?>
    <div class="success-box">
        <h4>Acesso Autorizado</h4>
        <p>Como <?= $currentUserRole ?>, você tem permissões para modificar o banco de dados do blog.</p>
    </div>
<?php else: ?>
    <div class="error-box">
        <h4>Acesso Proibido (403)</h4>
        <p>Seu nível de segurança é insuficiente para realizar operações de edição.</p>
    </div>
<?php endif; ?>

<div style="display:flex; gap:10px; margin-top:20px;">
    <a href="?role=CONVIDADO"><button>Entrar como Convidado</button></a>
    <a href="?role=EDITOR"><button>Entrar como Editor</button></a>
    <a href="?role=ADMIN"><button>Entrar como Admin</button></a>
</div>


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