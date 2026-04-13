<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 29: Registro de E-Commerce";

$log = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'] ?? '';
    
    if (!$mail) {
        $log = "Bloco de Validação: Identificador de estrutura de e-mail malformado.";
    } elseif (strlen($pass) < 10) {
        $log = "Bloco de Política de Segurança: A frase de passagem requer um comprimento mínimo absoluto de 10 caracteres.";
    } else {
        // Gerando o Hash!
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        
        $log = "SUCESSO: Algoritmos de registro aprovados.\nInserção no Banco de Dados Acionada:\nEmail: $mail\nNó Hasheado: $hashed";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Endpoint de Validação de Conta</h2>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCESSO') ? 'success-box' : 'error-box' ?>">
        <?= nl2br(htmlspecialchars($log)) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identificar Origem do Contato (Email):</label>
    <input type="email" name="email" required autocomplete="off">
    
    <label>Base da Frase de Passagem Criptográfica:</label>
    <input type="password" name="password" required>
    
    <button type="submit" style="width:100%;">Finalizar Processamento de Cadastro</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/function.password-hash.php" target="_blank">Manual PHP: Hashing de Senha</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$hash = password_hash(&#039;senha_secreta_123&#039;, PASSWORD_ARGON2ID);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>