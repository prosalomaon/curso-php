<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 31: Array Gerador de UUID";

// Simulamos a utilização de 'ramsey/uuid' do packagist
class SimulatedUuid {
    public static function uuid4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

$generated = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 0; $i < 5; $i++) {
        $generated[] = SimulatedUuid::uuid4();
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mockup de Integração de Terceiros</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <h3>Gerar 5 Nós de Identidade Aleatórios para Banco de Dados:</h3>
    <button type="submit" style="width:100%;">Executar Geração</button>
</form>

<?php if ($generated): ?>
    <div class="info-box">
        <strong>Em vez de inteiros básicos de auto-incremento (1, 2, 3),</strong> sistemas modernos usam UUIDs por segurança para evitar que hackers percorram perfis de usuário (ex: <code>/usuarios/4</code>).
    </div>
    
    <ul style="list-style-type:none; padding:0;">
        <?php foreach ($generated as $key => $uuid): ?>
            <li class="content-box" style="margin-bottom:10px; font-family:monospace; font-size:1.2em; border-color:var(--text-color);">
                <strong>[UUID_<?= $key ?>]</strong> <?= htmlspecialchars($uuid) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.sessions.php" target="_blank">Manual PHP: Autorização e Papéis</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
if (!in_array(&#039;admin&#039;, $_SESSION[&#039;roles&#039;])) {
    http_response_code(403);
    die(&#039;Proibido&#039;);
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>