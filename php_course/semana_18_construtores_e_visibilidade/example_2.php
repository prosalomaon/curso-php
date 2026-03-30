<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 18: O Subsistema de Inventário";

class Item {
    public function __construct(
        public readonly string $name,
        public readonly int $weight
    ) {}
}

class InventoryEngine {
    private array $items = [];

    // Requires an Item object (Dependency Injection Type Hint)
    public function push(Item $payload): void {
        $this->items[] = $payload;
    }

    public function calculateEncumbrance(): int {
        return array_reduce($this->items, fn($sum, $item) => $sum + $item->weight, 0);
    }
    
    public function list(): array {
        return $this->items;
    }
}

// Application Orchestration
$satchel = new InventoryEngine();
$satchel->push(new Item('Steel Broadsword', 12));
$satchel->push(new Item('Health Potion', 1));
$satchel->push(new Item('Heavy Iron Greaves', 18));

$totalWeight = $satchel->calculateEncumbrance();
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Injeção Estrita de Objetos (Type Hinting)</h2>
    <p>Ao forçar Objetos específicos nas funções, eliminamos 90% dos erros estruturais de forma contínua.</p>
</div>

<h3>Conteúdo da Bolsa:</h3>
<table>
    <tr><th>Nomenclatura do Item</th><th>Peso (Lbs)</th></tr>
    <?php foreach ($satchel->list() as $i): ?>
        <tr>
            <td><code><?= htmlspecialchars($i->name) ?></code></td>
            <td><?= $i->weight ?></td>
        </tr>
    <?php endforeach; ?>
    <tr style="background:var(--hover-bg); font-weight:bold;">
        <td>Sobrecarga Total do Mecanismo</td>
        <td style="<?= $totalWeight > 30 ? 'color:red;' : '' ?>"><?= $totalWeight ?></td>
    </tr>
</table>


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