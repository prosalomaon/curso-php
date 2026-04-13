<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 29: Criptografia e Hashing de Senhas";

$plaintext = "SecureSystem__89";

// O Hashing é LENTO agressivamente para evitar a quebra do banco de dados por força bruta!
$options = ['cost' => 12];
$secureHashValue = password_hash($plaintext, PASSWORD_DEFAULT, $options);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Algoritmos de Geração de Hash Criptográfico</h2>
    <p>Usar <code>md5()</code> ou <code>sha1()</code> para senhas é criticamente perigoso. Usamos <code>password_hash()</code> porque ele gera strings de sal (salt) aleatórias implicitamente e executa loops dinamicamente para queimar CPU intencionalmente.</p>
</div>

<table>
    <tr><th>Mapa de Valor Bruto</th><th>Assinatura Hex Gerada (BCRYPT geralmente)</th></tr>
    <tr>
        <td><code><?= htmlspecialchars($plaintext) ?></code></td>
        <td style="word-break:break-all;"><strong><?= htmlspecialchars($secureHashValue) ?></strong></td>
    </tr>
</table>

<div class="info-box">
    <strong>Garantia de Tempo Constante:</strong> Observe que as strings BCRYPT contêm o marcador de algoritmo (<code>$2y$</code>) e o modificador de custo (<code>12$</code>) nativamente vinculados à assinatura.
</div>

<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/function.password-hash.php" target="_blank">Manual PHP: Hashing de Senha</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$hash = password_hash(&#039;senha_secreta_123&#039;, PASSWORD_ARGON2ID);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>