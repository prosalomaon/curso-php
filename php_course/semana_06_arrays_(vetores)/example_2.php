<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 6: Aplicativo de Lista de Tarefas";

// Simple state
$tasks = [
    'Patch de Erro Crítico',
    'Escrever API de Autenticação',
    'Design de Formulários de Login'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['new_task'])) {
    // Sanitize and append
    $safeTask = strip_tags(trim($_POST['new_task']));
    // Prepend to top of array
    array_unshift($tasks, $safeTask);
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Fila de Tarefas Volátil</h2>
    <p>Usando arrays para rastrear o estado (Reinicia ao atualizar, pois ainda não estamos usando Sessão ou Banco de Dados).</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Nova Solicitação de Funcionalidade do Sistema:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="new_task" style="margin-bottom:0;" autocomplete="off" required>
        <button type="submit" style="white-space:nowrap;">Enfileirar Tarefa</button>
    </div>
</form>

<h3>Fila do Sistema Pendente:</h3>
<ul>
    <?php foreach ($tasks as $index => $item): ?>
    <li style="padding:10px; border-bottom:1px dashed var(--border-color);">
        <code>[ID:<?= $index ?>]</code> <strong><?= htmlspecialchars($item) ?></strong>
    </li>
    <?php endforeach; ?>
</ul>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.types.array.php" target="_blank">Manual do PHP: Arrays (Vetores)</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
// Desestruturação
[$driver, $port] = [&#039;mysql&#039;, 3306];
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>