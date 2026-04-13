<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 10: Filtros de Banco de Dados Complexos";

// Simulação de SQL Joins complexos em um array de arquitetura
$tasks = [
    ['id' => 1, 'priority' => 'high', 'completed' => true, 'tag' => 'auth'],
    ['id' => 2, 'priority' => 'low', 'completed' => false, 'tag' => 'ui'],
    ['id' => 3, 'priority' => 'high', 'completed' => false, 'tag' => 'database'],
    ['id' => 4, 'priority' => 'medium', 'completed' => false, 'tag' => 'auth'],
];

// Encadeando: Encontrar todas as tarefas INCOMPLETAS e então pegar APENAS seus nomes de TAG como uma lista limpa!
$pendingTasks = array_filter($tasks, fn($t) => !$t['completed']);
$pendingTags  = array_map(fn($t) => strtoupper($t['tag']), $pendingTasks);

// Tornar as tags únicas usando outra função nativa
$uniquePendingTags = array_unique($pendingTags);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Arquitetura de Pipeline de Dados</h2>
    <p>Em arquiteturas altamente avançadas, encadeamos ações de filtro/mapa para isolar fatias exatas de dados de estruturas complexas.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    
    <div class="content-box" style="flex:1;">
        <h3>Estrutura de Dados Original:</h3>
        <pre><?= htmlspecialchars(var_export($tasks, true)) ?></pre>
    </div>
    
    <div class="info-box" style="flex:1;">
        <h3>Saída de Pipeline Acionável:</h3>
        <p>O sistema precisa saber quais departamentos devem trabalho. Filtramos as tarefas concluídas, agrupamos suas chaves e removemos duplicatas instantaneamente de forma nativa:</p>
        
        <ul style="margin-top:20px;">
            <?php foreach ($uniquePendingTags as $deptCode): ?>
                <li style="font-weight:bold; color:red; margin-bottom:10px;">
                    TRABALHO PENDENTE NO MÓDULO: [<?= htmlspecialchars($deptCode) ?>]
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/functions.anonymous.php" target="_blank">Manual do PHP: Escopo e Funções Anônimas</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$tax = 0.5;
$calc = function($price) use ($tax) {
    return $price + ($price * $tax);
};
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>