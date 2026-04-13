<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 27: Configuração de Verbos RESTful";

$restVerbs = [
    'index'   => ['metodo' => 'GET', 'uri' => '/produtos', 'desc' => 'Listar todos os registros do banco de dados de produtos'],
    'create'  => ['metodo' => 'GET', 'uri' => '/produtos/create', 'desc' => 'Renderizar o formulário HTML físico'],
    'store'   => ['metodo' => 'POST','uri' => '/produtos', 'desc' => 'Aceitar carga POST e executar inserção no DB'],
    'show'    => ['metodo' => 'GET', 'uri' => '/produtos/{id}', 'desc' => 'Buscar e exibir um recurso específico'],
    'edit'    => ['metodo' => 'GET', 'uri' => '/produtos/{id}/edit', 'desc' => 'Renderizar formulário HTML pré-preenchido'],
    'update'  => ['metodo' => 'PUT', 'uri' => '/produtos/{id}', 'desc' => 'Aceitar carga PUT e executar modificação no DB'],
    'destroy' => ['metodo' => 'DELETE', 'uri' => '/produtos/{id}', 'desc' => 'Executar algoritmos de eliminação absoluta'],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Paradigmas de Padrão REST</h2>
    <p>Seguir as especificações absolutas do protocolo HTTP cria arquiteturas de URL perfeitamente previsíveis para o backbone do E-Commerce.</p>
</div>

<table>
    <thead><tr><th>Chamada do Controlador MVC</th><th>Verbo</th><th>Caminho URI</th><th>Alvo Operacional</th></tr></thead>
    <tbody>
        <?php foreach ($restVerbs as $action => $details): ?>
        <tr>
            <td><strong><code><?= htmlspecialchars($action) ?>()</code></strong></td>
            <td style="font-weight:bold; color:var(--text-color);"><?= $details['metodo'] ?></td>
            <td><code><?= htmlspecialchars($details['uri']) ?></code></td>
            <td><?= htmlspecialchars($details['desc']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/reserved.variables.server.php" target="_blank">Manual PHP: Roteamento</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$uri = parse_url($_SERVER[&#039;REQUEST_URI&#039;], PHP_URL_PATH);
if ($uri === &#039;/sobre&#039;) { require &#039;sobre.php&#039;; }
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>