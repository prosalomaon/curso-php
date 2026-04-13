<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 2: Desafio de Formulário Web App";
$message = null;
$error = null;

// Form Handling Logic MUST occur before headers/html
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedAnswer = trim($_POST['answer'] ?? '');
    
    // Strict typing logic evaluation
    if (strtolower($submittedAnswer) === 'elephant') {
        $message = "Correto! O mascote do PHP é de fato o elePHPant!";
    } else if (empty($submittedAnswer)) {
        $error = "Você deixou a resposta em branco!";
    } else {
        $error = "'{$submittedAnswer}' está incorreto. Pense em algo cinza e pesado.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Quiz Interativo para Desenvolvedores</h2>
    <p>Usando <code>$_POST</code> separado inteiramente do template da View!</p>
</div>

<?php if ($message): ?>
    <div class="success-box"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-box"><strong>Falha:</strong> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label for="answer"><strong>Pergunta:</strong> Qual animal é o mascote oficial da linguagem PHP?</label>
    <input type="text" id="answer" name="answer" placeholder="Digite sua resposta aqui..." autocomplete="off">
    
    <button type="submit">Validar Resposta</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.php" target="_blank">Manual do PHP: Variáveis e Tipos</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$name = &quot;PHP 8&quot;;
var_dump(is_string($name)); // bool(true)
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>