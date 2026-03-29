<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 21: Relational Database Schemas";

$schemaCode = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    role ENUM('USER', 'ADMIN') DEFAULT 'USER',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    CONSTRAINT fk_post_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;
SQL;
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>MySQL / MariaDB Standardization</h2>
    <p>PHP relies on rock-solid database schema designs. Use InnoDB and utf8mb4 encoding to fully support modern Unicode formats (like emojis) and Foreign Constraints.</p>
</div>

<h3>Foundational 1-to-Many Architecture</h3>
<pre><?= htmlspecialchars($schemaCode) ?></pre>

<div class="info-box">
    <strong>Relational Integrity:</strong> The <code>ON DELETE CASCADE</code> instructs the database engine to instantly wipe all <code>posts</code> belonging to a user if the user's ID is deleted, preventing "Orphaned Records" safely without PHP intervening.
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>