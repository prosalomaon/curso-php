<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
// Simulamos fisicamente uma requisição de API aqui interceptando a saída
if (isset($_GET['api']) && $_GET['api'] === 'fetch') {
    ob_end_clean(); // Apaga qualquer buffer de saída HTML instantaneamente
    header('Content-Type: application/json; charset=utf-8');
    
    $payload = [
        'metadata' => ['status' => 200, 'timestamp' => time()],
        'data' => [
            ['id' => 10, 'username' => 'sys_admin', 'tier' => 'gold'],
            ['id' => 11, 'username' => 'ghost_user', 'tier' => 'basic']
        ]
    ];
    
    echo json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    exit; // PARA TODA A EXECUÇÃO PARA QUE NENHUM HTML SEJA CARREGADO!
}

$pageTitle = "Semana 35: Construindo APIs JSON";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Renderizando Saída JSON Pura Nativamente</h2>
    <p>O PHP alimenta APIs globais perfeitamente apenas alterando os cabeçalhos de resposta e interrompendo a saída HTML.</p>
</div>

<div class="content-box">
    <h3>Arquitetura de API REST</h3>
    <p style="margin-bottom:15px; font-style:italic; font-size:0.9em;">Este diagrama mostra como uma API REST funciona como uma ponte: ela recebe requisições JSON de clientes remotos (como apps móveis), processa os dados de forma isolada do HTML e retorna respostas padronizadas com códigos de status HTTP apropriados.</p>
    <div class="mermaid">
    flowchart LR
        A["Cliente (Mobile/SPA)"] -->|1. Requisição JSON| B["API Gateway PHP"]
        B -->|2. Valida Token/Auth| C["Router"]
        C -->|3. Executa Controller| D["Model/DB"]
        D -->|4. Retorna Dados| C
        C -->|5. Formata JSON| B
        B -->|6. Resposta HTTP 200/201| A
    </div>
</div>

<div class="info-box">
    <a href="?api=fetch" style="color:#0c5460; font-weight:bold;">
        [ CLIQUE AQUI PARA VER A CARGA ÚTIL DA API NO NAVEGADOR ]
    </a>
</div>

<h3>Arquitetura Necessária:</h3>
<pre>
header('Content-Type: application/json; charset=utf-8');
echo json_encode($dadosArray);
exit;
</pre>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/reserved.variables.server.php" target="_blank">Manual PHP: Construindo APIs</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
if ($_SERVER[&#039;REQUEST_METHOD&#039;] === &#039;POST&#039;) {
    // Criar recurso
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>