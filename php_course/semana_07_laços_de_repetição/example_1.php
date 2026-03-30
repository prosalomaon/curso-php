<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 7: Arquitetura de Dados Multidimensionais";

// Simulating a parsed JSON API response
$databaseRaw = [
    'schema_version' => '1.5',
    'users' => [
        ['id' => 10, 'role' => 'dev', 'tags' => ['c#', 'php']],
        ['id' => 11, 'role' => 'admin', 'tags' => ['hr_manager', 'payroll']]
    ]
];

// Rebuilding data structurally via iteration
$hrPersonnel = [];
foreach ($databaseRaw['users'] as $user) {
    if (in_array('hr_manager', $user['tags'])) {
        $hrPersonnel[] = $user;
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Navegação em Matriz Profunda</h2>
    <p>Como analisamos arrays de nível mais profundo representando Joins de Banco de Dados ou corpos JSON?</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1; min-width:300px;">
        <h3>Carga de Entrada:</h3>
        <pre><?= htmlspecialchars(print_r($databaseRaw, true)) ?></pre>
    </div>
    
    <div style="flex:1; min-width:300px;">
        <h3>Resultados Filtrados (Tag RH):</h3>
        <?php if (empty($hrPersonnel)): ?>
            <p>Nenhum pessoal de RH encontrado.</p>
        <?php else: ?>
            <ul>
            <?php foreach ($hrPersonnel as $hr): ?>
                <li>
                    <strong>ID Encontrado:</strong> <?= $hr['id'] ?> <br>
                    <strong>Nível de Acesso:</strong> <?= strtoupper($hr['role']) ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/control-structures.foreach.php" target="_blank">Manual do PHP: Laços de Repetição</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
foreach($users as $id =&gt; $name) {
    echo &quot;Usuário $id: $name&quot;;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>