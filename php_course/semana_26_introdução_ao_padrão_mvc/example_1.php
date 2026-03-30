<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 26: Padrão Model-View-Controller (MVC)";

$architectureFlow = <<<TEXT
1. USUÁRIO solicita -> Roteador.
2. Roteador decide qual CONTROLADOR implantar com base na URL.
3. Controlador recupera variáveis de Dados do MODEL (Banco de Dados).
4. Controlador sanitiza e processa a lógica.
5. Controlador injeta a saída da Lógica na VIEW (HTML).
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Separação Total de Preocupações</h2>
    <p>Seu código PHP cresceu. O MVC é o padrão global para manter grandes bases de código sustentáveis, dividindo explicitamente os domínios.</p>
</div>

<h3>A Matriz do Ciclo de Vida:</h3>
<pre><?= htmlspecialchars($architectureFlow) ?></pre>

<div class="info-box">
    <strong>Regra de Ouro:</strong> As Views absolutamente NUNCA devem executar consultas SQL ou manipular lógica de validação de negócios bruta. Elas apenas imprimem a formatação de dados com segurança via <code>htmlspecialchars()</code>.
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.architecture.php" target="_blank">Manual PHP: Padrão MVC</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
// Router invoca o Controller, passa dados do Model para a View
$controller = new UserController(new UserModel());
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>