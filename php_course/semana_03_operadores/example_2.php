<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 3: Portão de Segurança de Conteúdo";
$gateStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs via robust filters
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $subscribe = isset($_POST['subscribe']); // Checkbox presence

    if ($age === false) {
        $gateStatus = ['status' => 'error', 'msg' => 'Inteiro inválido fornecido para a idade.'];
    } elseif ($age < 18) {
        $gateStatus = ['status' => 'error', 'msg' => 'Acesso Negado: Você deve ter 18 anos ou mais para visualizar a rede profissional.'];
    } elseif (!$subscribe) {
        $gateStatus = ['status' => 'info', 'msg' => 'Acesso Concedido, mas por favor considere assinar nossa newsletter técnica!'];
    } else {
        $gateStatus = ['status' => 'success', 'msg' => 'Acesso Concedido: Bem-vindo, Membro Pro.'];
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Portão de Autenticação de Infraestrutura</h2>
    <p>Utilizando condicionais compostas e lógica booleana de forma segura.</p>
</div>

<?php if ($gateStatus): ?>
    <div class="<?= htmlspecialchars($gateStatus['status']) ?>-box">
        <?= htmlspecialchars($gateStatus['msg']) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <label><strong>Digite sua Idade:</strong></label>
    <input type="number" name="age" required min="1" max="120">
    
    <div style="margin-bottom: 20px;">
        <input type="checkbox" name="subscribe" id="sub" value="1">
        <label for="sub" style="font-weight:bold;">Inscrever-se na Newsletter Técnica Profissional (Concorda com os Termos)</label>
    </div>

    <button type="submit">Tentar Login</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.operators.php" target="_blank">Manual do PHP: Operadores</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$result = match(true) {
    $a === $b =&gt; &#039;Estritamente Igual&#039;,
    default =&gt; &#039;Diferente&#039;
};
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>