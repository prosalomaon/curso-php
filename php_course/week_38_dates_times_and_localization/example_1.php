<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 38: Unit Testing (PHPUnit Integration)";

$testSubject = <<<PHP
class MathService {
    public function divide(float \$n, float \$d): float {
        if (\$d == 0) throw new InvalidArgumentException("Divisor zero zero constraint.");
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
        
        \$this->assertEquals(5.0, \$result); // Assertion
    }
    
    public function testDivisionByZeroRejects(): void {
        \$this->expectException(InvalidArgumentException::class);
        
        \$math = new MathService();
        \$math->divide(10, 0); // Will instantly trigger green if the exception fires!
    }
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Automated Code Verification logic</h2>
    <p>Professional devs do not refresh their browser to check if their code works. They write code that automatically checks their code.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Original File Engine</h3>
        <pre><?= htmlspecialchars($testSubject) ?></pre>
    </div>
    
    <div style="flex:1; border-left:4px solid green; padding-left:15px;">
        <h3 style="color:green;">PHPUnit Test Engine</h3>
        <pre><?= htmlspecialchars($unitTest) ?></pre>
    </div>
</div>

<div class="info-box" style="text-align:center;">
    <strong>Terminal Execution:</strong> <code>./vendor/bin/phpunit tests/</code> <br><br>
    <span style="background:#000; color:#0f0; padding:10px; font-family:monospace; display:inline-block;">OK (2 tests, 2 assertions)</span>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>