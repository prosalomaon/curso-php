<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 33: Injeção de Dependência (S.O.L.I.D.)";

interface CacheInterface {
    public function set(string $key, $value): void;
    public function getName(): string;
}

class RedisCache implements CacheInterface {
    public function set(string $k, $v): void {}
    public function getName(): string { return "DAEMON_MEMORIA_REDIS"; }
}

class MemcachedCache implements CacheInterface {
    public function set(string $k, $v): void {}
    public function getName(): string { return "DAEMON_MEMCACHED"; }
}

// O JEITO ERRADO (Acoplamento fixo)
class BadController {
    public function doWork() {
        $cache = new RedisCache(); // Fixo! Impossível de testar unitariamente com dados simulados (mock).
    }
}

// O JEITO CERTO (Injeção)
class SecureController {
    private CacheInterface $cache;
    
    // O framework "injeta" o mecanismo de cache pelo lado de fora.
    public function __construct(CacheInterface $cache) {
        $this->cache = $cache;
    }
    
    public function render() {
        return "Controlador utilizando corretamente: " . $this->cache->getName();
    }
}

$activeDriver = new MemcachedCache();
$controller = new SecureController($activeDriver);
$result = $controller->render();
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Inversão de Controle (IoC)</h2>
    <p>As classes nunca devem instanciar suas próprias dependências pesadas (como Bancos de Dados, Mailers). Elas devem solicitá-las em seu Construtor.</p>
</div>

<div class="success-box">
    <strong>Caminho de Execução:</strong> <?= htmlspecialchars($result) ?>
</div>

<div class="info-box">
    Como o <code>SecureController</code> solicita uma <code>CacheInterface</code>, podemos trocar de Memcached para Redis, ou até mesmo para um <code>MockCache</code> falso para testes unitários, sem nunca modificar o código do Controlador!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.json.php" target="_blank">Manual PHP: JSON e REST</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
header(&#039;Content-Type: application/json&#039;);
echo json_encode([&#039;status&#039; =&gt; &#039;success&#039;, &#039;data&#039; =&gt; []]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>