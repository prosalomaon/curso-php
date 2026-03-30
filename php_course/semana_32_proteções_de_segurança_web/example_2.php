<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 32: Resolução de Colisão de Namespace";

// Cenário simulado: Você baixou uma biblioteca PDF e ela tem uma classe 'Logger'.
// Mas seu aplicativo TAMBÉM tem uma classe 'Logger'!

namespace App\Internal {
    class Logger {
        public function __construct() { echo "<li>Logger Interno do App Iniciado</li>"; }
    }
}

namespace Vendor\PDFLibrary {
    class Logger {
        public function __construct() { echo "<li>Logger de Pacote Externo Iniciado</li>"; }
    }
}

namespace App\Execution {
    $title = "Manipulação de Colisão de Namespace";
    
    // Lidamos com a lógica manualmente aqui devido à forma como os namespaces isolam a execução
    ob_start();
    // Usando aliases para corrigir exatamente o mesmo Nome!
    use App\Internal\Logger as AppLog;
    use Vendor\PDFLibrary\Logger as PdfLog;
    
    $appLogging = new AppLog();
    $pdfLogging = new PdfLog();
    
    $output = ob_get_clean();
    
    // --- SOLUÇÃO PARA REQUISITOS DE TEMPLATE COM MÚLTIPLOS NAMESPACES --- 
    require_once __DIR__ . '/../includes/header.php';
    echo <<<HTML
    <div class="content-box">
        <h2>Aliasing para evitar Colisões Fatais</h2>
        <p>Usando <code>as</code> para renomear classes rapidamente.</p>
    </div>
    
    <div class="success-box">
        <h3>Sequência de Inicialização do Sistema:</h3>
        <ul>{$output}</ul>
    </div>
HTML;
    require_once __DIR__ . '/../includes/footer.php';
}
