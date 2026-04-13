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


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.errorfunc.php" target="_blank">Manual PHP: Tratamento de Erros</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
try {
    // lógica arriscada
} catch (Exception $e) {
    error_log($e-&gt;getMessage());
}
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>