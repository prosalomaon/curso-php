<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 20: Interfaces, Abstracts, and Horizontal Traits";

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
        return "Stripe Execution: Charging $$amount" . $this->getStamp();
    }
    
    public function triggerLog(string $msg): string {
        return "[{$this->type}] Logged internal node -> " . $msg;
    }
}

$engine = new StripeEngine('CRITICAL_FINANCE');
$result1 = $engine->processPayload(150.00);
$result2 = $engine->triggerLog('Payment succeeded');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Engine Contracts & Traits</h2>
    <p>To build a framework like Laravel or Symfony, we rely intensely on Interfaces so we can swap out dependencies seamlessly.</p>
</div>

<h3>Compiled Outputs:</h3>
<ul>
    <li><?= htmlspecialchars($result1) ?></li>
    <li><?= htmlspecialchars($result2) ?></li>
</ul>

<div class="info-box">
    <strong>Architecture Note:</strong> The object fulfills the Interface Contract, extends the Abstract Database, and utilizes the Trait injection all flawlessly!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>