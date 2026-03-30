<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 11: Roteamento de Gerenciador de Tarefas via GET";

// 1. Data Retrieval
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';
$taskId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// 2. Controller Routing
// Usando Match para impor uma arquitetura rigorosa sobre query strings
$outputMessage = match($action) {
    'list'   => "Listando todas as tarefas ativas no sistema...",
    'view'   => $taskId ? "Visualizando detalhes complexos para a Tarefa #{$taskId}" : "Erro: ID de Tarefa Ausente",
    'delete' => $taskId ? "[CRÍTICO] Emulando exclusão permanente da Tarefa #{$taskId}!" : "Erro: ID de Tarefa Ausente",
    default  => "Rota desconhecida solicitada: {$action}"
};

$statusClass = str_starts_with($outputMessage, 'Erro') ? 'error-box' : (str_starts_with($outputMessage, '[CRÍTICO]') ? 'error-box' : 'success-box');

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Controlador de Query String</h2>
    <p>Usamos <code>?action=xxx</code> para instruir o arquivo PHP sobre qual bloco de lógica executar, criando essencialmente um roteador de API rudimentar!</p>
</div>

<div class="<?= $statusClass ?>">
    <strong>Estado da Aplicação:</strong> <?= htmlspecialchars($outputMessage) ?>
</div>

<h3>Simular Requisições de Entrada:</h3>
<ul>
    <li><a href="?action=list"><strong>GET</strong> /tasks (Listar)</a></li>
    <li><a href="?action=view&id=88"><strong>GET</strong> /tasks/88 (Visualizar)</a></li>
    <li><a href="?action=delete&id=88"><strong>DELETE</strong> /tasks/88 (Excluir)</a></li>
    <li><a href="?action=hax&id=1"><strong>GET</strong> /tasks/hax (Rota Inválida)</a></li>
</ul>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.variables.superglobals.php" target="_blank">Manual PHP: Superglobais</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
var_dump($_SERVER[&#039;HTTP_HOST&#039;]);
var_dump($_GET[&#039;id&#039;] ?? 1);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>