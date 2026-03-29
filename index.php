<?php
/**
 * Course Navigation Index
 * Simple Black and White layout as requested.
 */
$course_path = "php_course";
$directories = array_filter(glob(__DIR__ . '/' . $course_path . '/week_*'), 'is_dir');
natsort($directories);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Course Navigation</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <header>
      <h1>PHP Zero To Hero</h1>
      <p class="subtitle">Complete Technical Course Curriculum</p>
    </header>

    <main>
      <?php if (empty($directories)): ?>
        <div class="week-container">
          <p>No weekly course folders were found in this directory.</p>
        </div>
      <?php else: ?>
        <?php foreach ($directories as $dir): ?>
          <?php
          $folderName = basename($dir);
          // Clean up title: replace underscores with spaces and remove 'week' prefix
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
      End of Curriculum
    </footer>
  </div>

</body>

</html>