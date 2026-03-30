<?php
/**
 * Professional PHP Code Populate Tool - Weeks 31 to 40
 * Focus: Advanced Architecture, APIs, Caching, and Enterprise Polish.
 */

$examples = [
  31 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 31: Ecossistema Composer (Gerenciador de Pacotes)";

$terminalSimulation = <<<BASH
> composer init
  Criando ./composer.json

> composer require ramsey/uuid
  Baixando 100%
  Gerando vendor/autoload.php

> php index.php
  Sistema Carregado.
BASH;

$composerJson = <<<JSON
{
    "name": "etec/php-profissional",
    "description": "Projeto Final: Do Zero ao Senior",
    "require": {
        "php": "^8.2",
        "guzzlehttp/guzzle": "^7.8",
        "vlucas/phpdotenv": "^5.6"
    },
    "autoload": {
        "psr-4": {
            "App\\\\": "src/"
        }
    }
}
JSON;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>O Paradigma <code>vendor/autoload.php</code></h2>
    <p>Não precisamos mais escrever <code>require_once 'classe.php'</code> cinquenta vezes por arquivo. O Composer verifica automaticamente nossas pastas e carrega as classes de forma idêntica ao <code>npm</code> do Node.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Simulação de CLI</h3>
        <pre><?= htmlspecialchars($terminalSimulation) ?></pre>
    </div>
    <div style="flex:1;">
        <h3>Configuração <code>composer.json</code></h3>
        <pre><?= htmlspecialchars($composerJson) ?></pre>
    </div>
</div>

<div class="success-box">
    Ao executar <code>require 'vendor/autoload.php';</code> no topo do seu <code>index.php</code>, absolutamente todas as classes dentro do seu diretório <code>src/</code> tornam-se disponíveis globalmente de forma automática com base nas regras PSR-4!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 31: Array Gerador de UUID";

// Simulamos a utilização de 'ramsey/uuid' do packagist
class SimulatedUuid {
    public static function uuid4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

$generated = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 0; $i < 5; $i++) {
        $generated[] = SimulatedUuid::uuid4();
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mockup de Integração de Terceiros</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <h3>Gerar 5 Nós de Identidade Aleatórios para Banco de Dados:</h3>
    <button type="submit" style="width:100%;">Executar Geração</button>
</form>

<?php if ($generated): ?>
    <div class="info-box">
        <strong>Em vez de inteiros básicos de auto-incremento (1, 2, 3),</strong> sistemas modernos usam UUIDs por segurança para evitar que hackers percorram perfis de usuário (ex: <code>/usuarios/4</code>).
    </div>
    
    <ul style="list-style-type:none; padding:0;">
        <?php foreach ($generated as $key => $uuid): ?>
            <li class="content-box" style="margin-bottom:10px; font-family:monospace; font-size:1.2em; border-color:var(--text-color);">
                <strong>[UUID_<?= $key ?>]</strong> <?= htmlspecialchars($uuid) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  32 => [
    'ex1' => <<<'EOT'
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
EOT,
    'ex2' => <<<'EOT'
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

EOT
  ],
  33 => [
    'ex1' => <<<'EOT'
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 33: Sistema de E-mail Modular";

interface MailDriver {
    public function transmit(string $body): string;
}

class SmtpDriver implements MailDriver {
    public function transmit(string $b): string { return "[Servidor SMTP] Carga enviada: $b"; }
}

class MailgunApiDriver implements MailDriver {
    public function transmit(string $b): string { return "[API HTTP Mailgun] JSON postado: $b"; }
}

class NotificationService {
    public function __construct(private MailDriver $mailer) {}
    
    public function alertAdmin(): string {
        return $this->mailer->transmit("CPU DO SERVIDOR > 95%");
    }
}

$driverChoice = $_POST['driver'] ?? 'smtp';
$log = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Resolução de Dependência
    $driver = ($driverChoice === 'api') ? new MailgunApiDriver() : new SmtpDriver();
    
    // 2. Injeção!
    $service = new NotificationService($driver);
    
    // 3. Execução
    $log = $service->alertAdmin();
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Hot-Swapping de Drivers Dinamicamente</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Selecione o Mecanismo de Transporte de E-mail Mestre:</label>
    <div style="display:flex; gap:10px;">
        <select name="driver">
            <option value="smtp">Mecanismo SMTP Legado (Lento)</option>
            <option value="api">Protocolo API REST Externo (Rápido)</option>
        </select>
        <button type="submit" style="white-space:nowrap;">Executar</button>
    </div>
</form>

<?php if ($log): ?>
    <div class="success-box">
        <h4>Ação do Sistema Concluída:</h4>
        <code><?= htmlspecialchars($log) ?></code>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  34 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 34: Try/Catch e Propagação de Exceções";

$log = [];

class DatabaseException extends Exception {}
class ValidationException extends Exception {}

function attemptFragileOperation(bool $failDb, bool $failVal) {
    if ($failVal) throw new ValidationException("O usuário forneceu dados de entrada incorretos.");
    if ($failDb) throw new DatabaseException("O mecanismo MySQL ficou offline inesperadamente.");
    
    return "Operação bem-sucedida!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $failDb = isset($_POST['fail_db']);
    $failVal = isset($_POST['fail_val']);
    
    try {
        $log[] = "Tentando operação...";
        $result = attemptFragileOperation($failDb, $failVal);
        $log[] = "RESULTADO: " . $result;
        
    } catch (ValidationException $e) {
        $log[] = "[CAPTURADO] Erro de Lógica de Negócios: " . $e->getMessage();
        
    } catch (DatabaseException $e) {
        $log[] = "[CAPTURADO] Erro de Infraestrutura: " . $e->getMessage();
        // Aqui você normalmente registraria no Monolog e avisaria o DevOps!
        
    } catch (Exception $e) {
        // O fallback definitivo para qualquer outra coisa
        $log[] = "[FATAL] Falha desconhecida: " . $e->getMessage();
        
    } finally {
        $log[] = "Bloco Finally Executado: Limpando RAM/Arquivos independente de sucesso ou falha.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Lidando com Falhas Catastróficas</h2>
    <p>O uso de Exceções Personalizadas permite direcionar o tráfego quando os scripts explodem nativamente, evitando as telas brancas da morte.</p>
</div>

<form method="POST" class="content-box" style="display:flex; flex-direction:column; gap:10px;">
    <div>
        <input type="checkbox" id="v" name="fail_val" value="1"> 
        <label for="v">Simular Dados de Usuário Inválidos (Erro Suave)</label>
    </div>
    <div>
        <input type="checkbox" id="d" name="fail_db" value="1"> 
        <label for="d">Simular Queda de Rede do Banco de Dados (Crash Grave)</label>
    </div>
    <button type="submit">Executar Bloco de Execução</button>
</form>

<?php if ($log): ?>
    <ul class="content-box" style="background:#000; color:#0f0; padding:20px; list-style-type:none;">
        <?php foreach ($log as $l): ?>
            <li style="margin-bottom:5px;">>> <?= htmlspecialchars($l) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 34: Abstração Monolog";

$codeSim = <<<PHP
use Monolog\\Logger;
use Monolog\\Handler\\StreamHandler;

// Criar um pipeline de log central
\$log = new Logger('MecanismoApp');
\$log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::WARNING));

try {
    throw new Exception("Cache completamente desconectado!");
} catch (Exception \$e) {
    // Registra apenas WARNING e superior (ERROR, CRITICAL, EMERGENCY)
    \$log->error("Interrupção do Sistema: " . \$e->getMessage(), [
        'ip' => \$_SERVER['REMOTE_ADDR']
    ]);
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Registro Padronizado (PSR-3)</h2>
    <p>Em vez de <code>file_put_contents()</code> manual, toda a indústria utiliza <code>Monolog</code> para transmitir erros diretamente para o Slack, Disco ou AWS CloudWatch!</p>
</div>

<h3>Código de Implementação:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>Níveis de Log:</strong> DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY. Diferentes manipuladores podem ser anexados simultaneamente (ex: Salvar tudo no disco, mas enviar e-mail para a equipe APENAS em EMERGENCY).
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  35 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
// Simulamos fisicamente uma requisição de API aqui interceptando a saída
if (isset($_GET['api']) && $_GET['api'] === 'fetch') {
    ob_end_clean(); // Apaga qualquer buffer de saída HTML instantaneamente
    header('Content-Type: application/json; charset=utf-8');
    
    $payload = [
        'metadata' => ['status' => 200, 'timestamp' => time()],
        'data' => [
            ['id' => 10, 'username' => 'sys_admin', 'tier' => 'gold'],
            ['id' => 11, 'username' => 'ghost_user', 'tier' => 'basic']
        ]
    ];
    
    echo json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    exit; // PARA TODA A EXECUÇÃO PARA QUE NENHUM HTML SEJA CARREGADO!
}

$pageTitle = "Semana 35: Construindo APIs JSON";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Renderizando Saída JSON Pura Nativamente</h2>
    <p>O PHP alimenta APIs globais perfeitamente apenas alterando os cabeçalhos de resposta e interrompendo a saída HTML.</p>
</div>

<div class="info-box">
    <a href="?api=fetch" style="color:#0c5460; font-weight:bold;">
        [ CLIQUE AQUI PARA VER A CARGA ÚTIL DA API NO NAVEGADOR ]
    </a>
</div>

<h3>Arquitetura Necessária:</h3>
<pre>
header('Content-Type: application/json; charset=utf-8');
echo json_encode($dadosArray);
exit;
</pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 35: CORS e Rate Limiting";

$codeSim = <<<PHP
// 1. Mapa de Compartilhamento de Recursos de Origem Cruzada (CORS)
header("Access-Control-Allow-Origin: https://aplicativo-vue-frontend.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 2. Manipulação de requisição OPTIONS pre-flight (Navegadores enviam isso antes de POSTar)
if (\$_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 3. Exemplo de Restrição de Rate Limiting (Geralmente via Redis)
\$hits = checkRedisHits(\$_SERVER['REMOTE_ADDR']);
if (\$hits > 60) {
    header("Retry-After: 60");
    http_response_code(429); // Too Many Requests
    echo json_encode(['error' => 'Limite de Requisições Excedido.']);
    exit;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Segurança de Infraestrutura de API</h2>
    <p>Devemos instruir manualmente o navegador se um site estrangeiro (como um aplicativo Vue.js ou React) tem permissão legal para buscar dados do nosso servidor PHP.</p>
</div>

<h3>Implementação de Gateway Seguro:</h3>
<pre><?= htmlspecialchars($codeSim) ?></pre>

<div class="info-box">
    <strong>HTTP 429:</strong> Nunca deixe os usuários em loop infinito em uma requisição de API. Implementar Rate Limiting matematicamente protege seu banco de dados contra ataques DDoS!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  36 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 36: Consumindo APIs Externas";

// Usaremos stream_context como alternativa ao cURL para buscas básicas!
$resultData = null;
$errorLog = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = "https://jsonplaceholder.typicode.com/posts/1"; // API fake pública
    
    // Configurando a configuração HTTP nativamente no PHP sem cURL
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: EtecPHPProfissional/1.0\r\n" .
                        "Accept: application/json\r\n",
            'timeout' => 5
        ]
    ];
    
    $context = stream_context_create($options);
    
    // O @ suprime avisos para que possamos capturá-los de forma limpa para a UI
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        $errorLog = "Falha na Rede: Não foi possível conectar de forma limpa à API Typicode.";
    } else {
        // Decodificamos com segurança para um Array Associativo (argumento true)
        $resultData = json_decode($response, true);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Busca via Stream Context (Busca no servidor)</h2>
    <p>O PHP pode agir como o "Navegador", conectando-se a outros serviços (Stripe, Twilio) a partir do backend de forma privada.</p>
</div>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;">Buscar Endpoint HTTPS Externo Nativamente</button>
</form>

<?php if ($errorLog): ?>
    <div class="error-box"><?= htmlspecialchars($errorLog) ?></div>
<?php endif; ?>

<?php if ($resultData): ?>
    <div class="success-box">
        <h3>Carga Útil Decodificada:</h3>
        <table>
            <tr><th>Identificador</th><td><?= $resultData['id'] ?></td></tr>
            <tr><th>Título do Recurso</th><td><?= htmlspecialchars($resultData['title']) ?></td></tr>
            <tr><th>Corpo do Conteúdo</th><td><?= htmlspecialchars($resultData['body']) ?></td></tr>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 36: Carga cURL Avançada de Extranete";

$curlCode = <<<PHP
\$ch = curl_init("https://api.stripe.com/v1/charges");

// Configurar carga cURL massiva
curl_setopt_array(\$ch, [
    CURLOPT_RETURNTRANSFER => true, // Retorna dados em vez de imprimir!
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['amount' => 2000, 'currency' => 'brl']),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer sk_test_chaveSecreta123", /* JWT ou Bearer Auth */
        "Accept: application/json"
    ],
    CURLOPT_TIMEOUT => 10,
]);

\$apiResult = curl_exec(\$ch);

if(curl_errno(\$ch)) {
    throw new Exception("Erro Crítico cURL: " . curl_error(\$ch));
}

\$httpCode = curl_getinfo(\$ch, CURLINFO_HTTP_CODE);
curl_close(\$ch);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mecanismo de Infraestrutura Client URL (cURL)</h2>
    <p>Para comunicação complexa de API (OAuth, tokens JWT Bearer, formulários multipart), o cURL fornece controle estrutural absoluto de baixo nível.</p>
</div>

<h3>Mapeamento de Configuração Mock:</h3>
<pre><?= htmlspecialchars($curlCode) ?></pre>

<div class="info-box">
    No PHP 8+ moderno, desenvolvedores frequentemente instalam o <strong>GuzzleHTTP</strong> via Composer, que envolve totalmente a lógica confusa de <code>curl_setopt</code> em métodos Orientados a Objetos bonitos (<code>$client->post('/charges', ['json' => $data]);</code>).
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  37 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 37: Variáveis de Ambiente (.env)";

$envMock = <<<ENV
APP_NAME="Etec Pro Framework"
APP_ENV=production
APP_DEBUG=false

DB_HOST=127.0.0.1
DB_PORT=3306
DB_USER=root
DB_PASS=C0mpl3xP@ss!
ENV;

// Simulando a função nativa getenv do PHP (na qual o $_ENV se baseia)
$mockEnvVars = [
    'APP_ENV' => 'production',
    'DB_HOST' => '127.0.0.1'
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Configuração de Ambiente de App 12-Factor</h2>
    <p>Senhas nunca devem ser digitadas nos arquivos da base de código PHP. Nós as lemos implicitamente do Sistema Operacional Hospedeiro usando arquivos `.env`.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Conteúdo do Arquivo <code>.env</code></h3>
        <pre><?= htmlspecialchars($envMock) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Lógica de Extração</h3>
        <pre>
$env = $_ENV['APP_ENV'] ?? 'local';
$host = getenv('DB_HOST');

if ($env === 'production') {
    // Ocultar impressão de erros nativa!
    ini_set('display_errors', '0');
}
        </pre>
    </div>
</div>

<div class="error-box">
    <strong>CRÍTICO:</strong> Arquivos <code>.env</code> devem obrigatoriamente ser listados no <code>.gitignore</code>! Nunca envie estruturas de banco de dados para o GitHub!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 37: Arquiteturas de Implantação (Deployment)";

// Representação conceitual
$deployFlow = <<<BASH
#!/bin/bash
# 1. Obter a arquitetura de código mais recente com segurança
git pull origin main

# 2. Reconstruir a injeção de dependência do Composer
composer install --no-dev --optimize-autoloader

# 3. Sincronizar tabelas de banco de dados para o mapeamento exato de migrações
php artisan migrate --force

# 4. Cachear configurações nativamente para um enorme aumento de velocidade
php artisan config:cache

# 5. Esvaziar o mecanismo externo OPCACHE
systemctl reload php-fpm
BASH;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Ciclo de Vida de Implantação Zero-Downtime</h2>
    <p>Enviar código via FTP é obsoleto. Implantamos utilizando scripts especializados de nível de servidor que representam consistência absoluta.</p>
</div>

<h3>Gancho de Script Shell de Produção</h3>
<pre><?= htmlspecialchars($deployFlow) ?></pre>

<div class="info-box">
    <strong>Flag do Composer:</strong> O <code>--no-dev</code> impede que o servidor baixe pacotes de teste (como PHPUnit), mantendo a pegada extremamente rápida e isolada estritamente à lógica de negócios!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  38 => [
    'ex1' => <<<'EOT'
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 38: Desenvolvimento Orientado por Testes (TDD)";

$conceptText = <<<TEXT
1. RED: Escreva o teste exato PRIMEIRO! Execute-o. Veja-o falhar porque nenhum código existe nativamente ainda.
2. GREEN: Escreva a quantidade mínima de código PHP necessária para passar no nó de verificação.
3. REFACTOR: Limpe a arquitetura do código com segurança, verificando se os testes ainda passam.
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Fluxo de Trabalho de Desenvolvimento Orientado por Testes (TDD)</h2>
</div>

<h3>Matriz de Configuração do Ciclo TDD</h3>
<pre><?= htmlspecialchars($conceptText) ?></pre>

<div class="success-box">
    Escrever testes inicialmente parece lento. Mas conforme seu sistema cresce para milhares de linhas, alterar 1 método fundamental leva 5 segundos de teste, em vez de uma semana inteira de verificação manual de QA!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  39 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 39: Caching de Aplicação Agressivo";

// Mecanismo de Simulação de Cache de Arquivo
$cacheFile = __DIR__ . '/api_cache.json';
$cacheValidForSeconds = 30; 

$wasCached = false;
$apiData = [];

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheValidForSeconds) {
    // 1. Obter diretamente do Cache. Evitar o Banco de Dados inteiramente!
    $cachedData = file_get_contents($cacheFile);
    $apiData = json_decode($cachedData, true);
    $wasCached = true;
} else {
    // 2. Cache Expirado! Re-calcular a lógica pesadamente.
    // Simulando lógica de consulta pesada (ex: JOINing 5 tabelas)
    sleep(1); 
    
    $apiData = [
        'generated_at' => date('H:i:s'),
        'total_active_users' => 45000,
        'sales_volume' => 125000.50
    ];
    
    // 3. Salvar no Arquivo de Cache para o próximo visitante
    file_put_contents($cacheFile, json_encode($apiData));
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Ignorando a Execução de Custo de CPU (Memoização)</h2>
    <p>Ao enviar agregações de banco de dados para um arquivo JSON físico (ou Memória Redis), os próximos 10.000 usuários carregam o site instantaneamente em vez de sobrecarregar o Banco de Dados!</p>
</div>

<div style="display:flex; justify-content:space-between; align-items:center; background:#f4f4f4; padding:20px; border-radius:5px;">
    
    <div style="text-align:center;">
        <h1 style="<?= $wasCached ? 'color:green;' : 'color:red;' ?>">
            <?= $wasCached ? '⚡ CACHE HIT (0.01s)' : '🐢 CACHE MISS/EXPIRADO (1.10s)' ?>
        </h1>
        <p>Atualize a página várias vezes para observar o comportamento do cache resolvendo automaticamente para arquivos.</p>
    </div>
    
    <div>
        <h3>Nó de Dados Recuperado:</h3>
        <pre><?= htmlspecialchars(print_r($apiData, true)) ?></pre>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 39: Cache Busting";

// Configuração simulada
$appVersion = "v2.1.4"; // Incrementar isso força resets de CSS imediatamente de forma global
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Invalidação de Cache no Lado do Cliente</h2>
</div>

<h3>Aplicando Timestamp / Strings de Versão em Ativos Estáticos:</h3>
<pre>
&lt;!-- RUIM: O navegador armazena em cache por 30 dias para sempre! --&gt;
&lt;link rel="stylesheet" href="/style.css"&gt;

&lt;!-- BOM: Usando mapeamento de versão estrutural --&gt;
&lt;link rel="stylesheet" href="/style.css?v=<?= htmlspecialchars($appVersion) ?>"&gt;

&lt;!-- MELHOR: Usando o mapeamento exato do tempo de modificação do arquivo --&gt;
&lt;link rel="stylesheet" href="/style.css?time=<?= filemtime(__DIR__ . '/../style.css') ?>"&gt;
</pre>

<div class="info-box">
    O uso de <code>filemtime()</code> resolve os problemas de cache de CSS/JS de forma elegante. No momento em que você salva o arquivo CSS fisicamente, o número muda, destruindo o cache do navegador do usuário nativamente!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  40 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 40: Tokens CSRF e Polimento Final";

session_start();

// 1. Gerar Token CRSF de forma segura se ele não existir
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$status = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    
    // 2. Validar o token exatamente via comparação segura contra ataques de tempo (timing attack)!
    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        http_response_code(403);
        $status = "PROIBIDO: Incompatibilidade de Token de Segurança. Execução de sequestro CSRF suspeita bloqueada.";
    } else {
        $status = "SUCESSO: Perfil atualizado com segurança.";
        // Redefinir o token para que ele não possa ser reutilizado!
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mitigação de Cross-Site Request Forgery (CSRF)</h2>
    <p>Injetamos um token oculto em CADA formulário. Se um site malicioso enganar seu navegador para enviar um formulário para seu servidor, eles não saberão o token aleatório exato, então a requisição falha na validação nativamente!</p>
</div>

<?php if ($status): ?>
    <div class="<?= str_starts_with($status, 'SUCESSO') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($status) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <!-- INJEÇÃO DE CONSTANTE OCULTA -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    
    <label>Modificar Configuração do Nó de Perfil:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="data" value="Alguns Dados de Layout Seguros" autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Executar</button>
    </div>
    
    <div style="margin-top:10px; font-size:0.8em;">
        <strong>Carga Útil Injetada Oculta:</strong> <code><?= htmlspecialchars($_SESSION['csrf_token']) ?></code>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 40: Revisão Final de Todo o Currículo";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box" style="text-align:center; padding-top:40px; padding-bottom:40px;">
    
    <h1 style="font-size:3em; margin-bottom:0;">Do Zero ao Senior: PHP</h1>
    <h3 style="color:var(--text-color); margin-top:10px; text-transform:uppercase;">Saída do Currículo Validada com Sucesso</h3>
    
    <hr style="width:50%; margin:30px auto;">
    
    <ul style="list-style-type:none; padding:0; display:inline-block; text-align:left;">
        <li style="margin-bottom:10px;">✔️ Fase 1: Saída do Mecanismo e Algoritmos Básicos</li>
        <li style="margin-bottom:10px;">✔️ Fase 2: Estruturas de Array e Paradigmas Funcionais</li>
        <li style="margin-bottom:10px;">✔️ Fase 3: Limites Arquiteturais S.O.L.I.D.</li>
        <li style="margin-bottom:10px;">✔️ Fase 4: Máquinas de Estado MVC e Bancos de Dados</li>
        <li style="margin-bottom:10px;">✔️ Fase 5: Criptografia, Identidade e Escalonamento</li>
    </ul>

</div>

<div class="success-box" style="text-align:center;">
    Você agora está equipado com os padrões de design exatos que alimentam nativamente <strong>Laravel</strong>, <strong>Symfony</strong> e <strong>Plataformas Empresariais</strong> em todo o mundo.
</div>

<div style="text-align:center; margin-top:30px;">
    <a href="/php_course/index.php"><button style="padding:15px 30px; font-size:1.2em;">Retornar ao Diretório de Índice Principal</button></a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ]
];

$dirs = array_filter(glob(__DIR__ . '/semana_*'), 'is_dir');
foreach ($dirs as $dir) {
  preg_match('/semana_0*(\d+)/', basename($dir), $matches);
  if (!isset($matches[1]))
    continue;
  $weekNum = (int) $matches[1];
    if (isset($examples[$weekNum])) {
        $refs = require __DIR__ . '/references_data.php';
        $refData = $refs[$weekNum] ?? ['url' => 'https://www.php.net/manual/pt_BR/', 'title' => 'Documentação Oficial', 'snippet' => '// Snippet personalizado'];
        
        $injectionHtml = '
<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="' . htmlspecialchars($refData['url']) . '" target="_blank">Manual PHP: ' . htmlspecialchars($refData['title']) . '</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>' . htmlspecialchars($refData['snippet']) . '</code></pre>
</div>
';

        $footerRequire = "<?php require_once __DIR__ . '/../includes/footer.php'; ?>";
        
        $ex1 = str_replace($footerRequire, $injectionHtml . "\n" . $footerRequire, $examples[$weekNum]['ex1']);
        $ex2 = str_replace($footerRequire, $injectionHtml . "\n" . $footerRequire, $examples[$weekNum]['ex2']);

        file_put_contents($dir . '/example_1.php', $ex1);
        file_put_contents($dir . '/example_2.php', $ex2);
    }
}
echo "Layouts Profissionais gerados & aplicados às Semanas 31-40.\n";
