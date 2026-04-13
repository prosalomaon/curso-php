<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 34: Try/Catch e Propagação de Exceções";

$log = [];

class DatabaseException extends Exception {}
class ValidationException extends Exception {}

function attemptFragileOperation(bool $failDb, bool $failVal) {
    if ($failVal) throw new ValidationException("O usuário forneceu dados de entrada incorretos.");
    if ($failDb) throw new DatabaseException("O mecanismo MySQL ficou offline inesperadamente.");
    
    return "Operação bem-sucedida!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $failDb = isset($_POST['fail_db']);
    $failVal = isset($_POST['fail_val']);
    
    try {
        $log[] = "Tentando operação...";
        $result = attemptFragileOperation($failDb, $failVal);
        $log[] = "RESULTADO: " . $result;
        
    } catch (ValidationException $e) {
        $log[] = "[CAPTURADO] Erro de Lógica de Negócios: " . $e->getMessage();
        
    } catch (DatabaseException $e) {
        $log[] = "[CAPTURADO] Erro de Infraestrutura: " . $e->getMessage();
        // Aqui você normalmente registraria no Monolog e avisaria o DevOps!
        
    } catch (Exception $e) {
        // O fallback definitivo para qualquer outra coisa
        $log[] = "[FATAL] Falha desconhecida: " . $e->getMessage();
        
    } finally {
        $log[] = "Bloco Finally Executado: Limpando RAM/Arquivos independente de sucesso ou falha.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Lidando com Falhas Catastróficas</h2>
    <p>O uso de Exceções Personalizadas permite direcionar o tráfego quando os scripts explodem nativamente, evitando as telas brancas da morte.</p>
</div>

<form method="POST" class="content-box" style="display:flex; flex-direction:column; gap:10px;">
    <div>
        <input type="checkbox" id="v" name="fail_val" value="1"> 
        <label for="v">Simular Dados de Usuário Inválidos (Erro Suave)</label>
    </div>
    <div>
        <input type="checkbox" id="d" name="fail_db" value="1"> 
        <label for="d">Simular Queda de Rede do Banco de Dados (Crash Grave)</label>
    </div>
    <button type="submit">Executar Bloco de Execução</button>
</form>

<?php if ($log): ?>
    <ul class="content-box" style="background:#000; color:#0f0; padding:20px; list-style-type:none;">
        <?php foreach ($log as $l): ?>
            <li style="margin-bottom:5px;">>> <?= htmlspecialchars($l) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.curl.php" target="_blank">Manual PHP: APIs Externas (cURL)</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$ch = curl_init(&#039;https://api.github.com/users/octocat&#039;);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>