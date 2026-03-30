<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 38: Testes Unitários (Integração PHPUnit)";

$testSubject = <<<PHP
class MathService {
    public function divide(float \$n, float \$d): float {
        if (\$d == 0) throw new InvalidArgumentException("Restrição de divisor zero.");
        return \$n / \$d;
    }
}
PHP;

$unitTest = <<<PHP
use PHPUnit\\Framework\\TestCase;

class MathServiceTest extends TestCase {
    
    public function testDivisionCalculatesCleanly(): void {
        \$math = new MathService();
        \$result = \$math->divide(10, 2);
        
        \$this->assertEquals(5.0, \$result); // Asserção
    }
    
    public function testDivisionByZeroRejects(): void {
        \$this->expectException(InvalidArgumentException::class);
        
        \$math = new MathService();
        \$math->divide(10, 0); // Ativará instantaneamente o verde se a exceção for disparada!
    }
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Lógica de Verificação de Código Automatizada</h2>
    <p>Desenvolvedores profissionais não atualizam o navegador para verificar se o código funciona. Eles escrevem código que verifica automaticamente o seu código.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Mecanismo do Arquivo Original</h3>
        <pre><?= htmlspecialchars($testSubject) ?></pre>
    </div>
    
    <div style="flex:1; border-left:4px solid green; padding-left:15px;">
        <h3 style="color:green;">Mecanismo de Teste PHPUnit</h3>
        <pre><?= htmlspecialchars($unitTest) ?></pre>
    </div>
</div>

<div class="info-box" style="text-align:center;">
    <strong>Execução no Terminal:</strong> <code>./vendor/bin/phpunit tests/</code> <br><br>
    <span style="background:#000; color:#0f0; padding:10px; font-family:monospace; display:inline-block;">OK (2 testes, 2 asserções)</span>
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.datetime.php" target="_blank">Manual PHP: Datas e Horários</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
$dt = new DateTime();
echo $dt-&gt;format(&#039;Y-m-d H:i:s&#039;);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>