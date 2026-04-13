<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 9: Protocolo de Busca de Segurança";

$userDatabase = [
    'alice@example.com', 'admin@example.com', 'bob@example.com', 
    'charlie@example.com', 'malory@example.com'
];

$searchTerm = $_POST['email'] ?? '';
$searchResult = null;
$searchedPaths = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    foreach ($userDatabase as $index => $email) {
        $searchedPaths++; // Acompanha quantas linhas olhamos
        
        if ($email === $searchTerm) {
            $searchResult = "Usuário ID #$index ENCONTRADO para $email";
            break; // OTIMIZAÇÃO IMEDIATA. Não verifica o resto do array!
        }
    }
    if (!$searchResult) $searchResult = "FALHA: Usuário $searchTerm não encontrado.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Busca Otimizada em Array</h2>
    <p>Usando <code>break</code> para evitar ciclos desnecessários de CPU em protocolos de busca.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Encontrar E-mail de Usuário específico (Bob, Alice, Admin...):</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="email" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Executar Verificação no Banco de Dados</button>
    </div>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <?php if (str_starts_with($searchResult, 'Usuário')): ?>
        <div class="success-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php else: ?>
        <div class="error-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php endif; ?>
    
    <div class="info-box">
        <strong>Métricas do Motor:</strong> Pesquisou exatamente <strong><?= $searchedPaths ?></strong> linhas antes de parar a execução do algoritmo.<br>
        <em>Se não tivéssemos usado o break, ele teria varrido todas as 5 linhas todas as vezes!</em>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.functions.php" target="_blank">Manual do PHP: Funções</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
function soma(int $a, int $b): int {
    return $a + $b;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>