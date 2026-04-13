<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 17: Mergulho Profundo em Processamento Automatizado";

// Encapsulation Concept
class CoreEngine {
    // Properties represent data
    private float $cpuUsage = 0.0;
    private string $hostname;

    // Initialization constructor
    public function __construct(string $hostname) {
        $this->hostname = $hostname;
    }

    // Methods represent actions/abilities
    public function spikeCpu(float $amount): void {
        if ($amount < 0) throw new InvalidArgumentException("Spike cannot be negative.");
        $this->cpuUsage += $amount;
    }

    public function getStatus(): array {
        return [
            'host' => $this->hostname,
            'load' => $this->cpuUsage . '%'
        ];
    }
}

// Memory instantiation
$serverAlpha = new CoreEngine('SERVER_ALPHA_NODE');
$serverAlpha->spikeCpu(45.5);

$statusData = $serverAlpha->getStatus();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Arquitetando Abstrações (Classes & Objetos)</h2>
    <p>O uso de Objetos impede que outros scripts alterem aleatoriamente dados sensíveis. Construímos APIs em torno dos dados (Encapsulamento).</p>
</div>

<h3>Recuperação de Status do Servidor:</h3>
<table>
    <tr><th>Identificador de Host do Mecanismo</th><th>Carga de CPU do Core (%)</th></tr>
    <tr>
        <td><code><?= htmlspecialchars($statusData['host']) ?></code></td>
        <td style="<?= (float)$statusData['load'] > 40 ? 'color:red; font-weight:bold;' : '' ?>">
            <?= htmlspecialchars($statusData['load']) ?>
        </td>
    </tr>
</table>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.php" target="_blank">Manual PHP: Introdução a POO</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
class Usuario {
    public string $nome;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>