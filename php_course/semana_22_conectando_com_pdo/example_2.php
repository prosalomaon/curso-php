<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 22: Abstrações de Busca PDO";

class SimulatedStatement {
    public function fetchAll(int $mode = PDO::FETCH_ASSOC): array {
        if ($mode === PDO::FETCH_OBJ) {
            return [(object)['id'=>1, 'titulo'=>'Arquitetura do Mecanismo PDO']];
        }
        return [['id'=>1, 'titulo'=>'Arquitetura do Mecanismo PDO']];
    }
}

$stmt = new SimulatedStatement();
$assocOutput = $stmt->fetchAll(PDO::FETCH_ASSOC);
$objOutput = $stmt->fetchAll(PDO::FETCH_OBJ);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mecanismo de Formato de Recuperação</h2>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Arrays Padrão (FETCH_ASSOC)</h3>
        <p>Mapeamento de hash de array ultra-rápido.</p>
        <pre><?= htmlspecialchars(print_r($assocOutput, true)) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Objetos Anônimos (FETCH_OBJ)</h3>
        <p>Sintaxe <code>$row->titulo</code> mais limpa aplicada nativamente.</p>
        <pre><?= htmlspecialchars(print_r($objOutput, true)) ?></pre>
    </div>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/pdo.connections.php" target="_blank">Manual PHP: Conexão PDO</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$pdo = new PDO(&#039;mysql:host=localhost;dbname=test&#039;, &#039;usuario&#039;, &#039;senha&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>