<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 7: Arquitetura de Dados Multidimensionais";

// Simulating a parsed JSON API response
$databaseRaw = [
    '2023-10-01' => ['web' => 1200, 'ios' => 450, 'android' => 380],
    '2023-10-02' => ['web' => 1400, 'ios' => 500, 'android' => 410],
    '2023-10-03' => ['web' => 900, 'ios' => 300, 'android' => 310],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Inteligência de Tráfego Agregada</h2>
    <p>Usando mapeamento multidimensional para resumir terabytes de dados de log.</p>
</div>

<table>
    <thead>
        <tr><th>Timestamp</th><th>Rota Web</th><th>Rota iOS</th><th>Rota Android</th><th>Total do Dia</th></tr>
    </thead>
    <tbody>
        <?php foreach ($databaseRaw as $date => $metrics): ?>
        <tr>
            <td><code><?= $date ?></code></td>
            <td><?= number_format((float)$metrics['web']) ?></td>
            <td><?= number_format((float)$metrics['ios']) ?></td>
            <td><?= number_format((float)$metrics['android']) ?></td>
            <td><strong><?= number_format((float)array_sum($metrics)) ?></strong></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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