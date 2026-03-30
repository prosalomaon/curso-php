<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 38: Desenvolvimento Orientado por Testes (TDD)";

$conceptText = <<<TEXT
1. RED: Escreva o teste exato PRIMEIRO! Execute-o. Veja-o falhar porque nenhum código existe nativamente ainda.
2. GREEN: Escreva a quantidade mínima de código PHP necessária para passar no nó de verificação.
3. REFACTOR: Limpe a arquitetura do código com segurança, verificando se os testes ainda passam.
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Fluxo de Trabalho de Desenvolvimento Orientado por Testes (TDD)</h2>
</div>

<h3>Matriz de Configuração do Ciclo TDD</h3>
<pre><?= htmlspecialchars($conceptText) ?></pre>

<div class="success-box">
    Escrever testes inicialmente parece lento. Mas conforme seu sistema cresce para milhares de linhas, alterar 1 método fundamental leva 5 segundos de teste, em vez de uma semana inteira de verificação manual de QA!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.datetime.php" target="_blank">Manual PHP: Datas e Horários</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$dt = new DateTime();
echo $dt-&gt;format(&#039;Y-m-d H:i:s&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>