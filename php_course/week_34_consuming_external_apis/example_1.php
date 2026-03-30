<?php
declare(strict_types=1);

// --- BUSINESS LOGIC ---
$pageTitle = "Week 34: Try/Catch & Exception Bubbling";

$log = [];

class DatabaseException extends Exception {}
class ValidationException extends Exception {}

function attemptFragileOperation(bool $failDb, bool $failVal) {
    if ($failVal) throw new ValidationException("User provided bad input data.");
    if ($failDb) throw new DatabaseException("MySQL Engine went offline unexpectedly.");
    
    return "Operation Succeeded!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $failDb = isset($_POST['fail_db']);
    $failVal = isset($_POST['fail_val']);
    
    try {
        $log[] = "Trying operation...";
        $result = attemptFragileOperation($failDb, $failVal);
        $log[] = "RESULT: " . $result;
        
    } catch (ValidationException $e) {
        $log[] = "[CAUGHT] Business Logic Error: " . $e->getMessage();
        
    } catch (DatabaseException $e) {
        $log[] = "[CAUGHT] Infrastructure Error: " . $e->getMessage();
        // Here you would normally log to Monolog & page DevOps!
        
    } catch (Exception $e) {
        // The ultimate fallback for anything else
        $log[] = "[FATAL] Unknown crash: " . $e->getMessage();
        
    } finally {
        $log[] = "Finally Block Executed: Cleaning up RAM/Files regardless of success or crash.";
    }
}
// --- END LOGIC ---

require_once __DIR__ . '/../includes/header.php';
?>
<!-- START PRESENTATION -->
<div class="content-box">
    <h2>Handling Catastrophic Failures</h2>
    <p>Using Custom Exceptions allows us to direct traffic when scripts explode natively, preventing white-screens of death.</p>
</div>

<form method="POST" class="content-box" style="display:flex; flex-direction:column; gap:10px;">
    <div>
        <input type="checkbox" id="v" name="fail_val" value="1"> 
        <label for="v">Simulate Invalid User Data (Soft Error)</label>
    </div>
    <div>
        <input type="checkbox" id="d" name="fail_db" value="1"> 
        <label for="d">Simulate Database Network Outage (Hard Crash)</label>
    </div>
    <button type="submit">Run Execution Block</button>
</form>

<?php if ($log): ?>
    <ul class="content-box" style="background:#000; color:#0f0; padding:20px; list-style-type:none;">
        <?php foreach ($log as $l): ?>
            <li style="margin-bottom:5px;">>> <?= htmlspecialchars($l) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<div class="info-box references-section" style="margin-top: 40px; border-left-color: #007BFF;">
    <h3 style="margin-top:0;">References & Official Documentation</h3>
    <ul>
        <li><a href="https://www.php.net/manual/pt_BR/book.curl.php" target="_blank">PHP Manual: External APIs (cURL)</a></li>
    </ul>
</div>

<div class="content-box snippets-section" style="background: var(--hover-bg); margin-top:20px;">
    <h3 style="margin-top:0;">Useful Snippets</h3>
    <pre style="margin:0;"><code>&lt;?php
$ch = curl_init(&#039;https://api.github.com/users/octocat&#039;);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
?&gt;</code></pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>