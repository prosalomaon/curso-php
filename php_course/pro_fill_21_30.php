<?php
/**
 * Professional PHP Code Populate Tool - Weeks 21 to 30
 * Focus: Database (PDO) and MVC Integrations with Professional Layouts.
 */

$examples = [
    21 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 21: Esquemas de Banco de Dados Relacionais";

$schemaCode = <<<SQL
CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    funcao ENUM('USUARIO', 'ADMIN') DEFAULT 'USUARIO',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT,
    CONSTRAINT fk_post_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;
SQL;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Padronização MySQL / MariaDB</h2>
    <p>O PHP depende de designs de esquema de banco de dados sólidos. Use InnoDB e codificação utf8mb4 para suportar totalmente formatos Unicode modernos (como emojis) e Restrições Estrangeiras.</p>
</div>

<h3>Arquitetura Fundamental 1-para-Muitos</h3>
<pre><?= htmlspecialchars($schemaCode) ?></pre>

<div class="info-box">
    <strong>Integridade Relacional:</strong> O <code>ON DELETE CASCADE</code> instrui o mecanismo do banco de dados a apagar instantaneamente todos os <code>posts</code> pertencentes a um usuário se o ID do usuário for excluído, evitando "Registros Órfãos" de forma segura, sem intervenção do PHP.
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 21: Bootstrap de Banco de Dados de Blog";

$tables = [
    'categorias' => "
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
)",
    'artigos' => "
CREATE TABLE artigos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NULL,
    titulo VARCHAR(200) NOT NULL,
    corpo TEXT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
)"
];

