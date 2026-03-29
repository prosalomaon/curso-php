<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 19 Project: Subclasses & Races";

class BaseEntity
{
  public function __construct(
    protected string $name,
    protected int $mana = 50,
    protected int $health = 100
  ) {
  }

  public function combatAction(): string
  {
    return "{$this->name} initiates a standard physical attack structure.";
  }

  public function getDetails(): array
  {
    return ['name' => $this->name, 'hp' => $this->health, 'mp' => $this->mana];
  }
}

class Wizard extends BaseEntity
{
  public function __construct(string $name)
  {
    // Run parent construction first, then mutate immediately
    parent::__construct($name);
    $this->health -= 40;  // Fragile
    $this->mana += 200;   // Powerful!
  }

  public function combatAction(): string
  {
    if ($this->mana >= 50) {
      $this->mana -= 50;
      return "{$this->name} casts HELLFIRE! (-50 MP)";
    }
    return parent::combatAction(); // Fallback if out of mana
  }
}

// Orchestration
$entities = [
  new BaseEntity("Town Guard"),
  new Wizard("Gandalf The Great")
];

// Determine if we should simulate an attack round
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // We hackily drain Gandalf's mana to test the fallback using session/state logic 
  // but here we just loop it intensely
  $combatLogs = [];
  foreach ($entities as $e) {
    $combatLogs[] = $e->combatAction();
  }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
  <h2>Subclass Augmentation</h2>
</div>

<div style="display:flex; justify-content:space-between; gap:20px; text-transform:uppercase;">
  <?php foreach ($entities as $e):
    $data = $e->getDetails(); ?>
    <div class="info-box" style="flex:1;">
      <strong>
        <?= htmlspecialchars($data['name']) ?>
      </strong><br>
      HP:
      <?= $data['hp'] ?> | MP:
      <?= $data['mp'] ?>
    </div>
  <?php endforeach; ?>
</div>

<form method="POST" style="margin-top:20px;">
  <button type="submit" style="width:100%;">Execute Turn Combat</button>
</form>

<?php if (isset($combatLogs)): ?>
  <div class="content-box" style="margin-top:20px; background:#000; color:#0f0;">
    <?php foreach ($combatLogs as $log): ?>
      <div>>>
        <?= htmlspecialchars($log) ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>