<?php
/**
 * Course Navigation Index
 * Simple Black and White layout as requested.
 */
$course_path = "php_course";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navegação do Curso de PHP</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <header>
      <h1>PHP: Do Zero ao Herói</h1>
      <p class="subtitle">Currículo Técnico Completo do Curso</p>
    </header>

    <main>
      <?php 
      $directories = array_filter(glob(__DIR__ . '/' . $course_path . '/semana_*'), 'is_dir');
      natsort($directories);
      if (empty($directories)): 
      ?>
        <div class="week-container">
          <p>Nenhuma pasta semanal foi encontrada neste diretório.</p>
        </div>
      <?php else: ?>
        <?php foreach ($directories as $dir): ?>
          <?php
          $folderName = basename($dir);
          // Clean up title: replace underscores with spaces and remove 'semana' prefix
          $cleanTitle = str_replace('_', ' ', $folderName);

          // Common course files to check for
          $files = ['README.md', 'example_1.php', 'example_2.php', 'exercises.md'];
          ?>
          <div class="week-container">
            <h2 class="week-title"><?= htmlspecialchars($cleanTitle) ?></h2>
            <ul class="file-list">
              <?php foreach ($files as $fileName): ?>
                <?php $filePath = $course_path . "/" . $folderName . '/' . $fileName; ?>
                <?php if (file_exists(__DIR__ . '/' . $filePath)): ?>
                  <li>
                    <?php if (str_ends_with($fileName, '.md')): ?>
                      <a href="markdown.php?file=<?= urlencode($filePath) ?>">
                        [ <?= htmlspecialchars($fileName) ?> ]
                      </a>
                    <?php else: ?>
                      <a href="<?= htmlspecialchars($filePath) ?>">
                        [ <?= htmlspecialchars($fileName) ?> ]
                      </a>
                    <?php endif; ?>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </main>

    <footer>
      Fim do Currículo
    </footer>
  </div>

</body>

</html>