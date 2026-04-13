<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 17: Base de API de Gerador de Personagens";

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
    <h2>Pipeline de Instanciação de Objetos</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identifique o Nome do Novo Combatente:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="char_name" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Gerar Entidade</button>
    </div>
</form>

<?php if ($player): ?>
    <?php $heroStruct = $player->getProfile(); ?>
    <div class="success-box">
        <h3 style="margin-top:0;">Entidade Gerada Nativamente:</h3>
        <table>
            <tr><th>Identificador</th><th>Vitalidade (HP)</th><th>Base de Força</th><th>Base de Agilidade</th></tr>
            <tr>
                <td><strong><?= htmlspecialchars($heroStruct['name']) ?></strong></td>
                <td><?= $heroStruct['hp'] ?></td>
                <td><?= $heroStruct['str'] ?></td>
                <td><?= $heroStruct['agi'] ?></td>
            </tr>
        </table>
        
        <p style="font-size:0.8em; margin-bottom:0;"><em>Não podemos alterar manualmente o HP para 9999 a partir do controlador porque a propriedade está encapsulada (Privada)!</em></p>
    </div>
<?php endif; ?>


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