<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 24: Conformidade ACID e Transações de Banco de Dados";

$transactionCode = <<<PHP
try {
    \$pdo->beginTransaction();

    // Deduzir dinheiro da Conta A
    \$pdo->exec("UPDATE contas SET saldo = saldo - 100 WHERE id = 1");
    
    // Adicionar dinheiro à Conta B
    \$pdo->exec("UPDATE contas SET saldo = saldo + 100 WHERE id = 2");

    \$pdo->commit(); // Salvar todas as alterações atomicamente

} catch (Exception \$e) {
    \$pdo->rollBack(); // Em QUALQUER erro, reverter todo o lote!
    throw \$e;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>A Rede de Segurança <code>rollBack()</code></h2>
    <p>O que acontece se um script falha no meio da transferência de R$ 10.000 de um usuário para outro? Corrupção de dados. Transações corrigem isso instantaneamente.</p>
</div>

<h3>Bloco de Código de Consistência Atômica:</h3>
<pre><?= htmlspecialchars($transactionCode) ?></pre>

<div class="info-box">
    Ao implantar lógica que toca em várias tabelas de banco de dados simultaneamente (ex: criar um Usuário E atribuir-lhe um Perfil), envolva-a nativamente em uma Transação PDO!
</div>


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