<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 2: Tipos Escalares & Memória no PHP 8";

$dataTypes = [
    ['type' => 'Inteiro', 'value' => 404, 'check' => is_int(404)],
    ['type' => 'Flutuante', 'value' => 3.14159, 'check' => is_float(3.14159)],
    ['type' => 'String', 'value' => "Dados Interpolados", 'check' => is_string("Interpolated Data")],
    ['type' => 'Booleano', 'value' => true, 'check' => is_bool(true)],
    ['type' => 'Nulo', 'value' => null, 'check' => is_null(null)]
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Layout de Memória e Escalares</h2>
    <p>O PHP usa o motor Zend Engine para alocar memória dinamicamente, mas devemos impor tipos estritos em bases de código profissionais para evitar falhas de coerção.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Nome do Tipo de Dado</th>
            <th>Valor Bruto do Script</th>
            <th>Verificação de Tipo Estrito Passou?</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataTypes as $var): ?>
        <tr>
            <td><strong><?= htmlspecialchars($var['type']) ?></strong></td>
            <td><code><?= htmlspecialchars(var_export($var['value'], true)) ?></code></td>
            <td><?= $var['check'] ? '<span style="color:green">SIM</span>' : '<span style="color:red">NÃO</span>' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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