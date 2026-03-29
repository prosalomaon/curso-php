<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 32 Project: Namespace Collision Resolution";

// Simulated scenario: You downloaded a PDF library, and it has a 'Logger' class.
// But YOUR app also has a 'Logger' class!

namespace App\Internal {
    class Logger {
        public function __construct() { echo "<li>Internal App Logger Booted</li>"; }
    }
}

namespace Vendor\PDFLibrary {
    class Logger {
        public function __construct() { echo "<li>External Package Logger Booted</li>"; }
    }
}

namespace App\Execution {
    $title = "Namespace Collision Handling";
    
    // We handle logic manually here because of how namespaces isolate execution
    ob_start();
    // Using aliases to fix the exact same Name!
    use App\Internal\Logger as AppLog;
    use Vendor\PDFLibrary\Logger as PdfLog;
    
    $appLogging = new AppLog();
    $pdfLogging = new PdfLog();
    
    $output = ob_get_clean();
    
    // --- TEMPLATE REQUIREMENT WORKAROUND FOR MULTIPLE NAMESPACES --- 
    require_once __DIR__ . '/../includes/header.php';
    echo <<<HTML
    <div class="content-box">
        <h2>Aliasing to prevent Fatal Collisions</h2>
        <p>Using <code>as</code> to rename classes on the fly.</p>
    </div>
    
    <div class="success-box">
        <h3>System Boot Sequence:</h3>
        <ul>{$output}</ul>
    </div>
HTML;
    require_once __DIR__ . '/../includes/footer.php';
}
