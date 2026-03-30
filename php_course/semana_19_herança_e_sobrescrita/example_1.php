<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 19: Arquitetura de Herança & Sobrescrita";

class StandardDocument {
    // Protected permite que os Filhos o manipulem (Private bloqueia completamente os filhos!)
    protected string $title;
    
    public function __construct(string $title) {
        $this->title = $title;
    }
    
    public function renderContent(): string {
        return "Processando [{$this->title}] via Motor Padrão.";
    }
}

// Child extending the Engine
class SecurePdfDocument extends StandardDocument {
    
    public function renderContent(): string {
        // Polimorfismo! Execute a lógica do pai e, em seguida, aumente-a.
        $base = parent::renderContent();
        return "<b style='color:green;'>[CRIPTOGRAFADO]</b> " . $base . " -> Convertido em binário PDF estritamente formatado.";
    }
}

$docs = [
    new StandardDocument("Relatório Open Source"),
    new SecurePdfDocument("Briefing de Operações Classificadas")
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Polimorfismo (Muitas Formas)</h2>
    <p>Chamamos exatamente o mesmo nome de função de método, mas o Objeto determina o quão profundamente processá-lo!</p>
</div>

<ul style="list-style-type:none; padding:0;">
    <?php foreach ($docs as $doc): ?>
        <li class="content-box" style="margin-bottom:10px;">
            <?= $doc->renderContent() ?> <br>
            <small><code>Verificação de instância - É SecurePdf? <?= ($doc instanceof SecurePdfDocument ? 'Sim' : 'Não') ?></code></small>
        </li>
    <?php endforeach; ?>
</ul>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.inheritance.php" target="_blank">Manual PHP: Herança</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
class Admin extends Usuario {
    public function getRole() { return &#039;Admin&#039;; }
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>