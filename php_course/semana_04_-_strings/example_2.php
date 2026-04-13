<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 4: Ferramenta de Formatação de String Personalizada";

$results = null;

/**
 * Uma função geradora semelhante a uma classe utilitária para limpar texto do usuário!
 */
function sanitizeAndFormatText(string $rawInput): array {
    $clean = strip_tags(trim($rawInput)); // Security: strip HTML
    return [
        'original' => $rawInput,
        'uppercase' => strtoupper($clean),
        'word_count' => str_word_count($clean),
        'slug' => strtolower(str_replace(' ', '-', $clean))
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['rawText'] ?? '';
    if (!empty($input)) {
        $results = sanitizeAndFormatText($input);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Pipeline de Formatação de Dados</h2>
    <p>Envie qualquer string bagunçada abaixo e veja o motor processá-la de forma limpa via funções separadas.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Cole o texto aqui (Tente adicionar HTML como &lt;b&gt;):</label>
    <textarea name="rawText" rows="4"></textarea>
    <button type="submit">Processar Texto</button>
</form>

<?php if ($results): ?>
    <h3>Pipeline de Saída:</h3>
    <table>
        <tr><th>Carga Original:</th><td><code><?= htmlspecialchars($results['original']) ?></code></td></tr>
        <tr><th>Transformação em Maiúsculas:</th><td><strong><?= htmlspecialchars($results['uppercase']) ?></strong></td></tr>
        <tr><th>Total de Palavras Processadas:</th><td><?= htmlspecialchars((string)$results['word_count']) ?></td></tr>
        <tr><th>Slug Amigável para URL:</th><td><code><?= htmlspecialchars($results['slug']) ?></code></td></tr>
    </table>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.string.php" target="_blank">Manual do PHP: Strings</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$greeting = sprintf(&quot;Olá, %s!&quot;, $user);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>