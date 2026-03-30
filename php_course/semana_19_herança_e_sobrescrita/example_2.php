<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 19: Subclasses & Raças";

class BaseEntity {
    public function __construct(
        protected string $name,
        protected int $mana = 50,
        protected int $health = 100
    ) {}

    public function combatAction(): string {
        return "{$this->name} inicia uma estrutura de ataque físico padrão.";
    }
    
    public function getDetails(): array {
        return ['name'=>$this->name, 'hp'=>$this->health, 'mp'=>$this->mana];
    }
}

class Wizard extends BaseEntity {
    public function __construct(string $name) {
        // Run parent construction first, then mutate immediately
        parent::__construct($name);
        $this->health -= 40;  // Fragile
        $this->mana += 200;   // Powerful!
    }

    public function combatAction(): string {
        if ($this->mana >= 50) {
            $this->mana -= 50;
            return "{$this->name} lança FOGO DO INFERNO! (-50 MP)";
        }
        return parent::combatAction(); // Fallback se ficar sem mana
    }
}

// Orchestration
$entities = [
    new BaseEntity("Guarda da Cidade"),
    new Wizard("Gandalf, o Cinzento")
];

// Determine if we should simulate an attack round
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    <h2>Aumento de Subclasse</h2>
</div>

<div style="display:flex; justify-content:space-between; gap:20px; text-transform:uppercase;">
    <?php foreach ($entities as $e): $data = $e->getDetails(); ?>
        <div class="info-box" style="flex:1;">
            <strong><?= htmlspecialchars($data['name']) ?></strong><br>
            HP: <?= $data['hp'] ?> | MP: <?= $data['mp'] ?>
        </div>
    <?php endforeach; ?>
</div>

<form method="POST" style="margin-top:20px;">
    <button type="submit" style="width:100%;">Executar Turno de Combate</button>
</form>

<?php if (isset($combatLogs)): ?>
    <div class="content-box" style="margin-top:20px; background:#000; color:#0f0;">
        <?php foreach ($combatLogs as $log): ?>
            <div>>> <?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


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