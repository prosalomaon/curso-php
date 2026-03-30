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


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.pdo.php" target="_blank">Manual PHP: Básico de SQL</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL
);</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>