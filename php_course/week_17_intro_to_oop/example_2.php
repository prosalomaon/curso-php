<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 17 Project: Character Generator API Base";

class BaseCharacter {
    private string $name;
    private int $hp;
    private int $strength;
    private int $agility;

    public function __construct(string $name) {
        $this->name = $name;
        $this->rollStats();
    }

    // A private internal action that the controller cannot call publicly
    private function rollStats(): void {
        $this->hp = random_int(80, 150);
        $this->strength = random_int(5, 20);
        $this->agility = random_int(5, 20);
    }

    public function getProfile(): array {
        return [
            'name' => $this->name,
            'hp' => $this->hp,
            'str' => $this->strength,
            'agi' => $this->agility
        ];
    }
}

$player = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawName = trim($_POST['char_name'] ?? '');
    if (!empty($rawName)) {
        // Instantiate using form class logic!
        $player = new BaseCharacter(htmlspecialchars($rawName));
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Object Instantiation Pipeline</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identify New Combatant Name:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="char_name" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Generate Entity</button>
    </div>
</form>

<?php if ($player): ?>
    <?php $heroStruct = $player->getProfile(); ?>
    <div class="success-box">
        <h3 style="margin-top:0;">Entity Generated Natively:</h3>
        <table>
            <tr><th>Identifier</th><th>Vitality (HP)</th><th>Strength Base</th><th>Agility Base</th></tr>
            <tr>
                <td><strong><?= htmlspecialchars($heroStruct['name']) ?></strong></td>
                <td><?= $heroStruct['hp'] ?></td>
                <td><?= $heroStruct['str'] ?></td>
                <td><?= $heroStruct['agi'] ?></td>
            </tr>
        </table>
        
        <p style="font-size:0.8em; margin-bottom:0;"><em>We cannot manually change the HP to 9999 from the controller because the property is encapsulated (Private)!</em></p>
    </div>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/language.oop5.php" target="_blank">PHP Manual: Intro to OOP</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
class User {
    public string $name;
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>