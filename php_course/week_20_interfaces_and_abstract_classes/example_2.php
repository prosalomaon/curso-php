<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 20 Project: Solid System Architecture Engine";

interface EquippableInterface {
    public function getArmorBonus(): int;
    public function getSlotNode(): string;
    public function getName(): string;
}

class SteelHelm implements EquippableInterface {
    public function getArmorBonus(): int { return 25; }
    public function getSlotNode(): string { return 'HEAD'; }
    public function getName(): string { return 'Steel Heavy Helm'; }
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
        return "Success: Attached {$item->getName()} to layer [$slot] (+{$item->getArmorBonus()} DEF)";
    }
}

$soldier = new CombatEntity();
$headgear = new SteelHelm();
$healing = new BandageItem();

$logSuccess = $soldier->equip($headgear); // Works!

// Hitting this internally via PHP Type Error
$logFail = null;
try {
    // We force a reflection bypass or just simulate for safety
    // $soldier->equip($healing); // FATAL ERROR!
    $logFail = "FATAL ERROR TYPE EXCEPTION: BandageItem cannot be passed to equip(), does not implement EquippableInterface!";
} catch (TypeError $e) {
    // Handled normally in PHP 8 if configured
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Rigid Interface Type Hinting (S.O.L.I.D.)</h2>
</div>

<h3>Hardware Attachment Flow:</h3>
<div class="success-box">
    <strong>Entity System Action:</strong> <?= htmlspecialchars($logSuccess) ?>
</div>

<div class="error-box">
    <strong>Engine Rejection:</strong> <?= htmlspecialchars($logFail) ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>