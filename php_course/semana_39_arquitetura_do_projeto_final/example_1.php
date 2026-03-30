<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 39: Caching de Aplicação Agressivo";

// Mecanismo de Simulação de Cache de Arquivo
$cacheFile = __DIR__ . '/api_cache.json';
$cacheValidForSeconds = 30; 

$wasCached = false;
$apiData = [];

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheValidForSeconds) {
    // 1. Obter diretamente do Cache. Evitar o Banco de Dados inteiramente!
    $cachedData = file_get_contents($cacheFile);
    $apiData = json_decode($cachedData, true);
    $wasCached = true;
} else {
    // 2. Cache Expirado! Re-calcular a lógica pesadamente.
    // Simulando lógica de consulta pesada (ex: JOINing 5 tabelas)
    sleep(1); 
    
    $apiData = [
        'generated_at' => date('H:i:s'),
        'total_active_users' => 45000,
        'sales_volume' => 125000.50
    ];
    
    // 3. Salvar no Arquivo de Cache para o próximo visitante
    file_put_contents($cacheFile, json_encode($apiData));
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Ignorando a Execução de Custo de CPU (Memoização)</h2>
    <p>Ao enviar agregações de banco de dados para um arquivo JSON físico (ou Memória Redis), os próximos 10.000 usuários carregam o site instantaneamente em vez de sobrecarregar o Banco de Dados!</p>
</div>

<div style="display:flex; justify-content:space-between; align-items:center; background:#f4f4f4; padding:20px; border-radius:5px;">
    
    <div style="text-align:center;">
        <h1 style="<?= $wasCached ? 'color:green;' : 'color:red;' ?>">
            <?= $wasCached ? '⚡ CACHE HIT (0.01s)' : '🐢 CACHE MISS/EXPIRADO (1.10s)' ?>
        </h1>
        <p>Atualize a página várias vezes para observar o comportamento do cache resolvendo automaticamente para arquivos.</p>
    </div>
    
    <div>
        <h3>Nó de Dados Recuperado:</h3>
        <pre><?= htmlspecialchars(print_r($apiData, true)) ?></pre>
    </div>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.php" target="_blank">Manual PHP: Arquitetura</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
// Padrões de projeto, Injeção de Dependência
$app = new Application(new Database());
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>