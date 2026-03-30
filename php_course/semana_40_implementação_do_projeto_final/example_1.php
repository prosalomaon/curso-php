<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 40: Tokens CSRF e Polimento Final";

session_start();

// 1. Gerar Token CRSF de forma segura se ele não existir
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$status = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    
    // 2. Validar o token exatamente via comparação segura contra ataques de tempo (timing attack)!
    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        http_response_code(403);
        $status = "PROIBIDO: Incompatibilidade de Token de Segurança. Execução de sequestro CSRF suspeita bloqueada.";
    } else {
        $status = "SUCESSO: Perfil atualizado com segurança.";
        // Redefinir o token para que ele não possa ser reutilizado!
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mitigação de Cross-Site Request Forgery (CSRF)</h2>
    <p>Injetamos um token oculto em CADA formulário. Se um site malicioso enganar seu navegador para enviar um formulário para seu servidor, eles não saberão o token aleatório exato, então a requisição falha na validação nativamente!</p>
</div>

<?php if ($status): ?>
    <div class="<?= str_starts_with($status, 'SUCESSO') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($status) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <!-- INJEÇÃO DE CONSTANTE OCULTA -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    
    <label>Modificar Configuração do Nó de Perfil:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="data" value="Alguns Dados de Layout Seguros" autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Executar</button>
    </div>
    
    <div style="margin-top:10px; font-size:0.8em;">
        <strong>Carga Útil Injetada Oculta:</strong> <code><?= htmlspecialchars($_SESSION['csrf_token']) ?></code>
    </div>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.php" target="_blank">Manual PHP: Implementação</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
// Testes finais e verificações de implantação
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>