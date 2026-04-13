<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 18: Promoção, Destrutores & Propriedades Tipadas";

class NetworkSocket {
    // 1. Constructor Property Promotion (PHP 8 shortcut!)
    // 2. Readonly Property (PHP 8.1 - assigned once, completely locked forever)
    public function __construct(
        public readonly string $address,
        public readonly int $port,
        private string $privateKey
    ) {
        $this->log("Conectando a {$this->address}:{$this->port}...");
    }

    public function log(string $msg): void {
        echo "<div class='info-box' style='padding:5px; margin-bottom:5px; border-width:1px;'>[CORE] $msg</div>";
    }

    // Acionado automaticamente quando o objeto na RAM é desalocado ou o script morre!
    public function __destruct() {
        $this->log("Destrutor Acionado: Desconectando graciosamente o socket {$this->address}.");
    }
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Ciclo de Vida e Bloqueios</h2>
    <p>As funcionalidades do PHP 8 reduzem drasticamente a configuração de classes repetitivas (boilerplate), adicionando uma segurança intensa com <code>readonly</code>.</p>
</div>

<h3>Pilha de Tempo de Execução da Aplicação:</h3>

<?php
// Criamos o objeto
$connection = new NetworkSocket('10.5.5.101', 5432, 'super_secret');

// $connection->address = 'hacked_ip'; // Causará um FATAL CRASH! Bloqueio de Readonly.

// Acionamos manualmente a destruição do objeto ANTES do término do script!
$connection->log("Executando transações...");
unset($connection);

echo "<p>Pilha de execução concluída.</p>";
?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.visibility.php" target="_blank">Manual PHP: Visibilidade e Construtores</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
class Servico {
    public function __construct(private string $apiKey) {}
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>