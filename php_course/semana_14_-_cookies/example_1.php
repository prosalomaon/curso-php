<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 14: Cookies e Rastreamento Persistente";

$cookieName = 'app_theme';
$cookieSetAction = $_POST['theme'] ?? null;
$statusMsg = null;

// Logic execution before Headers are sent!
if ($cookieSetAction) {
    // Passing cookie options as strongly typed array (PHP 7.3+)
    setcookie($cookieName, $cookieSetAction, [
        'expires' => time() + (86400 * 30), // 30 Days mapping
        'path'    => '/',
        'samesite'=> 'Lax'
    ]);
    
    // In order for $_COOKIE to reflect IMMEDIATELY on this exact page load, 
    // we manually inject it into the superglobal array (since the browser hasn't sent it back yet).
    $_COOKIE[$cookieName] = $cookieSetAction; 
    $statusMsg = "Configuração de cookie enviada com sucesso.";
}

$currentTheme = $_COOKIE[$cookieName] ?? 'light_mode';
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Armazenamento de Carga no Lado do Cliente (Cookies)</h2>
    <p>Usando cookies para descarregar rastreadores de preferência específicos sem a necessidade de armazenamento em banco de dados por usuário.</p>
</div>

<?php if ($statusMsg): ?>
    <div class="success-box"><?= htmlspecialchars($statusMsg) ?></div>
<?php endif; ?>

<div class="info-box">
    <strong>Leitura de Preferência Ativa do Cliente:</strong> <code><?= htmlspecialchars($currentTheme) ?></code>
</div>

<form method="POST" class="content-box">
    <h3>Injetar Cookie de Configuração:</h3>
    <div style="display:flex; gap:10px;">
        <select name="theme">
            <option value="light_mode">Matriz Clara (Padrão)</option>
            <option value="dark_mode">Console Escuro</option>
            <option value="cyber_punk">Protocolo Cyber</option>
        </select>
        <button type="submit" style="white-space:nowrap;">Implantar Rastreador</button>
    </div>
</form>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.cookies.php" target="_blank">Manual PHP: Cookies</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
setcookie(&#039;theme&#039;, &#039;dark&#039;, time() + 3600, &#039;/&#039;, &#039;&#039;, true, true);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>