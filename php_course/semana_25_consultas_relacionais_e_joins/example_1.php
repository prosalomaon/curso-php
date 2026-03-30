<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 25: SQL JOINs e Otimização do Sistema";

$querySyntax = <<<SQL
SELECT 
    usuarios.username, 
    COUNT(posts.id) as total_posts 
FROM usuarios 
LEFT JOIN posts ON usuarios.id = posts.usuario_id 
GROUP BY usuarios.id;
SQL;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Relacionamentos de Banco de Dados acima de loops (Crise N+1)</h2>
    <p>Executar Consultas SQL dentro de um loop <code>foreach</code> do PHP é fortemente proibido em produção. Em vez disso, usamos a sintaxe SQL <code>JOIN</code> para obter dados interconectados instantaneamente!</p>
</div>

<h3>Recuperação de Dados Agregados (Contar total de posts por usuário)</h3>
<pre><?= htmlspecialchars($querySyntax) ?></pre>

<div class="info-box">
    Esta lógica é executada puramente dentro da RAM do MySQL/MariaDB em 3 milissegundos, em vez de o PHP sobrecarregar a rede com milhares de solicitações de conexão separadas nativamente!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.pdo.php" target="_blank">Manual PHP: Consultas JOIN</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>SELECT u.name, p.title 
FROM users u 
JOIN posts p ON u.id = p.user_id;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>