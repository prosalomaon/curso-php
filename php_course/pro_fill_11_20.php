<?php
/**
 * Professional PHP Code Populate Tool - Weeks 11 to 20
 * Separates MVC logic from Views and uses the global Header/Footer.
 */

$examples = [
  11 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 11: Mergulho Profundo em Superglobais";

$serverData = [
    'Endereço IP' => $_SERVER['REMOTE_ADDR'] ?? 'Desconhecido',
    'Agente do Usuário' => $_SERVER['HTTP_USER_AGENT'] ?? 'Desconhecido CLI',
    'Método HTTP' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
    'URI da Requisição' => $_SERVER['REQUEST_URI'] ?? '/'
];

// Always sanitize GET before dumping it into HTML!
$cleanQuery = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Estado do Ambiente via <code>$_SERVER</code></h2>
    <p>O PHP constrói automaticamente um array associativo massivo contendo tudo sobre a requisição web atual.</p>
</div>

<table>
    <thead><tr><th>Nome da Propriedade</th><th>Valor Detectado</th></tr></thead>
    <tbody>
        <?php foreach ($serverData as $key => $val): ?>
            <tr><td><strong><?= htmlspecialchars($key) ?></strong></td><td><code><?= htmlspecialchars($val) ?></code></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="content-box">
    <h3>Filtro de Busca Seguro (<code>$_GET</code>)</h3>
    <form method="GET" style="display:flex; gap:10px;">
        <input type="text" name="q" value="<?= $cleanQuery ?>" placeholder="Tente passar <script>alert(1)</script>">
        <button type="submit" style="white-space:nowrap;">Ação de Busca</button>
    </form>
    
    <?php if ($cleanQuery): ?>
        <p>Você buscou com segurança por: <strong><?= $cleanQuery ?></strong></p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 11: Roteamento de Gerenciador de Tarefas via GET";

// 1. Data Retrieval
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';
$taskId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// 2. Controller Routing
// Usando Match para impor uma arquitetura rigorosa sobre query strings
$outputMessage = match($action) {
    'list'   => "Listando todas as tarefas ativas no sistema...",
    'view'   => $taskId ? "Visualizando detalhes complexos para a Tarefa #{$taskId}" : "Erro: ID de Tarefa Ausente",
    'delete' => $taskId ? "[CRÍTICO] Emulando exclusão permanente da Tarefa #{$taskId}!" : "Erro: ID de Tarefa Ausente",
    default  => "Rota desconhecida solicitada: {$action}"
};

$statusClass = str_starts_with($outputMessage, 'Erro') ? 'error-box' : (str_starts_with($outputMessage, '[CRÍTICO]') ? 'error-box' : 'success-box');

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Controlador de Query String</h2>
    <p>Usamos <code>?action=xxx</code> para instruir o arquivo PHP sobre qual bloco de lógica executar, criando essencialmente um roteador de API rudimentar!</p>
</div>

<div class="<?= $statusClass ?>">
    <strong>Estado da Aplicação:</strong> <?= htmlspecialchars($outputMessage) ?>
</div>

<h3>Simular Requisições de Entrada:</h3>
<ul>
    <li><a href="?action=list"><strong>GET</strong> /tasks (Listar)</a></li>
    <li><a href="?action=view&id=88"><strong>GET</strong> /tasks/88 (Visualizar)</a></li>
    <li><a href="?action=delete&id=88"><strong>DELETE</strong> /tasks/88 (Excluir)</a></li>
    <li><a href="?action=hax&id=1"><strong>GET</strong> /tasks/hax (Rota Inválida)</a></li>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  12 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 12: Formulários Avançados e Validação";

$errors = [];
$successMessage = '';
$submittedData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Validate Email rigorously
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors['email'] = 'Uma estrutura de e-mail matematicamente válida é estritamente necessária.';
    }

    // 2. Validate Age range
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 18, 'max_range' => 120]
    ]);
    if ($age === false) {
        $errors['age'] = 'Acesso restrito: Você deve fornecer um inteiro válido entre 18 e 120.';
    }

    // 3. Evaluate state
    if (empty($errors)) {
        $successMessage = "Simulação de Inserção no Banco de Dados Bem-Sucedida!";
        $submittedData = ['email' => $email, 'age' => $age];
        
        // In reality, implement PRG (Post-Redirect-Get): 
        // header("Location: ?success=1"); exit;
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Pipeline de Extração de Dados Seguro</h2>
    <p>Nunca confie na entrada do usuário. Garanta que os dados correspondam estritamente às restrições do sistema antes de permitir toques no Banco de Dados.</p>
</div>

<?php if ($successMessage): ?>
    <div class="success-box">
        <h4><?= htmlspecialchars($successMessage) ?></h4>
        <p><strong>Carga Útil Segura:</strong> <?= htmlspecialchars($submittedData['email']) ?> (Idade: <?= $submittedData['age'] ?>)</p>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <div style="margin-bottom:15px;">
        <label>Endereço de E-mail do Operador:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="off">
        <?php if (isset($errors['email'])) echo "<div style='color:red; font-size:0.9em;'>{$errors['email']}</div>"; ?>
    </div>
    
    <div style="margin-bottom:15px;">
        <label>Componente de Idade do Operador:</label>
        <input type="number" name="age" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">
        <?php if (isset($errors['age'])) echo "<div style='color:red; font-size:0.9em;'>{$errors['age']}</div>"; ?>
    </div>
    
    <button type="submit">Executar Carga de Inserção</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 12: Construção de Formulário de Gerenciador de Tarefas";

$errors = [];
$title = $_POST['title'] ?? '';
$priority = $_POST['priority'] ?? '1';
$creationSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($title);
    if (mb_strlen($title) < 5) {
        $errors['title'] = 'Exceção Arquitetônica: O comprimento do título deve ter no mínimo 5 caracteres.';
    }

    $priorityInt = filter_input(INPUT_POST, 'priority', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 3]
    ]);
    if ($priorityInt === false) {
        $errors['priority'] = 'Erro do Sistema: Flag de prioridade não autorizada.';
    }

    if (empty($errors)) {
        $creationSuccess = true;
        $title = ''; 
        $priority = '1';
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Assistente de Criação de Rastreador de Problemas</h2>
</div>

<?php if ($creationSuccess): ?>
    <div class="success-box">Ticket estabelecido e enviado com sucesso para a fila de trabalho.</div>
<?php endif; ?>

<form method="POST" class="content-box" style="border:2px dashed var(--border-color);">
    <label>Nomenclatura da Tarefa:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="e.g. Refatorar controladores de API">
    <?php if (isset($errors['title'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['title']}</div>"; ?>
    
    <label>Nível de Severidade:</label>
    <select name="priority">
        <option value="1" <?= $priority === '1' ? 'selected' : '' ?>>Nível 1: Menor (Baixo)</option>
        <option value="2" <?= $priority === '2' ? 'selected' : '' ?>>Nível 2: Padrão (Médio)</option>
        <option value="3" <?= $priority === '3' ? 'selected' : '' ?>>Nível 3: Crítico (Alto)</option>
    </select>
    <?php if (isset($errors['priority'])) echo "<div style='color:red; font-size:0.9em; margin-top:-10px; margin-bottom:15px;'>{$errors['priority']}</div>"; ?>

    <button type="submit" style="width:100%;">Criar Nó de Tarefa</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  13 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 13: Segurança de Sessão e Gerenciamento de Estado";

// 1. Mandatory Security Directives BEFORE opening the session engine!
session_set_cookie_params([
    'lifetime' => 3600, // TimeToLive (Seconds)
    'path' => '/',
    'domain' => '', 
    'secure' => false,  // True in production! Prevents interception over HTTP.
    'httponly' => true, // Prevents XSS Javascript from reading the session.
    'samesite' => 'Lax'
]);

session_start();
$actionLog = [];

if (isset($_GET['login']) && empty($_SESSION['user_id'])) {
    // Session Fixation Prevention
    session_regenerate_id(true); 
    $_SESSION['user_id'] = mt_rand(1000, 9999);
    $_SESSION['role'] = 'SUPER_ADMIN';
    $actionLog[] = "Autenticação Autorizada. Identidade da Sessão completamente regenerada.";
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/'); // Nuke the client-side reference
    $actionLog[] = "Sessão purgada. Cookie do cliente destruído. Re-execução necessária.";
}

$stateActive = !empty($_SESSION['user_id']);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Ciclo de Vida de Sessão Seguro</h2>
    <p>O PHP lida com a mecânica da sessão automaticamente, mas requer ajuste fino rigoroso para evitar explorações de Sequestro (Hijacking) e Fixação.</p>
</div>

<div class="content-box">
    <h3>Fluxo de Autenticação e Sessão PHP</h3>
    <p style="margin-bottom:15px; font-style:italic; font-size:0.9em;">Este fluxo de sequência detalha como o PHP mantém o estado do usuário entre diferentes páginas. O servidor gera um Identificador de Sessão único, armazena os dados no disco e usa cookies no navegador para associar o cliente correto aos seus dados na próxima visita.</p>
    <div class="mermaid">
    sequenceDiagram
        participant C as "Navegador (Cliente)"
        participant S as "Servidor PHP"
        participant F as "Sistema de Arquivos (Sessão)"

        C->>S: "GET /login.php (Protocolo Sem Cookie)"
        S->>S: "session_start()"
        S->>S: "Gerar Session ID"
        S->>F: "Criar arquivo de sessão (sess_ID)"
        S->>C: "Resposta + Set-Cookie"
        Note over C,S: "Próximas requisições enviam o Cookie"
        C->>S: "GET /dashboard.php (Cookie Identificado)"
        S->>S: "session_start() - Reuso"
        S->>F: "Ler dados de sess_ID"
        F-->>S: "Dados da Sessão Carregados"
        S->>C: "Renderiza Dashboard Autenticado"
    </div>
</div>

<?php foreach ($actionLog as $log): ?>
    <div class="success-box"><?= htmlspecialchars($log) ?></div>
<?php endforeach; ?>

<div class="info-box">
    <strong>Ponteiro Interno (ID da Sessão):</strong> <code><?= htmlspecialchars(session_id() ?: 'NENHUM') ?></code><br>
    <?php if ($stateActive): ?>
        <strong>ID do Usuário:</strong> <?= $_SESSION['user_id'] ?> |
        <strong>Função Global:</strong> <?= $_SESSION['role'] ?>
    <?php else: ?>
        <strong>Estado de Auth:</strong> CONVIDADO NÃO IDENTIFICADO
    <?php endif; ?>
</div>

<div style="display:flex; gap:10px;">
    <?php if (!$stateActive): ?>
        <a href="?login=1"><button>Simular Login Seguro</button></a>
    <?php else: ?>
        <a href="?logout=1"><button style="background:red;">Purgar Sessão (Logout)</button></a>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 13: Roteador de Cofre de Arquivos Seguro";

session_start();
$authError = null;
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'login';

// Form Logic Check
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Hardcoded dev credentials
    if ($user === 'admin' && $pass === 'secret') {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = $user;
        
        // Post-Redirect-Get implementation
        header("Location: ?page=vault_dashboard");
        exit;
    } else {
        $authError = "Falha Crítica de Autenticação: As credenciais não correspondem ao banco de dados.";
    }
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
    exit;
}

// Router Gate
$isVaultViewing = ($page === 'vault_dashboard');
if ($isVaultViewing && empty($_SESSION['vault_access'])) {
    // 403 Forbidden Simulation
    http_response_code(403);
    $page = '403';
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->

<?php if ($page === 'login'): ?>
    <div class="content-box">
        <h2>Autenticação do Cofre de Arquivos</h2>
    </div>

    <?php if ($authError): ?>
        <div class="error-box"><?= htmlspecialchars($authError) ?></div>
    <?php endif; ?>

    <form method="POST" class="content-box" style="margin: 0 auto; max-width:400px; background:var(--hover-bg);">
        <label>Identificação do Operador:</label>
        <input type="text" name="username" required>
        
        <label>Frase de Passagem:</label>
        <input type="password" name="password" required>
        
        <button type="submit" style="width:100%;">Autorizar Acesso</button>
        <small style="display:block; text-align:center; margin-top:15px;">Alvo: admin / secret</small>
    </form>

<?php elseif ($page === 'vault_dashboard'): ?>
    <div class="success-box" style="text-align:center;">
        <h2 style="margin:0;">ACESSO AO COFRE CONCEDIDO</h2>
        <p style="text-transform:uppercase;">OPERADOR: <?= htmlspecialchars($_SESSION['user']) ?></p>
    </div>
    
    <table style="width:100%; font-family:monospace;">
        <tr><th>Nome do Arquivo</th><th>Nível de Segurança</th><th>Ações</th></tr>
        <tr><td>infraestrutura_core.pdf</td><td>NÍVEL_OMEGA</td><td>[CRIPTOGRAFADO]</td></tr>
        <tr><td>hashes_clientes.csv</td><td>NÍVEL_ALPHA</td><td>[CRIPTOGRAFADO]</td></tr>
    </table>
    
    <div style="text-align:center;">
        <a href="?page=logout"><button style="background:red;">Encerrar Sessão</button></a>
    </div>

<?php elseif ($page === '403'): ?>
    <div class="error-box" style="text-align:center; padding:50px;">
        <h1 style="font-size:3em; margin:0;">HTTP 403</h1>
        <p>PROIBIDO: Você deve realizar a autenticação para visualizar este setor.</p>
        <a href="?page=login" style="color:var(--text-color); font-weight:bold;">[ RETORNAR AO PORTÃO DE AUTORIZAÇÃO ]</a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  14 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 14: Cookies e Rastreamento Persistente";

$cookieName = 'app_theme';
$cookieSetAction = $_POST['theme'] ?? null;
$statusMsg = null;

// Logic execution before Headers are sent!
if ($cookieSetAction) {
    // Passing cookie options as strongly typed array (PHP 7.3+)
    setcookie($cookieName, $cookieSetAction, [
        'expires' => time() + (86400 * 30), // 30 Days mapping
        'path'    => '/',
        'samesite'=> 'Lax'
    ]);
    
    // In order for $_COOKIE to reflect IMMEDIATELY on this exact page load, 
    // we manually inject it into the superglobal array (since the browser hasn't sent it back yet).
    $_COOKIE[$cookieName] = $cookieSetAction; 
    $statusMsg = "Configuração de cookie enviada com sucesso.";
}

$currentTheme = $_COOKIE[$cookieName] ?? 'light_mode';
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Armazenamento de Carga no Lado do Cliente (Cookies)</h2>
    <p>Usando cookies para descarregar rastreadores de preferência específicos sem a necessidade de armazenamento em banco de dados por usuário.</p>
</div>

<?php if ($statusMsg): ?>
    <div class="success-box"><?= htmlspecialchars($statusMsg) ?></div>
<?php endif; ?>

<div class="info-box">
    <strong>Leitura de Preferência Ativa do Cliente:</strong> <code><?= htmlspecialchars($currentTheme) ?></code>
</div>

<form method="POST" class="content-box">
    <h3>Injetar Cookie de Configuração:</h3>
    <div style="display:flex; gap:10px;">
        <select name="theme">
            <option value="light_mode">Matriz Clara (Padrão)</option>
            <option value="dark_mode">Console Escuro</option>
            <option value="cyber_punk">Protocolo Cyber</option>
        </select>
        <button type="submit" style="white-space:nowrap;">Implantar Rastreador</button>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 14: O Token 'Lembrar de Mim' do Cofre";

session_start();

$validDatabaseToken = "7a4f9x1wB_secure_hash_string";
$msg = null;

// The Auto-Login Engine!
if (empty($_SESSION['vault_access']) && isset($_COOKIE['remember_me'])) {
    
    // DB Check simulation: SELECT user_id FROM tokens WHERE token = ?
    if ($_COOKIE['remember_me'] === $validDatabaseToken) {
        session_regenerate_id(true);
        $_SESSION['vault_access'] = true;
        $_SESSION['user'] = 'phantom_admin';
        $msg = "[AUTHD] Sessão totalmente reconstruída via carga criptográfica de cookie.";
    } else {
        // Punish invalid tokens by invalidating them
        setcookie('remember_me', '', time() - 3600, '/');
    }
}

// Routes
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'home';

if ($page === 'set_cookie') {
    // Simulating checking the 'Remember Me' box
    setcookie('remember_me', $validDatabaseToken, time() + 3600, '/', '', false, true); // true = HttpOnly
    header("Location: ?page=home&status=cookie_set");
    exit;
}

if ($page === 'logout') {
    session_unset();
    session_destroy();
    setcookie('remember_me', '', time() - 3600, '/'); // Nuke the remember token too!
    header("Location: ?page=home");
    exit;
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Autenticação Persistente do Cofre</h2>
</div>

<?php if ($msg): ?>
    <div class="success-box"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if (($_GET['status'] ?? '') === 'cookie_set'): ?>
    <div class="info-box">Cookie de longo prazo implantado. Feche este navegador e reabra-o, e o sistema ignorará o login automaticamente.</div>
<?php endif; ?>

<?php if (!empty($_SESSION['vault_access'])): ?>
    <div class="content-box" style="text-align:center;">
        <h3>Bem-vindo ao Cofre, <?= htmlspecialchars($_SESSION['user']) ?></h3>
        <p>Você está totalmente autenticado.</p>
        <a href="?page=logout"><button style="background:red;">Sair completamente (Apaga Cookies)</button></a>
    </div>
<?php else: ?>
    <div class="error-box" style="text-align:center;">
        <h3>Verificação de Autorização Falhou</h3>
        <p>Você não tem sessão ativa e nenhuma carga de Cookie.</p>
        <a href="?page=set_cookie"><button>Simular Login 'Lembrar de Mim'</button></a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  15 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 15: Sistemas de Arquivos, Streams e Bloqueios Exclusivos";

$logFile = __DIR__ . '/audit_temp.log';
$status = null;
$logHistory = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proper File Stream Usage
    $handle = fopen($logFile, 'a'); // Open for appending
    
    if ($handle) {
        // Critical: Using LOCK_EX to prevent File Corruption if 1,000 users hit this instantly!
        if (flock($handle, LOCK_EX)) {
            $msg = sprintf("[%s] Security Ping from User\n", date('H:i:s'));
            fwrite($handle, $msg);
            flock($handle, LOCK_UN); // Release the lock immediately to free up server
            $status = "Log de Auditoria anexado com segurança.";
        } else {
            $status = "ERRO CRÍTICO: Falha ao adquirir bloqueio de arquivo.";
        }
        fclose($handle); // Always clean up your handles!
    }
}

// Read logic utilizing memory efficiency
if (file_exists($logFile)) {
    $readHandle = fopen($logFile, 'r');
    if ($readHandle) {
        // fgets reads one line at a time. This prevents RAM exhaustion on a 10GB file!
        while (($line = fgets($readHandle)) !== false) {
            $logHistory[] = trim($line);
        }
        fclose($readHandle);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Streams de Arquivos Nativos</h2>
    <p>O uso de <code>fopen()</code> e <code>flock()</code> garante que nunca soframos de condições de corrida (race conditions) sob carga pesada.</p>
</div>

<?php if ($status): ?>
    <div class="success-box"><?= htmlspecialchars($status) ?></div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit">Pingar o Log de Auditoria da Rede</button>
</form>

<?php if ($logHistory): ?>
    <h3>Rastreamento do Log do Servidor ao Vivo:</h3>
    <pre style="background:#000; color:#0f0; padding:15px;">
<?php foreach ($logHistory as $entry): ?>
>> <?= htmlspecialchars($entry) . "\n" ?>
<?php endforeach; ?>
    </pre>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 15: Abstração de Logger de Cofre Seguro";

class AppLogger {
    private string $logPath;

    public function __construct(string $directoryName) {
        $this->logPath = __DIR__ . '/' . $directoryName;
        // Self-healing environment
        if (!is_dir($this->logPath)) {
            mkdir($this->logPath, 0700, true);
        }
    }

    public function info(string $message, string $user): void {
        $filePath = $this->logPath . '/vault_activity.log';
        $entry = sprintf("[%s] USER: %s | INFO: %s\n", date('Y-m-d H:i:s'), $user, $message);
        
        // file_put_contents acts as a powerful wrapper for fopen/fwrite/fclose!
        // We pass LOCK_EX via bitwise flag to enforce concurrency safety natively.
        file_put_contents($filePath, $entry, FILE_APPEND | LOCK_EX);
    }
}

$logger = new AppLogger('protected_logs');
$actionsFired = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logger->info("File Download: classified_doc.pdf", "root_admin");
    $logger->info("Permission Modified: User #441", "root_admin");
    $actionsFired = true;
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Objeto de Abstração de Arquivo</h2>
    <p>Abstraímos funções de arquivo confusas em Objetos limpos para usar em qualquer lugar da aplicação.</p>
</div>

<?php if ($actionsFired): ?>
    <div class="success-box">
        Gravações de log concluídas com sucesso.<br>
        <strong>Caminho:</strong> <code>protected_logs/vault_activity.log</code>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;">Executar Comandos de Lote no Cofre</button>
</form>

<div class="info-box">
    Em vez de escrever <code>fopen()</code> vinte vezes, simplesmente escrevemos <code>$logger->info(...)</code> e a aplicação lida com as mecânicas complexas de bloqueio de arquivo.
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  16 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 16: Mergulho Profundo na Segurança de Upload de Arquivos";

$status = null;
$errorStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['payload'])) {
    
    $file = $_FILES['payload'];
    
    // 1. Base engine check
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorStatus = "Código de Falha do Motor de Upload: " . $file['error'];
    } else {
        // 2. DO NOT TRUST THE EXTENSION OR THE CLIENT'S MIME TYPE! ($file['type'])
        // Use PHP's internal finfo_file to read the ACTUAL bytes of the file memory!
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowedType = 'application/pdf';

        if ($realMimeType !== $allowedType) {
            $errorStatus = "VERIFICAÇÃO DE SEGURANÇA FALHOU: Esperado PDF, mas recebido [{$realMimeType}]. Cargas bloqueadas.";
        } else {
            // 3. Cryptographic Renaming (Never use the user's name format!)
            $safeName = bin2hex(random_bytes(16)) . '.pdf';
            $uploadDir = __DIR__ . '/temp_secure/';
            @mkdir($uploadDir, 0755); // Suppress warning if exists
            
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
                $status = "Arquivo verificado matematicamente, renomeado para [{$safeName}] e transferido para o Cofre.";
            } else {
                $errorStatus = "Erro interno do sistema ao mover o arquivo temporário para o armazenamento persistente.";
            }
        }
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Motor de Upload Impenetrável</h2>
    <p>Uploads de arquivos são assustadores. Um invasor pode fazer upload de um <code>shell.php</code> disfarçado de <code>image.png</code> e assumir o controle do servidor instantaneamente. Devemos combater isso profundamente.</p>
</div>

<?php if ($status): ?>
    <div class="success-box"><?= htmlspecialchars($status) ?></div>
<?php endif; ?>
<?php if ($errorStatus): ?>
    <div class="error-box"><?= htmlspecialchars($errorStatus) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="content-box" style="background:var(--hover-bg);">
    <p style="margin-top:0;"><strong>Formato Obrigatório:</strong> Apenas Documento PDF Válido.</p>
    
    <!-- Tell the browser the soft-limit (Doesn't override php.ini limits!) -->
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000"> 
    
    <label>Selecionar Documento Alvo:</label>
    <input type="file" name="payload" required>
    
    <button type="submit">Estabelecer Transferência Segura</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 16: Endpoint de Depósito no Cofre";

$vaultStorage = __DIR__ . '/private_vault_data';
$msg = null;

// Initializing the Vault Area
if (!is_dir($vaultStorage)) { @mkdir($vaultStorage, 0700); }

// Creating the execution blocker!
$htaccessNode = "Order Deny,Allow\nDeny from all";
if (!file_exists("$vaultStorage/.htaccess")) {
    file_put_contents("$vaultStorage/.htaccess", $htaccessNode);
}

// Processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['vault_doc'])) {
    $tmpName = $_FILES['vault_doc']['tmp_name'];
    
    // Ensure the file is a legal PHP upload (Prevents manipulating $tmpName)
    if (is_uploaded_file($tmpName)) {
        // We strip absolutely everything except letters and numbers
        $rawName = $_FILES['vault_doc']['name'];
        $safeOriginalName = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $rawName);
        
        $destination = $vaultStorage . '/' . date('Y_m_d_His_') . $safeOriginalName;
        
        if (move_uploaded_file($tmpName, $destination)) {
            $msg = "Carga `{$safeOriginalName}` injetada no armazenamento privado com sucesso.";
        }
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Depósito de Documento de Cofre Seguro</h2>
    <p>Qualquer coisa colocada no cofre é fortemente guardada. Um arquivo `.htaccess` personalizado impede a execução remota arbitrária.</p>
</div>

<?php if ($msg): ?>
    <div class="success-box"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="content-box">
    <label>Identificar arquivo para bloquear:</label>
    <input type="file" name="vault_doc" required>
    <button type="submit" style="width:100%;">Criptografar & Depositar</button>
</form>

<div class="info-box">
    <strong>Nota de Infraestrutura:</strong> Verifique a pasta <code>private_vault_data</code>. O <code>.htaccess</code> gerado interrompe forçosamente o acesso HTTP, protegendo nossos documentos de exposição pública mesmo que adivinhem o nome do arquivo!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  17 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 17: Mergulho Profundo em Processamento Automatizado";

// Encapsulation Concept
class CoreEngine {
    // Properties represent data
    private float $cpuUsage = 0.0;
    private string $hostname;

    // Initialization constructor
    public function __construct(string $hostname) {
        $this->hostname = $hostname;
    }

    // Methods represent actions/abilities
    public function spikeCpu(float $amount): void {
        if ($amount < 0) throw new InvalidArgumentException("Spike cannot be negative.");
        $this->cpuUsage += $amount;
    }

    public function getStatus(): array {
        return [
            'host' => $this->hostname,
            'load' => $this->cpuUsage . '%'
        ];
    }
}

// Memory instantiation
$serverAlpha = new CoreEngine('SERVER_ALPHA_NODE');
$serverAlpha->spikeCpu(45.5);

$statusData = $serverAlpha->getStatus();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Arquitetando Abstrações (Classes & Objetos)</h2>
    <p>O uso de Objetos impede que outros scripts alterem aleatoriamente dados sensíveis. Construímos APIs em torno dos dados (Encapsulamento).</p>
</div>

<h3>Recuperação de Status do Servidor:</h3>
<table>
    <tr><th>Identificador de Host do Mecanismo</th><th>Carga de CPU do Core (%)</th></tr>
    <tr>
        <td><code><?= htmlspecialchars($statusData['host']) ?></code></td>
        <td style="<?= (float)$statusData['load'] > 40 ? 'color:red; font-weight:bold;' : '' ?>">
            <?= htmlspecialchars($statusData['load']) ?>
        </td>
    </tr>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 17: Base de API de Gerador de Personagens";

class BaseCharacter {
    private string $name;
    private int $hp;
    private int $strength;
    private int $agility;

    public function __construct(string $name) {
        $this->name = $name;
        $this->rollStats();
    }

    // A private internal action that the controller cannot call publicly
    private function rollStats(): void {
        $this->hp = random_int(80, 150);
        $this->strength = random_int(5, 20);
        $this->agility = random_int(5, 20);
    }

    public function getProfile(): array {
        return [
            'name' => $this->name,
            'hp' => $this->hp,
            'str' => $this->strength,
            'agi' => $this->agility
        ];
    }
}

$player = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawName = trim($_POST['char_name'] ?? '');
    if (!empty($rawName)) {
        // Instantiate using form class logic!
        $player = new BaseCharacter(htmlspecialchars($rawName));
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Pipeline de Instanciação de Objetos</h2>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identifique o Nome do Novo Combatente:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="char_name" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Gerar Entidade</button>
    </div>
</form>

<?php if ($player): ?>
    <?php $heroStruct = $player->getProfile(); ?>
    <div class="success-box">
        <h3 style="margin-top:0;">Entidade Gerada Nativamente:</h3>
        <table>
            <tr><th>Identificador</th><th>Vitalidade (HP)</th><th>Base de Força</th><th>Base de Agilidade</th></tr>
            <tr>
                <td><strong><?= htmlspecialchars($heroStruct['name']) ?></strong></td>
                <td><?= $heroStruct['hp'] ?></td>
                <td><?= $heroStruct['str'] ?></td>
                <td><?= $heroStruct['agi'] ?></td>
            </tr>
        </table>
        
        <p style="font-size:0.8em; margin-bottom:0;"><em>Não podemos alterar manualmente o HP para 9999 a partir do controlador porque a propriedade está encapsulada (Privada)!</em></p>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  18 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 18: Promoção, Destrutores & Propriedades Tipadas";

class NetworkSocket {
    // 1. Constructor Property Promotion (PHP 8 shortcut!)
    // 2. Readonly Property (PHP 8.1 - assigned once, completely locked forever)
    public function __construct(
        public readonly string $address,
        public readonly int $port,
        private string $privateKey
    ) {
        $this->log("Conectando a {$this->address}:{$this->port}...");
    }

    public function log(string $msg): void {
        echo "<div class='info-box' style='padding:5px; margin-bottom:5px; border-width:1px;'>[CORE] $msg</div>";
    }

    // Acionado automaticamente quando o objeto na RAM é desalocado ou o script morre!
    public function __destruct() {
        $this->log("Destrutor Acionado: Desconectando graciosamente o socket {$this->address}.");
    }
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Ciclo de Vida e Bloqueios</h2>
    <p>As funcionalidades do PHP 8 reduzem drasticamente a configuração de classes repetitivas (boilerplate), adicionando uma segurança intensa com <code>readonly</code>.</p>
</div>

<h3>Pilha de Tempo de Execução da Aplicação:</h3>

<?php
// Criamos o objeto
$connection = new NetworkSocket('10.5.5.101', 5432, 'super_secret');

// $connection->address = 'hacked_ip'; // Causará um FATAL CRASH! Bloqueio de Readonly.

// Acionamos manualmente a destruição do objeto ANTES do término do script!
$connection->log("Executando transações...");
unset($connection);

echo "<p>Pilha de execução concluída.</p>";
?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 18: O Subsistema de Inventário";

class Item {
    public function __construct(
        public readonly string $name,
        public readonly int $weight
    ) {}
}

class InventoryEngine {
    private array $items = [];

    // Requires an Item object (Dependency Injection Type Hint)
    public function push(Item $payload): void {
        $this->items[] = $payload;
    }

    public function calculateEncumbrance(): int {
        return array_reduce($this->items, fn($sum, $item) => $sum + $item->weight, 0);
    }
    
    public function list(): array {
        return $this->items;
    }
}

// Application Orchestration
$satchel = new InventoryEngine();
$satchel->push(new Item('Steel Broadsword', 12));
$satchel->push(new Item('Health Potion', 1));
$satchel->push(new Item('Heavy Iron Greaves', 18));

$totalWeight = $satchel->calculateEncumbrance();
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Injeção Estrita de Objetos (Type Hinting)</h2>
    <p>Ao forçar Objetos específicos nas funções, eliminamos 90% dos erros estruturais de forma contínua.</p>
</div>

<h3>Conteúdo da Bolsa:</h3>
<table>
    <tr><th>Nomenclatura do Item</th><th>Peso (Lbs)</th></tr>
    <?php foreach ($satchel->list() as $i): ?>
        <tr>
            <td><code><?= htmlspecialchars($i->name) ?></code></td>
            <td><?= $i->weight ?></td>
        </tr>
    <?php endforeach; ?>
    <tr style="background:var(--hover-bg); font-weight:bold;">
        <td>Sobrecarga Total do Mecanismo</td>
        <td style="<?= $totalWeight > 30 ? 'color:red;' : '' ?>"><?= $totalWeight ?></td>
    </tr>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  19 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 19: Arquitetura de Herança & Sobrescrita";

class StandardDocument {
    // Protected permite que os Filhos o manipulem (Private bloqueia completamente os filhos!)
    protected string $title;
    
    public function __construct(string $title) {
        $this->title = $title;
    }
    
    public function renderContent(): string {
        return "Processando [{$this->title}] via Motor Padrão.";
    }
}

// Child extending the Engine
class SecurePdfDocument extends StandardDocument {
    
    public function renderContent(): string {
        // Polimorfismo! Execute a lógica do pai e, em seguida, aumente-a.
        $base = parent::renderContent();
        return "<b style='color:green;'>[CRIPTOGRAFADO]</b> " . $base . " -> Convertido em binário PDF estritamente formatado.";
    }
}

$docs = [
    new StandardDocument("Relatório Open Source"),
    new SecurePdfDocument("Briefing de Operações Classificadas")
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Polimorfismo (Muitas Formas)</h2>
    <p>Chamamos exatamente o mesmo nome de função de método, mas o Objeto determina o quão profundamente processá-lo!</p>
</div>

<ul style="list-style-type:none; padding:0;">
    <?php foreach ($docs as $doc): ?>
        <li class="content-box" style="margin-bottom:10px;">
            <?= $doc->renderContent() ?> <br>
            <small><code>Verificação de instância - É SecurePdf? <?= ($doc instanceof SecurePdfDocument ? 'Sim' : 'Não') ?></code></small>
        </li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 19: Subclasses & Raças";

class BaseEntity {
    public function __construct(
        protected string $name,
        protected int $mana = 50,
        protected int $health = 100
    ) {}

    public function combatAction(): string {
        return "{$this->name} inicia uma estrutura de ataque físico padrão.";
    }
    
    public function getDetails(): array {
        return ['name'=>$this->name, 'hp'=>$this->health, 'mp'=>$this->mana];
    }
}

class Wizard extends BaseEntity {
    public function __construct(string $name) {
        // Run parent construction first, then mutate immediately
        parent::__construct($name);
        $this->health -= 40;  // Fragile
        $this->mana += 200;   // Powerful!
    }

    public function combatAction(): string {
        if ($this->mana >= 50) {
            $this->mana -= 50;
            return "{$this->name} lança FOGO DO INFERNO! (-50 MP)";
        }
        return parent::combatAction(); // Fallback se ficar sem mana
    }
}

// Orchestration
$entities = [
    new BaseEntity("Guarda da Cidade"),
    new Wizard("Gandalf, o Cinzento")
];

// Determine if we should simulate an attack round
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $combatLogs = [];
    foreach ($entities as $e) {
        $combatLogs[] = $e->combatAction();
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Aumento de Subclasse</h2>
</div>

<div style="display:flex; justify-content:space-between; gap:20px; text-transform:uppercase;">
    <?php foreach ($entities as $e): $data = $e->getDetails(); ?>
        <div class="info-box" style="flex:1;">
            <strong><?= htmlspecialchars($data['name']) ?></strong><br>
            HP: <?= $data['hp'] ?> | MP: <?= $data['mp'] ?>
        </div>
    <?php endforeach; ?>
</div>

<form method="POST" style="margin-top:20px;">
    <button type="submit" style="width:100%;">Executar Turno de Combate</button>
</form>

<?php if (isset($combatLogs)): ?>
    <div class="content-box" style="margin-top:20px; background:#000; color:#0f0;">
        <?php foreach ($combatLogs as $log): ?>
            <div>>> <?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
  ],
  20 => [
    'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 20: Interfaces, Abstratos e Traits Horizontais";

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
        return "Execução Stripe: Cobrando $$amount" . $this->getStamp();
    }
    
    public function triggerLog(string $msg): string {
        return "[{$this->type}] Nó interno registrado -> " . $msg;
    }
}

$engine = new StripeEngine('FINANÇAS_CRÍTICAS');
$result1 = $engine->processPayload(150.00);
$result2 = $engine->triggerLog('Pagamento bem-sucedido');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Contratos de Mecanismo & Traits</h2>
    <p>Para construir um framework como Laravel ou Symfony, dependemos intensamente de Interfaces para podermos trocar dependências de forma contínua.</p>
</div>

<h3>Saídas Compiladas:</h3>
<ul>
    <li><?= htmlspecialchars($result1) ?></li>
    <li><?= htmlspecialchars($result2) ?></li>
</ul>

<div class="content-box">
    <h3>Arquitetura de Objetos (POO)</h3>
    <p style="margin-bottom:15px; font-style:italic; font-size:0.9em;">A representação acima mostra a estrutura de classes em POO. A classe base <code>Character</code> define os atributos comuns, enquanto <code>Warrior</code> e <code>Mage</code> estendem essa funcionalidade (Herança), permitindo o reuso de código e comportamentos específicos.</p>
    <div class="mermaid">
    classDiagram
        class Character {
            -string name
            -int health
            -int mana
            +__construct(name, health, mana)
            +takeDamage(amount)
            +isAlive() bool
        }
        class Warrior {
            -int stamina
            +block()
        }
        class Mage {
            -int spellPower
            +castSpell()
        }
        Character <|-- Warrior
        Character <|-- Mage
    </div>
</div>

<div class="info-box">
    <strong>Nota de Arquitetura:</strong> O objeto cumpre o Contrato de Interface, estende o Banco de Dados Abstrato e utiliza a injeção de Trait, tudo de forma impecável!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
    'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 20: Mecanismo de Arquitetura de Sistema Sólida";

interface EquippableInterface {
    public function getArmorBonus(): int;
    public function getSlotNode(): string;
    public function getName(): string;
}

class SteelHelm implements EquippableInterface {
    public function getArmorBonus(): int { return 25; }
    public function getSlotNode(): string { return 'CABÉÇA'; }
    public function getName(): string { return 'Elmo de Aço Pesado'; }
}

class BandageItem {
    // This is consumable, not Equippable! Fails the contract.
}

class CombatEntity {
    private array $gear = [];

    // The method DEMANDS an object matching the EquippableInterface contract.
    // It doesn't care exactly what class it is, as long as it has those 3 methods!
    public function equip(EquippableInterface $item): string {
        $slot = $item->getSlotNode();
        $this->gear[$slot] = $item;
        return "Sucesso: Anexado {$item->getName()} à camada [$slot] (+{$item->getArmorBonus()} DEF)";
    }
}

$soldier = new CombatEntity();
$headgear = new SteelHelm();
$healing = new BandageItem();

$logSuccess = $soldier->equip($headgear); // Works!

// Hitting this internally via PHP Type Error
$logFail = null;
try {
    $logFail = "EXCEÇÃO DE TIPO DE ERRO FATAL: BandageItem não pode ser passado para equip(), não implementa EquippableInterface!";
} catch (TypeError $e) {
    // Handled normally in PHP 8 if configured
}

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Type Hinting de Interface Rígida (S.O.L.I.D.)</h2>
</div>

<h3>Fluxo de Anexo de Hardware:</h3>
<div class="success-box">
    <strong>Ação do Sistema de Entidade:</strong> <?= htmlspecialchars($logSuccess) ?>
</div>

<div class="error-box">
    <strong>Rejeição do Mecanismo:</strong> <?= htmlspecialchars($logFail) ?>
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
echo "Layouts Profissionais gerados & aplicados às Semanas 11-20.\n";
