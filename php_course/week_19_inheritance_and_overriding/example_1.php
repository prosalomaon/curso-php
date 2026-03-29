<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 19: Inheritance Architecture & Overriding";

class StandardDocument {
    // Protected allows Children to manipulate it (Private completely blocks children!)
    protected string $title;
    
    public function __construct(string $title) {
        $this->title = $title;
    }
    
    public function renderContent(): string {
        return "Rendering [{$this->title}] via Default Engine.";
    }
}

// Child extending the Engine
class SecurePdfDocument extends StandardDocument {
    
    public function renderContent(): string {
        // Polymorphism! Run the parent's logic, then augment it.
        $base = parent::renderContent();
        return "<b style='color:green;'>[ENCRYPTED]</b> " . $base . " -> Converted to strictly formatted PDF binary.";
    }
}

$docs = [
    new StandardDocument("Open Source Report"),
    new SecurePdfDocument("Classified Operations Brief")
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Polymorphism (Many Forms)</h2>
    <p>We call the exact same method function name, but the Object determines how deeply to process it!</p>
</div>

<ul style="list-style-type:none; padding:0;">
    <?php foreach ($docs as $doc): ?>
        <li class="content-box" style="margin-bottom:10px;">
            <?= $doc->renderContent() ?> <br>
            <small><code>Instance check - Is SecurePdf? <?= ($doc instanceof SecurePdfDocument ? 'Yes' : 'No') ?></code></small>
        </li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>