$simulatedLogs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($tables as $name => $query) {
        $simulatedLogs[] = "Nó de destino migrado: [{$name}]";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mecanismo de Bootstrap de Esquema CMS</h2>
</div>

<?php if ($simulatedLogs): ?>
    <div class="content-box" style="background:#000; color:#0f0;">
        <?php foreach ($simulatedLogs as $log): ?>
            <div>>> <?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
        <div style="margin-top:10px; color:yellow;">Sistema configurado para inserção PDO com sucesso.</div>
    </div>
<?php endif; ?>

<form method="POST" class="content-box">
    <button type="submit" style="width:100%;" <?= $simulatedLogs ? 'disabled' : '' ?>>Executar Migrações do Sistema</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    22 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 22: Arquiteturas PDO Avançadas";

// Criando um mock seguro para evitar travamentos em bancos de dados locais ausentes neste ambiente de demonstração
class SafeMockPDO {
    public function getAttribute($attr) {
        return "STRICT_EXCEPTION_MODE";
    }
}

$dsn = "mysql:host=localhost;dbname=test_db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// $pdo = new PDO($dsn, 'root', '', $options);
$pdo = new SafeMockPDO(); 
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Configuração de PHP Data Objects (PDO)</h2>
    <p>O uso do lendário Padrão Singleton garante que sua aplicação abra exatamente 1 conexão com seu Banco de Dados por carregamento de página, em vez de 50!</p>
</div>

<div class="success-box">
    Conectividade de Banco de Dados Configurada.<br>
    <strong>Modo de Erro:</strong> <?= htmlspecialchars($pdo->getAttribute('mock')) ?><br>
    <strong>Modo de Busca:</strong> FETCH_ASSOC (Arrays Associativos)
</div>

<div class="info-box">
    <strong>Verificação de Segurança Obrigatória:</strong> <code>PDO::ATTR_EMULATE_PREPARES</code> deve ser definido como <code>false</code> para forçar o mecanismo MySQL real a preparar as consultas nativamente (Melhor segurança contra injeção).
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 22: Abstrações de Busca PDO";

class SimulatedStatement {
    public function fetchAll(int $mode = PDO::FETCH_ASSOC): array {
        if ($mode === PDO::FETCH_OBJ) {
            return [(object)['id'=>1, 'titulo'=>'Arquitetura do Mecanismo PDO']];
        }
        return [['id'=>1, 'titulo'=>'Arquitetura do Mecanismo PDO']];
    }
}

$stmt = new SimulatedStatement();
$assocOutput = $stmt->fetchAll(PDO::FETCH_ASSOC);
$objOutput = $stmt->fetchAll(PDO::FETCH_OBJ);

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mecanismo de Formato de Recuperação</h2>
</div>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div style="flex:1;">
        <h3>Arrays Padrão (FETCH_ASSOC)</h3>
        <p>Mapeamento de hash de array ultra-rápido.</p>
        <pre><?= htmlspecialchars(print_r($assocOutput, true)) ?></pre>
    </div>
    
    <div style="flex:1;">
        <h3>Objetos Anônimos (FETCH_OBJ)</h3>
        <p>Sintaxe <code>$row->titulo</code> mais limpa aplicada nativamente.</p>
        <pre><?= htmlspecialchars(print_r($objOutput, true)) ?></pre>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    23 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 23: Bindings e Defesa contra Injeção SQL";

$userId = $_GET['id'] ?? '1 OR 1=1; DROP TABLE usuarios;';

$safeExample = <<<PHP
\$stmt = \$pdo->prepare("UPDATE usuarios SET status = :status WHERE id = :usuario_id");

// O execute vincula os valores perfeitamente, fechando a brecha de injeção explicitamente.
\$stmt->execute([
    'usuario_id' => \$userId,
    'status'  => 'ativo'
]);
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Prepared Statements (O Escudo Supremo)</h2>
    <p>Injeção SQL é a vulnerabilidade nº 1 na web. Nós a eliminamos permanentemente separando a estrutura lógica do SQL das variáveis de dados do usuário usando <code>prepare()</code>.</p>
</div>

<div class="error-box">
    <strong>Carga Útil Maliciosa Detectada em $_GET:</strong><br>
    <code><?= htmlspecialchars($userId) ?></code>
</div>

<div class="success-box">
    Usando <strong>Bindings Nomeados</strong> (<code>:variable</code>), a string maliciosa acima é tratada puramente como uma string literal pelo mecanismo do banco de dados, não causando danos.
</div>

<h3>Código de Implantação:</h3>
<pre><?= htmlspecialchars($safeExample) ?></pre>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 23: Mecanismo de Busca de Artigos Seguro";

$searchTerm = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$simulatedResults = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchTerm)) {
    // 1. O curinga % deve ser anexado no PHP, não na instrução SQL bruta!
    $boundVariable = '%' . $searchTerm . '%';
    
    // 2. Simulação de execução de DB
    $simulatedResults = [
        ['id' => 44, 'titulo' => "Dominando a Arquitetura de {$searchTerm}"],
        ['id' => 99, 'titulo' => "Implantando {$searchTerm} na AWS"]
    ];
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Mapeamento de Integração WILDCARD</h2>
    <p>Usando <code>LIKE</code> com PDO.</p>
</div>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Buscar no Banco de Dados do Blog:</label>
    <div style="display:flex; gap:10px;">
        <input type="text" name="query" required autocomplete="off" placeholder="Tente buscar 'PHP'">
        <button type="submit" style="white-space:nowrap;">Executar Consulta</button>
    </div>
</form>

<?php if ($simulatedResults !== null): ?>
    <h3>Saída do Banco de Dados (0.012s):</h3>
    <ul>
        <?php foreach ($simulatedResults as $row): ?>
            <li><strong>[Artigo #<?= $row['id'] ?>]</strong> <?= htmlspecialchars($row['titulo']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <div class="info-box" style="margin-top:20px;">
        <strong>Nos bastidores, SQL executado com segurança:</strong><br>
        <code>SELECT * FROM artigos WHERE titulo LIKE :query</code><br>
        <em>Vinculado <code>:query</code> para <code>"<?= htmlspecialchars('%' . $searchTerm . '%') ?>"</code></em>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    24 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 24: Conformidade ACID e Transações de Banco de Dados";

$transactionCode = <<<PHP
try {
    \$pdo->beginTransaction();

    // Deduzir dinheiro da Conta A
    \$pdo->exec("UPDATE contas SET saldo = saldo - 100 WHERE id = 1");
    
    // Adicionar dinheiro à Conta B
    \$pdo->exec("UPDATE contas SET saldo = saldo + 100 WHERE id = 2");

    \$pdo->commit(); // Salvar todas as alterações atomicamente

} catch (Exception \$e) {
    \$pdo->rollBack(); // Em QUALQUER erro, reverter todo o lote!
    throw \$e;
}
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>A Rede de Segurança <code>rollBack()</code></h2>
    <p>O que acontece se um script falha no meio da transferência de R$ 10.000 de um usuário para outro? Corrupção de dados. Transações corrigem isso instantaneamente.</p>
</div>

<h3>Bloco de Código de Consistência Atômica:</h3>
<pre><?= htmlspecialchars($transactionCode) ?></pre>

<div class="info-box">
    Ao implantar lógica que toca em várias tabelas de banco de dados simultaneamente (ex: criar um Usuário E atribuir-lhe um Perfil), envolva-a nativamente em uma Transação PDO!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 24: Fluxos de Trabalho de Exclusão Segura";

$articleId = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);
$currentUserId = 1; // Sessão simulada
$log = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $articleId) {
    // Fase de Simulação do Estágio 1: Verificação
    $ownerCheckPassed = ($articleId !== 999); // 999 simula um artigo que não pertence ao usuário
    
    if (!$ownerCheckPassed) {
        $log = "ERRO: Você não tem autorização para excluir o Artigo #$articleId.";
    } else {
        // Fase de Simulação do Estágio 2: Execução
        $log = "SUCESSO: Artigo #$articleId e todas as Tags associadas foram completamente apagados do Banco de Dados.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Impondo Propriedade no DELETE</h2>
    <p>Se você não verificar <code>WHERE autor_id = :uid</code> dentro de suas consultas de exclusão, hackers simplesmente alteram o ID para apagar os dados de outra pessoa!</p>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCESSO') ? 'success-box' : 'error-box' ?>">
        <?= htmlspecialchars($log) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="border-color:red;">
    <label>Selecione o Artigo Alvo para Exclusão:</label>
    <div style="display:flex; gap:10px;">
        <select name="delete_id">
            <option value="55">Artigo Normal #55 (Pertence a Você)</option>
            <option value="999">Dados Restritos #999 (Tentativa de Invasão Simulada)</option>
        </select>
        <button type="submit" style="background:red;">Executar Exclusão Permanente</button>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    25 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 25: SQL JOINs e Otimização do Sistema";

$querySyntax = <<<SQL
SELECT 
    usuarios.username, 
    COUNT(posts.id) as total_posts 
FROM usuarios 
LEFT JOIN posts ON usuarios.id = posts.usuario_id 
GROUP BY usuarios.id;
SQL;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Relacionamentos de Banco de Dados acima de loops (Crise N+1)</h2>
    <p>Executar Consultas SQL dentro de um loop <code>foreach</code> do PHP é fortemente proibido em produção. Em vez disso, usamos a sintaxe SQL <code>JOIN</code> para obter dados interconectados instantaneamente!</p>
</div>

<h3>Recuperação de Dados Agregados (Contar total de posts por usuário)</h3>
<pre><?= htmlspecialchars($querySyntax) ?></pre>

<div class="info-box">
    Esta lógica é executada puramente dentro da RAM do MySQL/MariaDB em 3 milissegundos, em vez de o PHP sobrecarregar a rede com milhares de solicitações de conexão separadas nativamente!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 25: Arquitetura Muitos-para-Muitos em CMS";

$manyToManySyntax = <<<SQL
SELECT tags.nome_tag 
FROM tags
INNER JOIN artigo_tags ON tags.id = artigo_tags.tag_id
WHERE artigo_tags.artigo_id = :post_id;
SQL;

// Execução simulada retornada pelo PDO
$articleTags = ['Ciência', 'Arquitetura PHP', 'Backend Design'];

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Contexto de Tabelas Pivô (Pivot)</h2>
    <p>Artigos têm várias Tags. Tags têm vários Artigos. Resolvemos esse pesadelo de banco de dados usando uma Tabela Pivô (<code>artigo_tags</code>) mapeada nativamente via um <code>INNER JOIN</code>.</p>
</div>

<h3>Representação de Consulta CMS</h3>
<pre><?= htmlspecialchars($manyToManySyntax) ?></pre>

<div class="success-box">
    <strong>Tags vinculadas ao Artigo Renderizado:</strong>
    <ul style="margin-bottom:0;">
        <?php foreach ($articleTags as $tag): ?>
            <li style="font-family:monospace;">~ <?= htmlspecialchars($tag) ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    26 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 26: Padrão Model-View-Controller (MVC)";

$architectureFlow = <<<TEXT
1. USUÁRIO solicita -> Roteador.
2. Roteador decide qual CONTROLADOR implantar com base na URL.
3. Controlador recupera variáveis de Dados do MODEL (Banco de Dados).
4. Controlador sanitiza e processa a lógica.
5. Controlador injeta a saída da Lógica na VIEW (HTML).
TEXT;

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Separação Total de Preocupações</h2>
    <p>Seu código PHP cresceu. O MVC é o padrão global para manter grandes bases de código sustentáveis, dividindo explicitamente os domínios.</p>
</div>

<h3>A Matriz do Ciclo de Vida:</h3>
<pre><?= htmlspecialchars($architectureFlow) ?></pre>

<div class="info-box">
    <strong>Regra de Ouro:</strong> As Views absolutamente NUNCA devem executar consultas SQL ou manipular lógica de validação de negócios bruta. Elas apenas imprimem a formatação de dados com segurança via <code>htmlspecialchars()</code>.
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 26: Extrator de API JSON";

class ArtigoApiController {
    // 1. Um método global que força a arquitetura de cabeçalho JSON
    protected function generateJson(array $payload, int $status = 200): void {
        // http_response_code($status);
        // header('Content-Type: application/json');
        echo json_encode(['status_code' => $status, 'data' => $payload], JSON_PRETTY_PRINT);
    }

    public function retrieve(int $id) {
        $mockModelData = ['id' => $id, 'titulo' => 'Mudança de Paradigma MVC', 'tipo' => 'Tutorial'];
        $this->generateJson($mockModelData, 200);
    }
}

$controllerObject = new ArtigoApiController();

// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Construindo Controladores Base</h2>
</div>

<h3>Execução de Recuperação de Endpoint de API:</h3>
<pre class="content-box" style="background:#000; color:#0f0;">
<?php $controllerObject->retrieve(505); ?>
</pre>

<div class="info-box">
    A lógica da aplicação herda de forma limpa. Um <code>BaseController</code> pode conter métodos universais como <code>redirect()</code>, <code>validate()</code> ou <code>generateJson()</code>!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    27 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 27: O Front Controller e Roteamento Dinâmico";

// Extrair URI do mapa do servidor
$mockUri = '/usuario/editar/88'; // $_SERVER['REQUEST_URI']
$mockMethod = 'POST'; // $_SERVER['REQUEST_METHOD']

// 1. Definindo mapeamento de rotas
$routeEngineMap = [
    'GET /usuario/editar/{id}' => 'UsuarioController@showEditForm',
    'POST /usuario/editar/{id}' => 'UsuarioController@saveChanges',
];

$matchedAction = null;

// 2. Simples combinador de abstração regex
if (preg_match('#^/usuario/editar/(\d+)$#', $mockUri, $matches) && $mockMethod === 'POST') {
    $matchedAction = "Acionando Controlador: [UsuarioController], executando [saveChanges], passando Dados do Parâmetro: [" . $matches[1] . "]";
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Arquitetura de Entrada Única (Front Controller)</h2>
    <p>Usando `.htaccess` ou Nginx, roteamos cada solicitação (<code>/blog</code>, <code>/contato</code>) para um script mestre <code>index.php</code> que mapeia o URI perfeitamente!</p>
</div>

<div class="info-box">
    <strong>Solicitação de Carga Útil do Cliente:</strong> <code><?= $mockMethod ?> <?= $mockUri ?></code><br>
    <strong>Resultado do Despachante Regex:</strong> <?= htmlspecialchars((string)$matchedAction) ?>
</div>

<h3>Rotas de Aplicação Definidas</h3>
<ul>
    <?php foreach ($routeEngineMap as $uri => $controllerString): ?>
        <li><code><strong><?= explode(' ', $uri)[0] ?></strong> <?= explode(' ', $uri)[1] ?></code> &rarr; <code><?= $controllerString ?></code></li>
    <?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 27: Configuração de Verbos RESTful";

$restVerbs = [
    'index'   => ['metodo' => 'GET', 'uri' => '/produtos', 'desc' => 'Listar todos os registros do banco de dados de produtos'],
    'create'  => ['metodo' => 'GET', 'uri' => '/produtos/create', 'desc' => 'Renderizar o formulário HTML físico'],
    'store'   => ['metodo' => 'POST','uri' => '/produtos', 'desc' => 'Aceitar carga POST e executar inserção no DB'],
    'show'    => ['metodo' => 'GET', 'uri' => '/produtos/{id}', 'desc' => 'Buscar e exibir um recurso específico'],
    'edit'    => ['metodo' => 'GET', 'uri' => '/produtos/{id}/edit', 'desc' => 'Renderizar formulário HTML pré-preenchido'],
    'update'  => ['metodo' => 'PUT', 'uri' => '/produtos/{id}', 'desc' => 'Aceitar carga PUT e executar modificação no DB'],
    'destroy' => ['metodo' => 'DELETE', 'uri' => '/produtos/{id}', 'desc' => 'Executar algoritmos de eliminação absoluta'],
];
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Paradigmas de Padrão REST</h2>
    <p>Seguir as especificações absolutas do protocolo HTTP cria arquiteturas de URL perfeitamente previsíveis para o backbone do E-Commerce.</p>
</div>

<table>
    <thead><tr><th>Chamada do Controlador MVC</th><th>Verbo</th><th>Caminho URI</th><th>Alvo Operacional</th></tr></thead>
    <tbody>
        <?php foreach ($restVerbs as $action => $details): ?>
        <tr>
            <td><strong><code><?= htmlspecialchars($action) ?>()</code></strong></td>
            <td style="font-weight:bold; color:var(--text-color);"><?= $details['metodo'] ?></td>
            <td><code><?= htmlspecialchars($details['uri']) ?></code></td>
            <td><?= htmlspecialchars($details['desc']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    28 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 28: Motores de Visualização (View Engines) e Helpers Globais";

// Mapeamento de função usado exclusivamente no mapeamento de visualizações HTML
function e(?string $text): string {
    return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$maliciousDataAttempt = "<script>alert('Roubando cookies usando XSS!');</script>";
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>A Camada de Apresentação (Views)</h2>
    <p>As views nunca devem formatar dados brutos diretamente. Um helper global como <code>e()</code> garante que nunca vazemos acidentalmente nós de script HTML para o layout do navegador.</p>
</div>

<h3>Matriz de Mitigação de Cross Site Scripting:</h3>
<div style="border:1px solid var(--border-color); padding:10px; margin-bottom:10px;">
    <strong>Simulação de Saída de Ataque Bruto:</strong><br>
    <code style="color:red;"><?= htmlspecialchars("echo \$maliciousDataAttempt;") ?></code>
</div>

<div class="success-box">
    <strong>Mecanismo de Proteção com Escape:</strong><br>
    <code>e($maliciousDataAttempt)</code> produz:<br><br>
    <b style="color:#155724; font-family:monospace;"><?= e($maliciousDataAttempt) ?></b>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 28: Wrappers de Layout Mestre (Master Layout)";

$outputBufferingCode = <<<PHP
// 1. Pausar a saída da tela do navegador explicitamente
ob_start();

// 2. Carregar os dados da página nativamente (ex: login_form.php)
require 'views/' . \$viewName . '.php';

// 3. Despejar o buffer em uma variável de string
\$content = ob_get_clean();

// 4. Injetá-lo no Frame do Layout Mestre
require 'layouts/master.php'; 
// (Dentro de master.php, simplesmente escrevemos: <?=\$content?> no centro do HTML)
PHP;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Interceptação de Buffer de Saída (Output Buffering)</h2>
    <p>Como um framework renderiza o mesmo cabeçalho e rodapé globalmente sem precisar literalmente copiar e colar <code>require 'header.php'</code> em cada arquivo? Usando o poderoso sistema <code>ob_start()</code>.</p>
</div>

<h3>Script de Injeção de Renderizador Interno:</h3>
<pre><?= htmlspecialchars($outputBufferingCode) ?></pre>

<div class="info-box">
    <strong>Nota:</strong> Atualmente estamos utilizando uma versão básica disso internamente na pasta <code>php_course</code> para impor nosso design Preto e Branco!
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    29 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 29: Criptografia e Hashing de Senhas";

$plaintext = "SecureSystem__89";

// O Hashing é LENTO agressivamente para evitar a quebra do banco de dados por força bruta!
$options = ['cost' => 12];
$secureHashValue = password_hash($plaintext, PASSWORD_DEFAULT, $options);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Algoritmos de Geração de Hash Criptográfico</h2>
    <p>Usar <code>md5()</code> ou <code>sha1()</code> para senhas é criticamente perigoso. Usamos <code>password_hash()</code> porque ele gera strings de sal (salt) aleatórias implicitamente e executa loops dinamicamente para queimar CPU intencionalmente.</p>
</div>

<table>
    <tr><th>Mapa de Valor Bruto</th><th>Assinatura Hex Gerada (BCRYPT geralmente)</th></tr>
    <tr>
        <td><code><?= htmlspecialchars($plaintext) ?></code></td>
        <td style="word-break:break-all;"><strong><?= htmlspecialchars($secureHashValue) ?></strong></td>
    </tr>
</table>

<div class="info-box">
    <strong>Garantia de Tempo Constante:</strong> Observe que as strings BCRYPT contêm o marcador de algoritmo (<code>$2y$</code>) e o modificador de custo (<code>12$</code>) nativamente vinculados à assinatura.
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 29: Registro de E-Commerce";

$log = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'] ?? '';
    
    if (!$mail) {
        $log = "Bloco de Validação: Identificador de estrutura de e-mail malformado.";
    } elseif (strlen($pass) < 10) {
        $log = "Bloco de Política de Segurança: A frase de passagem requer um comprimento mínimo absoluto de 10 caracteres.";
    } else {
        // Gerando o Hash!
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        
        $log = "SUCESSO: Algoritmos de registro aprovados.\nInserção no Banco de Dados Acionada:\nEmail: $mail\nNó Hasheado: $hashed";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Endpoint de Validação de Conta</h2>
</div>

<?php if ($log): ?>
    <div class="<?= str_starts_with($log, 'SUCESSO') ? 'success-box' : 'error-box' ?>">
        <?= nl2br(htmlspecialchars($log)) ?>
    </div>
<?php endif; ?>

<form method="POST" class="content-box" style="background:var(--hover-bg);">
    <label>Identificar Origem do Contato (Email):</label>
    <input type="email" name="email" required autocomplete="off">
    
    <label>Base da Frase de Passagem Criptográfica:</label>
    <input type="password" name="password" required>
    
    <button type="submit" style="width:100%;">Finalizar Processamento de Cadastro</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT
    ],
    30 => [
        'ex1' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Semana 30: Middleware de Autenticação e Guards de Sessão";

session_start();

function auth_middleware() {
    if (empty($_SESSION['authenticated'])) {
        // Simulação de Desvio de Fluxo (Redirect)
        return false;
    }
    return true;
}

$isProtectedAreaAccessible = auth_middleware();
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>O Padrão Interceptor (Middleware)</h2>
    <p>Middleware atua como um bouncer em um clube. Ele verifica seus cookies/sessão ANTES de permitir que o Controlador principal comece a processar lógica sensível.</p>
</div>

<?php if (!$isProtectedAreaAccessible): ?>
    <div class="error-box" style="text-align:center; padding:20px;">
        <h3 style="margin-top:0;">ACESSO NEGADO: Middleware de Bloco 401</h3>
        <p>Você não possui o token de sessão necessário para visualizar esta zona protegida.</p>
        <a href="?login_sim=1"><button>Simular Login de Middleware</button></a>
    </div>
    <?php if (isset($_GET['login_sim'])) { $_SESSION['authenticated'] = true; header("Location: ?"); exit; } ?>
<?php else: ?>
    <div class="success-box">
        <h3>CONTROLE DE ACESSO CONCEDIDO</h3>
        <p>O middleware verificou sua sessão e permitiu que o controlador renderizasse este conteúdo privado.</p>
        <a href="?logout_sim=1"><button style="background:red;">Simular Logout de Middleware</button></a>
    </div>
    <?php if (isset($_GET['logout_sim'])) { session_destroy(); header("Location: ?"); exit; } ?>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
EOT,
        'ex2' => <<<'EOT'
<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Projeto Semana 30: Listas de Controle de Acesso (ACL)";

class Guard {
    const ROLES = [
        'CONVIDADO' => 0,
        'EDITOR'  => 10,
        'ADMIN'   => 99
    ];

    public static function canAccess(string $userRole, int $requiredLevel): bool {
        $userLevel = self::ROLES[$userRole] ?? 0;
        return $userLevel >= $requiredLevel;
    }
}

$currentUserRole = $_GET['role'] ?? 'CONVIDADO';
$requiredAccess = 10; // Nível Editor ou Admin necessário

$accessAllowed = Guard::canAccess($currentUserRole, $requiredAccess);
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Autorização Baseada em Funções (RBAC)</h2>
</div>

<div class="info-box">
    <strong>Permissão Necessária:</strong> Nível 10 (EDITOR)<br>
    <strong>Sua Identidade Atual:</strong> <code><?= htmlspecialchars($currentUserRole) ?></code>
</div>

<?php if ($accessAllowed): ?>
    <div class="success-box">
        <h4>Acesso Autorizado</h4>
        <p>Como <?= $currentUserRole ?>, você tem permissões para modificar o banco de dados do blog.</p>
    </div>
<?php else: ?>
    <div class="error-box">
        <h4>Acesso Proibido (403)</h4>
        <p>Seu nível de segurança é insuficiente para realizar operações de edição.</p>
    </div>
<?php endif; ?>

<div style="display:flex; gap:10px; margin-top:20px;">
    <a href="?role=CONVIDADO"><button>Entrar como Convidado</button></a>
    <a href="?role=EDITOR"><button>Entrar como Editor</button></a>
    <a href="?role=ADMIN"><button>Entrar como Admin</button></a>
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
echo "Layouts Profissionais gerados & aplicados às Semanas 21-30.\n";
