<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 20: Interfaces, Abstratos e Traits Horizontais";

// 1. Interface: A pure contract requirement
interface PaymentGatewayInterface {
    public function processPayload(float $amount): string;
}

// 2. Abstract Class: Partial implementation blueprint
abstract class LoggerBase {
    protected string $type;
    public function __construct(string $type) { $this->type = $type; }
    
    abstract public function triggerLog(string $msg): string; // MUST BE FINISHED BY CHILDREN
}

// 3. Trait: Code injection horizontally across entirely unrelated classes!
trait AuditStamper {
    public function getStamp(): string {
        return " [AUDIT: " . time() . "] ";
    }
}

// Compilation: Everything combined!
class StripeEngine extends LoggerBase implements PaymentGatewayInterface {
    use AuditStamper;

    public function processPayload(float $amount): string {
        return "Execução Stripe: Cobrando $$amount" . $this->getStamp();
    }
    
    public function triggerLog(string $msg): string {
        return "[{$this->type}] Nó interno registrado -> " . $msg;
    }
}

$engine = new StripeEngine('FINANÇAS_CRÍTICAS');
$result1 = $engine->processPayload(150.00);
$result2 = $engine->triggerLog('Pagamento bem-sucedido');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Contratos de Mecanismo & Traits</h2>
    <p>Para construir um framework como Laravel ou Symfony, dependemos intensamente de Interfaces para podermos trocar dependências de forma contínua.</p>
</div>

<h3>Saídas Compiladas:</h3>
<ul>
    <li><?= htmlspecialchars($result1) ?></li>
    <li><?= htmlspecialchars($result2) ?></li>
</ul>

<div class="content-box">
    <h3>Arquitetura de Objetos (POO)</h3>
    <p style="margin-bottom:15px; font-style:italic; font-size:0.9em;">A representação acima mostra a estrutura de classes em POO. A classe base <code>Character</code> define os atributos comuns, enquanto <code>Warrior</code> e <code>Mage</code> estendem essa funcionalidade (Herança), permitindo o reuso de código e comportamentos específicos.</p>
    <div class="mermaid">
    classDiagram
        class Character {
            -string name
            -int health
            -int mana
            +__construct(name, health, mana)
            +takeDamage(amount)
            +isAlive() bool
        }
        class Warrior {
            -int stamina
            +block()
        }
        class Mage {
            -int spellPower
            +castSpell()
        }
        Character <|-- Warrior
        Character <|-- Mage
    </div>
</div>

<div class="info-box">
    <strong>Nota de Arquitetura:</strong> O objeto cumpre o Contrato de Interface, estende o Banco de Dados Abstrato e utiliza a injeção de Trait, tudo de forma impecável!
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