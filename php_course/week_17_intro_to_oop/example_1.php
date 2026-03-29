<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 17: Object-Oriented Frameworking (OOP Intro)";

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
// $serverAlpha->cpuUsage = 200; // Will crash script! Property is private.

$statusData = $serverAlpha->getStatus();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Architecting Abstractions (Classes & Objects)</h2>
    <p>Using Objects stops other scripts from randomly altering sensitive data. We build APIs around the data (Encapsulation).</p>
</div>

<h3>Server Status Retrieval:</h3>
<table>
    <tr><th>Engine Host Identifier</th><th>Core Load CPU (%)</th></tr>
    <tr>
        <td><code><?= htmlspecialchars($statusData['host']) ?></code></td>
        <td style="<?= (float)$statusData['load'] > 40 ? 'color:red; font-weight:bold;' : '' ?>">
            <?= htmlspecialchars($statusData['load']) ?>
        </td>
    </tr>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>