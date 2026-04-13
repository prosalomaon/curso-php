<?php
/**
 * Professional PHP Code Populate Tool - Weeks 1 to 10
 * Separates MVC logic from Views. Includes sleek UI via header/footer.
 */

$examples = [
    1 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 1: Sintaxe & Arquitetura PHP";
$systemVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown CLI';
$currentDate = date('Y-m-d H:i:s');
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Bem-vindo ao Ambiente Profissional</h2>
    <p>O PHP nos dá uma flexibilidade incrível para interagir com a configuração do servidor dinamicamente.</p>
</div>

<div class="content-box">
    <h3>Arquitetura Cliente-Servidor PHP</h3>
    <p style="margin-bottom:15px; font-style:italic; font-size:0.9em;">Este diagrama ilustra o ciclo fundamental de uma requisição PHP: o cliente solicita uma página, o servidor processa o script executando lógica e consultas ao banco de dados, e finalmente devolve o HTML pronto para o navegador.</p>
    <div class="mermaid">
    flowchart LR
        A["Navegador (Cliente)"] -->|1. Requisição HTTP| B["Servidor Web (Apache/Nginx)"]
        B -->|2. Encaminha para| C["Interpretador PHP"]
        C -->|3. Executa Script| D[("Banco de Dados")]
        D -->|4. Retorna Dados| C
        C -->|5. Renderiza HTML| B
        B -->|6. Resposta HTTP| A
    </div>
</div>

<div class="info-box">
    <strong>Propriedades do Sistema Carregadas Separadamente:</strong>
    <ul>
        <li><strong>Versão do Motor PHP:</strong> <?= htmlspecialchars($systemVersion) ?></li>
        <li><strong>Servidor Web:</strong> <?= htmlspecialchars($serverSoftware) ?></li>
        <li><strong>Timestamp de Execução:</strong> <?= htmlspecialchars($currentDate) ?></li>
    </ul>
</div>

<p><em>Veja como este código-fonte é limpo comparado às instruções echo legadas!</em></p>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 1: Página de Bio Dinâmica";

// Initializing state for our frontend app
$profile = [
    'name' => 'Jane Doe',
    'profession' => 'Engenheira Backend Sênior',
    'skills' => ['PHP 8', 'Arquitetura', 'CSS Design', 'Modelagem de Dados'],
    'available_for_hire' => true
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2 style="font-size: 2em; margin-bottom: 0;"><?= htmlspecialchars($profile['name']) ?></h2>
    <p style="text-transform: uppercase; font-weight: bold; color: #555;"><?= htmlspecialchars($profile['profession']) ?></p>
    <hr>
    
    <h3>Competências Principais:</h3>
    <ul>
        <?php foreach ($profile['skills'] as $skill): ?>
            <li><?= htmlspecialchars($skill) ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($profile['available_for_hire']): ?>
        <div class="success-box">
            <strong>Disponível para Trabalho:</strong> Atualmente aceitando novos contratos de arquitetura.
        </div>
    <?php else: ?>
        <div class="error-box">
            <strong>Indisponível:</strong> Atualmente com a agenda lotada em grandes projetos.
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    2 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 2: Tipos Escalares & Memória no PHP 8";

$dataTypes = [
    ['type' => 'Inteiro', 'value' => 404, 'check' => is_int(404)],
    ['type' => 'Flutuante', 'value' => 3.14159, 'check' => is_float(3.14159)],
    ['type' => 'String', 'value' => "Dados Interpolados", 'check' => is_string("Interpolated Data")],
    ['type' => 'Booleano', 'value' => true, 'check' => is_bool(true)],
    ['type' => 'Nulo', 'value' => null, 'check' => is_null(null)]
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Layout de Memória e Escalares</h2>
    <p>O PHP usa o motor Zend Engine para alocar memória dinamicamente, mas devemos impor tipos estritos em bases de código profissionais para evitar falhas de coerção.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Nome do Tipo de Dado</th>
            <th>Valor Bruto do Script</th>
            <th>Verificação de Tipo Estrito Passou?</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataTypes as $var): ?>
        <tr>
            <td><strong><?= htmlspecialchars($var['type']) ?></strong></td>
            <td><code><?= htmlspecialchars(var_export($var['value'], true)) ?></code></td>
            <td><?= $var['check'] ? '<span style="color:green">SIM</span>' : '<span style="color:red">NÃO</span>' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 2: Desafio de Formulário Web App";
$message = null;
$error = null;

// Form Handling Logic MUST occur before headers/html
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedAnswer = trim($_POST['answer'] ?? '');
    
    // Strict typing logic evaluation
    if (strtolower($submittedAnswer) === 'elephant') {
        $message = "Correto! O mascote do PHP é de fato o elePHPant!";
    } else if (empty($submittedAnswer)) {
        $error = "Você deixou a resposta em branco!";
    } else {
        $error = "'{$submittedAnswer}' está incorreto. Pense em algo cinza e pesado.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Quiz Interativo para Desenvolvedores</h2>
    <p>Usando <code>$_POST</code> separado inteiramente do template da View!</p>
</div>

<?php if ($message): ?>
    <div class="success-box"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-box"><strong>Falha:</strong> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label for="answer"><strong>Pergunta:</strong> Qual animal é o mascote oficial da linguagem PHP?</label>
    <input type="text" id="answer" name="answer" placeholder="Digite sua resposta aqui..." autocomplete="off">
    
    <button type="submit">Validar Resposta</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    3 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 3: A Expressão Match & Estrito";

$httpCode = 404;

// A expressão 'match' do PHP 8 é mais limpa que o switch, retorna um valor e usa comparação estrita ===!
$responseMeaning = match($httpCode) {
    200, 201 => "Sucesso: O processamento da aplicação terminou graciosamente.",
    400 => "Erro do Cliente: Requisição Inválida gerada por entrada inválida.",
    403 => "Bloqueio de Segurança: O acesso é estritamente proibido.",
    404 => "Erro de Roteamento: Recurso ausente.",
    500 => "Falha Crítica na Infraestrutura.",
    default => "Status HTTP desconhecido."
};
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Manipulador de Resposta do Servidor</h2>
    <p>Avaliando códigos de servidor padrão usando a estrutura estrita <code>match()</code> do PHP 8+.</p>
</div>

<div class="info-box">
    <strong>Tráfego Simulado:</strong> Retornando HTTP <code><?= htmlspecialchars((string)$httpCode) ?></code><br>
    <strong>Diagnóstico do Sistema:</strong> <?= htmlspecialchars($responseMeaning) ?>
</div>

<h3>Perigos das Comparações Estritas vs Soltas</h3>
<table>
    <tr><th>Condição</th><th>Solta (==)</th><th>Estrita (===)</th></tr>
    <tr><td><code>"" == 0</code></td><td><span style="color:red">VERDADEIRO (Ruim)</span></td><td><span style="color:green">FALSO (Seguro)</span></td></tr>
    <tr><td><code>"123" == 123</code></td><td><span style="color:red">VERDADEIRO</span></td><td><span style="color:green">FALSO</span></td></tr>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 3: Portão de Segurança de Conteúdo";
$gateStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs via robust filters
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $subscribe = isset($_POST['subscribe']); // Checkbox presence

    if ($age === false) {
        $gateStatus = ['status' => 'error', 'msg' => 'Inteiro inválido fornecido para a idade.'];
    } elseif ($age < 18) {
        $gateStatus = ['status' => 'error', 'msg' => 'Acesso Negado: Você deve ter 18 anos ou mais para visualizar a rede profissional.'];
    } elseif (!$subscribe) {
        $gateStatus = ['status' => 'info', 'msg' => 'Acesso Concedido, mas por favor considere assinar nossa newsletter técnica!'];
    } else {
        $gateStatus = ['status' => 'success', 'msg' => 'Acesso Concedido: Bem-vindo, Membro Pro.'];
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Portão de Autenticação de Infraestrutura</h2>
    <p>Utilizando condicionais compostas e lógica booleana de forma segura.</p>
</div>

<?php if ($gateStatus): ?>
    <div class="<?= htmlspecialchars($gateStatus['status']) ?>-box">
        <?= htmlspecialchars($gateStatus['msg']) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <label><strong>Digite sua Idade:</strong></label>
    <input type="number" name="age" required min="1" max="120">
    
    <div style="margin-bottom: 20px;">
        <input type="checkbox" name="subscribe" id="sub" value="1">
        <label for="sub" style="font-weight:bold;">Inscrever-se na Newsletter Técnica Profissional (Concorda com os Termos)</label>
    </div>

    <button type="submit">Tentar Login</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    4 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 4: Tipagem Avançada e Funções";

/**
 * Calcula um desconto. Impõe tipos fortemente.
 * Usando Union Types (int|float) disponível desde o PHP 8.
 */
function applyDiscount(float|int $price, float $discountRate): float {
    if ($price < 0 || $discountRate < 0) {
        throw new InvalidArgumentException("Preços e taxas não podem ser negativos.");
    }
    return $price - ($price * $discountRate);
}

// Data Array for Views
$products = [
    ['name' => 'Servidor Corporativo', 'original' => 1500, 'rate' => 0.15],
    ['name' => 'Teclado Mecânico', 'original' => 200, 'rate' => 0.05],
    ['name' => 'E-Book de Algoritmos', 'original' => 45, 'rate' => 0.50],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Tipos de União e Matemática Estrita</h2>
    <p>O uso de <code>declare(strict_types=1)</code> garante que não haja passagem acidental de `"150"` (string) em vez de `150` (int) na pilha da aplicação.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Hardware / Ativo</th>
            <th>Preço Original</th>
            <th>Desconto Aplicado</th>
            <th>Custo Final</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
            <td>$<?= number_format((float)$p['original'], 2) ?></td>
            <td><?= $p['rate'] * 100 ?>% OFF</td>
            <td style="color: green; font-weight: bold;">
                $<?= number_format(applyDiscount($p['original'], $p['rate']), 2) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 4: Ferramenta de Formatação de String Personalizada";

$results = null;

/**
 * Uma função geradora semelhante a uma classe utilitária para limpar texto do usuário!
 */
function sanitizeAndFormatText(string $rawInput): array {
    $clean = strip_tags(trim($rawInput)); // Security: strip HTML
    return [
        'original' => $rawInput,
        'uppercase' => strtoupper($clean),
        'word_count' => str_word_count($clean),
        'slug' => strtolower(str_replace(' ', '-', $clean))
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['rawText'] ?? '';
    if (!empty($input)) {
        $results = sanitizeAndFormatText($input);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Pipeline de Formatação de Dados</h2>
    <p>Envie qualquer string bagunçada abaixo e veja o motor processá-la de forma limpa via funções separadas.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Cole o texto aqui (Tente adicionar HTML como &lt;b&gt;):</label>
    <textarea name="rawText" rows="4"></textarea>
    <button type="submit">Processar Texto</button>
</form>

<?php if ($results): ?>
    <h3>Pipeline de Saída:</h3>
    <table>
        <tr><th>Carga Original:</th><td><code><?= htmlspecialchars($results['original']) ?></code></td></tr>
        <tr><th>Transformação em Maiúsculas:</th><td><strong><?= htmlspecialchars($results['uppercase']) ?></strong></td></tr>
        <tr><th>Total de Palavras Processadas:</th><td><?= htmlspecialchars((string)$results['word_count']) ?></td></tr>
        <tr><th>Slug Amigável para URL:</th><td><code><?= htmlspecialchars($results['slug']) ?></code></td></tr>
    </table>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    5 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 5: Escopos, Referências e Estáticos";

$counterData = [];

// Variáveis estáticas LEMBRAM seu estado entre chamadas de função dentro da mesma execução de script!
function incrementCounter(string $label): int {
    static $calls = 0; 
    $calls++;
    return $calls;
}

// Usar referências (&) permite modificar variáveis diretamente na memória!
$globalTitle = "App Name";
function renameApp(string &$appRef, string $newName): void {
    $appRef = strtoupper($newName); 
}

$counterData[] = "Chamada 1 -> Retornou: " . incrementCounter("X");
$counterData[] = "Chamada 2 -> Retornou: " . incrementCounter("X");
$counterData[] = "Chamada 3 -> Retornou: " . incrementCounter("X");

$before = $globalTitle;
renameApp($globalTitle, "Awesome ETEC Platform");
$after = $globalTitle;

// --- END LOGIC ---
require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Estratégias de Modificação de Memória</h2>
</div>

<h3>Variáveis de Função Estáticas:</h3>
<p>Ao contrário das variáveis locais normais que reiniciam quando a função termina, <code>static</code> lembra seu valor.</p>
<pre>
<?php foreach ($counterData as $log): ?>
<?= htmlspecialchars($log) . "\n" ?>
<?php endforeach; ?>
</pre>

<h3>Passagem por Referência:</h3>
<p>Passar uma variável com <code>&amp;</code> permite que a função altere o espaço de memória da propriedade original.</p>
<table style="width:50%;">
    <tr><th>Estado Antes:</th><td><code><?= htmlspecialchars($before) ?></code></td></tr>
    <tr><th>Estado Depois:</th><td><strong><?= htmlspecialchars($after) ?></strong></td></tr>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
// We simulate cross-request global state using Sessions!
session_start();

$pageTitle = "Projeto Semana 5: Matriz de Escopo de Sessão Avançada";

// Setup state
if (!isset($_SESSION['player_score'])) {
    $_SESSION['player_score'] = 0;
}

$action = $_POST['action'] ?? '';

if ($action === 'score') {
    $_SESSION['player_score'] += 10;
} elseif ($action === 'reset') {
    $_SESSION['player_score'] = 0;
}

$currentScore = $_SESSION['player_score'];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Servidor de Escopo Persistente</h2>
    <p>Scripts PHP morrem quando a página carrega. Para manter os dados vivos globalmente entre as requisições, utilizamos <code>$_SESSION</code>.</p>
</div>

<div class="info-box" style="text-align: center;">
    <h3>ESTADO ATUAL DA APLICAÇÃO:</h3>
    <h1 style="font-size: 4em; margin:10px 0; color:var(--text-color);"><?= htmlspecialchars((string)$currentScore) ?></h1>
    <p>Seu ID de sessão: <code><?= htmlspecialchars(session_id()) ?></code></p>
</div>

<div style="display:flex; gap:10px; justify-content:center;">
    <form method="POST">
        <input type="hidden" name="action" value="score">
        <button type="submit" style="background:#155724; border-color:#155724;">+10 Pontos de Pontuação</button>
    </form>
    
    <form method="POST">
        <input type="hidden" name="action" value="reset">
        <button type="submit" style="background:#721c24; border-color:#721c24;">Reset Total do Sistema</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    6 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 6: Arrays Complexos & Desestruturação";

$frameworks = ['Laravel', 'Symfony', 'CodeIgniter'];
$authConfig = [
    'driver' => 'JWT',
    'lifetime' => 7200,
    'secure' => true,
    'routes' => ['/api/user', '/api/admin']
];

// Desestruturação de Array do PHP 7.1+! Sintaxe muito limpa.
[$fw1, $fw2] = $frameworks;

// Associative Destructuring
['driver' => $drv, 'lifetime' => $lt] = $authConfig;

// PHP 7.4+ Spread Operator (...)
$newFrameworks = ['Phalcon', ...$frameworks, 'Slim'];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Arquitetura Moderna de Arrays</h2>
    <p>Arrays são fundamentais no PHP. Vamos olhar para a desestruturação avançada.</p>
</div>

<h3>Desestruturação de Atribuição de Lista:</h3>
<div class="success-box">
    Capturado diretamente do layout de memória do array:<br>
    <strong>Primário:</strong> <?= htmlspecialchars($fw1) ?> <br>
    <strong>Secundário:</strong> <?= htmlspecialchars($fw2) ?> 
</div>

<h3>Variáveis de Mapa Extraídas:</h3>
<p>Variáveis <code>$drv</code> e <code>$lt</code> criadas instantaneamente a partir das chaves do mapa:</p>
<ul>
    <li>Motor de Driver: <strong><?= htmlspecialchars($drv) ?></strong></li>
    <li>Tempo de Vida da Sessão: <strong><?= htmlspecialchars((string)$lt) ?>s</strong></li>
</ul>

<h3>Mesclagem de Array Spread (...):</h3>
<pre><?= htmlspecialchars(print_r($newFrameworks, true)) ?></pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 6: Aplicativo de Lista de Tarefas";

// Simple state
$tasks = [
    'Patch de Erro Crítico',
    'Escrever API de Autenticação',
    'Design de Formulários de Login'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['new_task'])) {
    // Sanitize and append
    $safeTask = strip_tags(trim($_POST['new_task']));
    // Prepend to top of array
    array_unshift($tasks, $safeTask);
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Fila de Tarefas Volátil</h2>
    <p>Usando arrays para rastrear o estado (Reinicia ao atualizar, pois ainda não estamos usando Sessão ou Banco de Dados).</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Nova Solicitação de Funcionalidade do Sistema:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="new_task" style="margin-bottom:0;" autocomplete="off" required>
        <button type="submit" style="white-space:nowrap;">Enfileirar Tarefa</button>
    </div>
</form>

<h3>Fila do Sistema Pendente:</h3>
<ul>
    <?php foreach ($tasks as $index => $item): ?>
    <li style="padding:10px; border-bottom:1px dashed var(--border-color);">
        <code>[ID:<?= $index ?>]</code> <strong><?= htmlspecialchars($item) ?></strong>
    </li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    7 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 7: Arquitetura de Dados Multidimensionais";

// Simulating a parsed JSON API response
$databaseRaw = [
    '2023-10-01' => ['web' => 1200, 'ios' => 450, 'android' => 380],
    '2023-10-02' => ['web' => 1400, 'ios' => 500, 'android' => 410],
    '2023-10-03' => ['web' => 900, 'ios' => 300, 'android' => 310],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Inteligência de Tráfego Agregada</h2>
    <p>Usando mapeamento multidimensional para resumir terabytes de dados de log.</p>
</div>

<table>
    <thead>
        <tr><th>Timestamp</th><th>Rota Web</th><th>Rota iOS</th><th>Rota Android</th><th>Total do Dia</th></tr>
    </thead>
    <tbody>
        <?php foreach ($databaseRaw as $date => $metrics): ?>
        <tr>
            <td><code><?= $date ?></code></td>
            <td><?= number_format((float)$metrics['web']) ?></td>
            <td><?= number_format((float)$metrics['ios']) ?></td>
            <td><?= number_format((float)$metrics['android']) ?></td>
            <td><strong><?= number_format((float)array_sum($metrics)) ?></strong></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 7: Gerador de Matriz de Pixels";

$matrix = [];
$size = 8; // 8x8 Grid

for ($row = 0; $row < $size; $row++) {
    for ($col = 0; $col < $size; $col++) {
        // Gera um brilho aleatório para cada pixel
        $matrix[$row][$col] = rand(0, 255);
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Processamento de Matriz Aninhada</h2>
    <p>Útil para desenvolvimento de jogos, filtragem de imagem ou renderização de mapas de dados!</p>
</div>

<div style="display:grid; grid-template-columns: repeat(<?= $size ?>, 40px); gap:2px; justify-content:center; background:#000; padding:10px; border-radius:8px;">
    <?php foreach ($matrix as $row): ?>
        <?php foreach ($row as $pixel): ?>
            <div style="width:40px; height:40px; background:rgb(<?= "$pixel, 120, $pixel" ?>); border:1px solid rgba(255,255,255,0.1);"></div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<p style="text-align:center; margin-top:10px;"><em>Matriz 8x8 gerada dinamicamente via loops <code>for</code> aninhados.</em></p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    8 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 8: Algoritmos de Iteração (While vs Do-While)";

$backupNodes = ['Server-A', 'Server-B', 'Server-C'];
$statusLog = [];

// Exemplo While: Tentar até que a condição falhe (pode nunca rodar!)
while (!empty($backupNodes)) {
    $node = array_shift($backupNodes);
    $statusLog[] = "Sincronizando: $node... [CONCLUÍDO]";
}

// Exemplo Do-While: Roda pelo menos UMA VEZ!
$retryCount = 0;
$maxRetries = 3;
do {
    $retryCount++;
    $connectionResult = ($retryCount === 3) ? "ESTABELECIDA" : "FALHA";
    $statusLog[] = "Tentativa de Conexão #$retryCount: $connectionResult";
} while ($connectionResult !== "ESTABELECIDA" && $retryCount < $maxRetries);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Controle de Fluxo de Iteração</h2>
    <p>Escolher o laço correto impacta a segurança e performance da aplicação.</p>
</div>

<div class="info-box" style="font-family:monospace;">
    <?php foreach ($statusLog as $line): ?>
        <?= htmlspecialchars($line) ?><br>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 8: Gerador de Tabela de Multiplicação Pro";

$limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT) ?: 5;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Visualizador de Algoritmos Matemáticos</h2>
    <form method="GET">
        <label>Alterar tamanho da grade (Max 15):</label>
        <input type="number" name="limit" value="<?= $limit ?>" min="1" max="15">
        <button type="submit">Regerar Grade</button>
    </form>
</div>

<?php if ($limit > 0): ?>
    <table>
        <?php for ($row = 1; $row <= $limit; $row++): ?>
            <tr>
                <?php for ($col = 1; $col <= $limit; $col++): ?>
                    <?php 
                        $val = $row * $col;
                        $bg = ($row === $col) ? 'var(--hover-bg)' : 'transparent';
                        $color = ($row === $col) ? 'var(--text-color)' : 'inherit';
                    ?>
                    <td style="background:<?= $bg ?>; color:<?= $color ?>; border:1px solid var(--border-color); padding:5px;">
                        <?= $row ?>x<?= $col ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    9 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 9: Fluxo de Controle (Break & Continue)";

// Lista de simulação de timeout de rede
$networkRequests = [
    ['ip' => '192.168.1.1', 'status' => 'success', 'time' => 12],
    ['ip' => '192.168.1.2', 'status' => 'timeout', 'time' => 5000],
    ['ip' => '192.168.1.3', 'status' => 'success', 'time' => 15],
    ['ip' => '10.0.0.99', 'status' => 'FATAL_KERNEL_PANIC', 'time' => 0],
    ['ip' => '192.168.1.5', 'status' => 'success', 'time' => 10], // Won't be reached
];

$logs = [];
foreach ($networkRequests as $req) {
    if ($req['status'] === 'timeout') {
        $logs[] = "[AVISO] Pulando Servidor {$req['ip']} - Timeout.";
        continue; // Pula o resto deste bloco de loop singular, vai para o próximo!
    }
    
    if ($req['status'] === 'FATAL_KERNEL_PANIC') {
        $logs[] = "[CRÍTICO] Implantação total abortada devido a Kernel Panic em {$req['ip']}.";
        break; // Destrói o loop foreach inteiro instantaneamente!
    }
    
    $logs[] = "[OK] Pinging {$req['ip']} concluído em {$req['time']}ms.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Estrutura de Interrupção de Comandos</h2>
    <p>Controlando loops de grandes volumes de dados de forma graciosa.</p>
</div>

<h3>Log de Saída do Motor de Implantação:</h3>
<ul style="list-style-type:none; padding:0;">
    <?php foreach ($logs as $logStr): ?>
        <?php
            $color = 'var(--text-color)';
            if (str_contains($logStr, '[AVISO]')) $color = 'orange';
            if (str_contains($logStr, '[CRÍTICO]')) $color = 'red';
        ?>
        <li style="color:<?= $color ?>; font-weight:bold; margin-bottom:10px;">
            <?= htmlspecialchars($logStr) ?>
        </li>
    <?php endforeach; ?>
</ul>

<div class="error-box">Observe como <code>192.168.1.5</code> nunca foi pingado porque interrompemos o loop antecipadamente.</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 9: Protocolo de Busca de Segurança";

$userDatabase = [
    'alice@example.com', 'admin@example.com', 'bob@example.com', 
    'charlie@example.com', 'malory@example.com'
];

$searchTerm = $_POST['email'] ?? '';
$searchResult = null;
$searchedPaths = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    foreach ($userDatabase as $index => $email) {
        $searchedPaths++; // Acompanha quantas linhas olhamos
        
        if ($email === $searchTerm) {
            $searchResult = "Usuário ID #$index ENCONTRADO para $email";
            break; // OTIMIZAÇÃO IMEDIATA. Não verifica o resto do array!
        }
    }
    if (!$searchResult) $searchResult = "FALHA: Usuário $searchTerm não encontrado.";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Busca Otimizada em Array</h2>
    <p>Usando <code>break</code> para evitar ciclos desnecessários de CPU em protocolos de busca.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Encontrar E-mail de Usuário específico (Bob, Alice, Admin...):</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="email" required autocomplete="off">
        <button type="submit" style="white-space:nowrap;">Executar Verificação no Banco de Dados</button>
    </div>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <?php if (str_starts_with($searchResult, 'Usuário')): ?>
        <div class="success-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php else: ?>
        <div class="error-box"><?= htmlspecialchars($searchResult) ?></div>
    <?php endif; ?>
    
    <div class="info-box">
        <strong>Métricas do Motor:</strong> Pesquisou exatamente <strong><?= $searchedPaths ?></strong> linhas antes de parar a execução do algoritmo.<br>
        <em>Se não tivéssemos usado o break, ele teria varrido todas as 5 linhas todas as vezes!</em>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    10 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 10: Funções de Array de Ordem Superior";

// Dados Brutos da API
$prices = [10.50, 42.00, 5.25, 100.00];

// 1. array_map (Modificando cada elemento) -> Aplicando $5 de Frete para todos
$withShipping = array_map(fn($price) => $price + 5.00, $prices);

// 2. array_filter (Removendo elementos) -> Mantendo apenas itens acima de $20
$expensiveItems = array_filter($prices, fn($price) => $price > 20.00);

// 3. array_reduce (Resumindo em um único valor) -> Somando o total do carrinho
$cartTotal = array_reduce($prices, fn($carry, $price) => $carry + $price, 0.0);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Mecânica de Programação Funcional</h2>
    <p>O PHP tem funções de ordem superior incrivelmente poderosas que eliminam a necessidade de escrever loops <code>foreach</code> brutos manualmente.</p>
</div>

<div class="content-box">
    <h3>Hierarquia de Escopo e Memória</h3>
    <p style="margin-bottom:15px; font-style:italic; font-size:0.9em;">O diagrama acima visualiza como o PHP isola diferentes níveis de memória. O Escopo Global armazena dados persistentes e superglobais, enquanto o Escopo de Função garante que variáveis locais não interfiram em outras partes do sistema (isolamento).</p>
    <div class="mermaid">
    flowchart TD
        subgraph GlobalScope ["Escopo Global"]
            G1["globalVar"]
            G2["_SESSION"]
        end
        GlobalScope --> LocalScope
        subgraph LocalScope ["Escopo da Função"]
            Iso["Isolamento"]
            L1["localVar"]
            L2["Parâmetros"]
            S1["static keepState"]
        end
        style LocalScope fill:#e1f5fe,stroke:#01579b,stroke-width:2px
    </div>
</div>

<table>
    <tr><th>Preços Brutos ($)</th><th>Mapa (+5 Frete)</th><th>Filtro (Apenas > $20)</th></tr>
    <tr>
        <td><pre><?= htmlspecialchars(print_r($prices, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($withShipping, true)) ?></pre></td>
        <td><pre><?= htmlspecialchars(print_r($expensiveItems, true)) ?></pre></td>
    </tr>
</table>

<div class="success-box" style="text-align: center;">
    <h3>Total Final Reduzido do Carrinho:</h3>
    <h1>$<?= number_format($cartTotal, 2) ?></h1>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 10: Filtros de Banco de Dados Complexos";

// Simulação de SQL Joins complexos em um array de arquitetura
$tasks = [
    ['id' => 1, 'priority' => 'high', 'completed' => true, 'tag' => 'auth'],
    ['id' => 2, 'priority' => 'low', 'completed' => false, 'tag' => 'ui'],
    ['id' => 3, 'priority' => 'high', 'completed' => false, 'tag' => 'database'],
    ['id' => 4, 'priority' => 'medium', 'completed' => false, 'tag' => 'auth'],
];

// Encadeando: Encontrar todas as tarefas INCOMPLETAS e então pegar APENAS seus nomes de TAG como uma lista limpa!
$pendingTasks = array_filter($tasks, fn($t) => !$t['completed']);
$pendingTags  = array_map(fn($t) => strtoupper($t['tag']), $pendingTasks);

// Tornar as tags únicas usando outra função nativa
$uniquePendingTags = array_unique($pendingTags);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<div class="content-box">
    <h2>Arquitetura de Pipeline de Dados</h2>
    <p>Em arquiteturas altamente avançadas, encadeamos ações de filtro/mapa para isolar fatias exatas de dados de estruturas complexas.</p>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    
    <div class="content-box" style="flex:1;">
        <h3>Estrutura de Dados Original:</h3>
        <pre><?= htmlspecialchars(var_export($tasks, true)) ?></pre>
    </div>
    
    <div class="info-box" style="flex:1;">
        <h3>Saída de Pipeline Acionável:</h3>
        <p>O sistema precisa saber quais departamentos devem trabalho. Filtramos as tarefas concluídas, agrupamos suas chaves e removemos duplicatas instantaneamente de forma nativa:</p>
        
        <ul style="margin-top:20px;">
            <?php foreach ($uniquePendingTags as $deptCode): ?>
                <li style="font-weight:bold; color:red; margin-bottom:10px;">
                    TRABALHO PENDENTE NO MÓDULO: [<?= htmlspecialchars($deptCode) ?>]
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ]
];

$dirs = array_filter(glob(__DIR__ . '/semana_*'), 'is_dir');
foreach ($dirs as $dir) {
    preg_match('/semana_0*(\d+)/', basename($dir), $matches);
    if (!isset($matches[1])) continue;
    $weekNum = (int)$matches[1];
    if (isset($examples[$weekNum])) {
        $refs = require __DIR__ . '/references_data.php';
        $refData = $refs[$weekNum] ?? ['url' => 'https://www.php.net/manual/pt_BR/', 'title' => 'Documentação Oficial', 'snippet' => '// Snippet personalizado'];
        
        $injectionHtml = '
<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="' . htmlspecialchars($refData['url']) . '" target="_blank">Manual do PHP: ' . htmlspecialchars($refData['title']) . '</a></li>
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
echo "Layouts Profissionais gerados & aplicados às Semanas 1-10.\n";
