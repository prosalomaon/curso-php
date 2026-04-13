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

<div class="content-box">
    <h3>Fluxo da Arquitetura MVC</h3>
    <p style="margin-bottom:15px; font-style:italic; font-size:0.9em;">O padrão MVC organiza o código em três camadas: o Roteador direciona a URL, o Controller coordena a lógica, o Model gerencia os dados do banco, e a View cuida apenas da apresentação final ao usuário.</p>
    <div class="mermaid">
    flowchart TD
        User(("Usuário")) -->|Interação/URL| Router["Roteador"]
        Router -->|Despacha| Controller["Controlador"]
        Controller -->|Pede Dados| Model["Model"]
        Model -->|Retorna Dados| Controller
        Controller -->|Injeta Dados| View["View"]
        View -->|Renderiza HTML| User
    </div>
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