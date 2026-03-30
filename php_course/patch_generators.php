<?php
// patch_generators.php
// Este script modifica os scripts pro_fill_*.php para injetar automaticamente o HTML de referências antes de salvar

$files = [
  __DIR__ . '/pro_fill_1_10.php',
  __DIR__ . '/pro_fill_11_20.php',
  __DIR__ . '/pro_fill_21_30.php',
  __DIR__ . '/pro_fill_31_40.php',
];

$searchPattern = <<<'PATTERN'
    if (isset($examples[$weekNum])) {
        file_put_contents($dir . '/example_1.php', $examples[$weekNum]['ex1']);
        file_put_contents($dir . '/example_2.php', $examples[$weekNum]['ex2']);
    }
PATTERN;

// Usando espaços consistentes para a substituição
$replacementBlock = <<<'REPLACEMENT'
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
REPLACEMENT;

$successCount = 0;

foreach ($files as $file) {
  if (!file_exists($file))
    continue;

  $content = file_get_contents($file);

  // Verifica se já foi patcheado
  if (strpos($content, '$injectionHtml') !== false) {
    echo "Arquivo já patcheado: " . basename($file) . "\n";
    continue;
  }

  // Usa regex para tolerar diferentes indentações
  $pattern = '/\s*if\s*\(\s*isset\(\$examples\[\$weekNum\]\)\s*\)\s*\{\s*file_put_contents\(\$dir\s*\.\s*\'\/example_1\.php\',\s*\$examples\[\$weekNum\]\[\'ex1\'\]\);\s*file_put_contents\(\$dir\s*\.\s*\'\/example_2\.php\',\s*\$examples\[\$weekNum\]\[\'ex2\'\]\);\s*\}/';

  $newContent = preg_replace($pattern, "\n" . $replacementBlock, $content);

  if ($content !== $newContent && $newContent !== null) {
    file_put_contents($file, $newContent);
    echo "Patcheado com sucesso: " . basename($file) . "\n";
    $successCount++;
  } else {
    echo "Padrão não encontrado em: " . basename($file) . "\n";
  }
}

echo "Total patcheado: $successCount\n";
