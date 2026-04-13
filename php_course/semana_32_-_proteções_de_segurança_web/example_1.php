<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 32: Namespaces e PSR-4";

$codeSim = <<<PHP
<?php
// Arquivo: src/Controllers/UsuarioController.php
namespace App\\Controllers;

use App\\Models\\Usuario; // Importa a classe específica de outra pasta
use App\\Services\\Mailer;

class UsuarioController {
    public function registrar() {
        \$usuario = new Usuario(); // O PHP sabe exatamente onde este arquivo está!
        \$mail = new Mailer();
        
        // Classes nativas do PHP como DateTime devem ser precedidas por uma barra invertida!
        \$data = new \\DateTime(); 
    }
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mapeamento de Diretórios Nativamente (Namespacing)</h2>
    <p>Namespaces resolvem o problema de ter duas classes chamadas <code>Controller</code> no mesmo projeto. Eles mapeiam diretamente para sua estrutura física de pastas.</p>
</div>

<h3>Uso de Namespace:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    O uso de <code>use</code> no topo do arquivo evita que o código fique bagunçado. Em vez de escrever <code>$u = new \App\Models\Usuario()</code>, simplesmente escrevemos <code>$u = new Usuario()</code>.
</div>

<?php require_once __DIR__ . '/../includes/header.php'; ?>