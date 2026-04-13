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


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">Referências & Documentação Oficial</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/features.file-upload.php" target="_blank">Manual PHP: Upload de Arquivos</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Snippets Úteis</h3>
    <pre style="margin:0;"><code>&lt;?php
move_uploaded_file($_FILES[&#039;img&#039;][&#039;tmp_name&#039;], &#039;./upload/&#039; . $fileName);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>