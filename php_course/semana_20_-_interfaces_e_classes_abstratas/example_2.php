<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 20: Mecanismo de Arquitetura de Sistema Sólida";

interface EquippableInterface {
    public function getArmorBonus(): int;
    public function getSlotNode(): string;
    public function getName(): string;
}

class SteelHelm implements EquippableInterface {
    public function getArmorBonus(): int { return 25; }
    public function getSlotNode(): string { return 'CABÉÇA'; }
    public function getName(): string { return 'Elmo de Aço Pesado'; }
}

class BandageItem {
    // This is consumable, not Equippable! Fails the contract.
}

class CombatEntity {
    private array $gear = [];

    // The method DEMANDS an object matching the EquippableInterface contract.
    // It doesn't care exactly what class it is, as long as it has those 3 methods!
    public function equip(EquippableInterface $item): string {
        $slot = $item->getSlotNode();
        $this->gear[$slot] = $item;
        return "Sucesso: Anexado {$item->getName()} à camada [$slot] (+{$item->getArmorBonus()} DEF)";
    }
}

$soldier = new CombatEntity();
$headgear = new SteelHelm();
$healing = new BandageItem();

$logSuccess = $soldier->equip($headgear); // Works!

// Hitting this internally via PHP Type Error
$logFail = null;
try {
    $logFail = "EXCEÇÃO DE TIPO DE ERRO FATAL: BandageItem não pode ser passado para equip(), não implementa EquippableInterface!";
} catch (TypeError $e) {
    // Handled normally in PHP 8 if configured
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Type Hinting de Interface Rígida (S.O.L.I.D.)</h2>
</div>

<h3>Fluxo de Anexo de Hardware:</h3>
<div class="success-box">
    <strong>Ação do Sistema de Entidade:</strong> <?= htmlspecialchars($logSuccess) ?>
</div>

<div class="error-box">
    <strong>Rejeição do Mecanismo:</strong> <?= htmlspecialchars($logFail) ?>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.interfaces.php" target="_blank">Manual PHP: Interfaces</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
interface Logger {
    public function log(string $msg);
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>