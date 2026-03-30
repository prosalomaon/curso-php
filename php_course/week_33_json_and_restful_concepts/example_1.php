<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 33: Dependency Injection (S.O.L.I.D.)";

interface CacheInterface {
    public function set(string $key, $value): void;
    public function getName(): string;
}

class RedisCache implements CacheInterface {
    public function set(string $k, $v): void {}
    public function getName(): string { return "REDIS_IN_MEMORY_DAEMON"; }
}

class MemcachedCache implements CacheInterface {
    public function set(string $k, $v): void {}
    public function getName(): string { return "MEMCACHED_DAEMON"; }
}

// THE WRONG WAY (Hardcoded coupling)
class BadController {
    public function doWork() {
        $cache = new RedisCache(); // Hardcoded! Impossible to unit test with mock data.
    }
}

// THE RIGHT WAY (Injection)
class SecureController {
    private CacheInterface $cache;
    
    // The framework "injects" the cache engine from the outside.
    public function __construct(CacheInterface $cache) {
        $this->cache = $cache;
    }
    
    public function render() {
        return "Controller correctly utilizing: " . $this->cache->getName();
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
    <h2>Inversion of Control (IoC)</h2>
    <p>Classes should never instantiate their own heavy dependencies (like Databases, Mailers). They should ask for them in their Constructor.</p>
</div>

<div class="success-box">
    <strong>Execution Path:</strong> <?= htmlspecialchars($result) ?>
</div>

<div class="info-box">
    Since <code>SecureController</code> asks for a <code>CacheInterface</code>, we can swap from Memcached to Redis, or even to a fake <code>MockCache</code> for unit testing, without ever modifying the Controller's code at all!
</div>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.json.php" target="_blank">PHP Manual: JSON &amp; REST</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
header(&#039;Content-Type: application/json&#039;);
echo json_encode([&#039;status&#039; =&gt; &#039;success&#039;, &#039;data&#039; =&gt; []]);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>