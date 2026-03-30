<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 24: Fluxos de Trabalho de Exclusão Segura";

$articleId = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);
$currentUserId = 1; // Sessão simulada
$log = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $articleId) {
    // Fase de Simulação do Estágio 1: Verificação
    $ownerCheckPassed = ($articleId !== 999); // 999 simula um artigo que não pertence ao usuário
    
    if (!$ownerCheckPassed) {
        $log = "ERRO: Você não tem autorização para excluir o Artigo #$articleId.";
    } else {
        // Fase de Simulação do Estágio 2: Execução
        $log = "SUCESSO: Artigo #$articleId e todas as Tags associadas foram completamente apagados do Banco de Dados.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Impondo Propriedade no DELETE</h2>
    <p>Se você não verificar <code>WHERE autor_id = :uid</code> dentro de suas consultas de exclusão, hackers simplesmente alteram o ID para apagar os dados de outra pessoa!</p>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCESSO') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($log) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="border-color:red;">
    <label>Selecione o Artigo Alvo para Exclusão:</label>
    <div style="display:flex; gap:10px;">
        <select name="delete_id">
            <option value="55">Artigo Normal #55 (Pertence a Você)</option>
            <option value="999">Dados Restritos #999 (Tentativa de Invasão Simulada)</option>
        </select>
        <button type="submit" style="background:red;">Executar Exclusão Permanente</button>
    </div>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdostatement.execute.php" target="_blank">Manual PHP: Operações CRUD</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$stmt = $pdo-&gt;prepare(&quot;INSERT INTO users (name) VALUES (:name)&quot;);
$stmt-&gt;execute([&#039;name&#039; =&gt; $data]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>