<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 3: A Expressão Match & Estrito";

$httpCode = 404;

// A expressão 'match' do PHP 8 é mais limpa que o switch, retorna um valor e usa comparação estrita ===!
$responseMeaning = match($httpCode) {
    200, 201 => "Sucesso: O processamento da aplicação terminou graciosamente.",
    400 => "Erro do Cliente: Requisição Inválida gerada por entrada inválida.",
    403 => "Bloqueio de Segurança: O acesso é estritamente proibido.",
    404 => "Erro de Roteamento: Recurso ausente.",
    500 => "Falha Crítica na Infraestrutura.",
    default => "Status HTTP desconhecido."
};
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Manipulador de Resposta do Servidor</h2>
    <p>Avaliando códigos de servidor padrão usando a estrutura estrita <code>match()</code> do PHP 8+.</p>
</div>

<div class="info-box">
    <strong>Tráfego Simulado:</strong> Retornando HTTP <code><?= htmlspecialchars((string)$httpCode) ?></code><br>
    <strong>Diagnóstico do Sistema:</strong> <?= htmlspecialchars($responseMeaning) ?>
</div>

<h3>Perigos das Comparações Estritas vs Soltas</h3>
<table>
    <tr><th>Condição</th><th>Solta (==)</th><th>Estrita (===)</th></tr>
    <tr><td><code>"" == 0</code></td><td><span style="color:red">VERDADEIRO (Ruim)</span></td><td><span style="color:green">FALSO (Seguro)</span></td></tr>
    <tr><td><code>"123" == 123</code></td><td><span style="color:red">VERDADEIRO</span></td><td><span style="color:green">FALSO</span></td></tr>
</table>

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