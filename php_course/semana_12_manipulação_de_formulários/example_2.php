<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 12: Construção de Formulário de Gerenciador de Tarefas";

$errors = [];
$title = $_POST['title'] ?? '';
$priority = $_POST['priority'] ?? '1';
$creationSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($title);
    if (mb_strlen($title) < 5) {
        $errors['title'] = 'Exceção Arquitetônica: O comprimento do título deve ter no mínimo 5 caracteres.';
    }

    $priorityInt = filter_input(INPUT_POST, 'priority', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 3]
    ]);
    if ($priorityInt === false) {
        $errors['priority'] = 'Erro do Sistema: Flag de prioridade não autorizada.';
    }

    if (empty($errors)) {
        $creationSuccess = true;
        $title = ''; 
        $priority = '1';
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Assistente de Criação de Rastreador de Problemas</h2>
</div>

<?php if ($creationSuccess): ?>
    <div class="success-box">Ticket estabelecido e enviado com sucesso para a fila de trabalho.</div>
<?php endif; ?>

<form method="POST" class="content-box" style="border:2px dashed var(--border-color);">
    <label>Nomenclatura da Tarefa:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="e.g. Refatorar controladores de API">
    <?php if (isset($errors['title'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['title']}</div>"; ?>
    
    <label>Nível de Severidade:</label>
    <select name="priority">
        <option value="1" <?= $priority === '1' ? 'selected' : '' ?>>Nível 1: Menor (Baixo)</option>
        <option value="2" <?= $priority === '2' ? 'selected' : '' ?>>Nível 2: Padrão (Médio)</option>
        <option value="3" <?= $priority === '3' ? 'selected' : '' ?>>Nível 3: Crítico (Alto)</option>
    </select>
    <?php if (isset($errors['priority'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['priority']}</div>"; ?>

    <button type="submit" style="width:100%;">Criar Nó de Tarefa</button>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/tutorial.forms.php" target="_blank">Manual PHP: Manipulação de Formulários</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$name = filter_input(INPUT_POST, &#039;name&#039;, FILTER_SANITIZE_STRING);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>