<?php

require_once __DIR__ . '/vendor/autoload.php';

$file = $_GET['file'] ?? '';

// Basic validation to prevent path traversal and ensure it's a markdown file
if (empty($file) || !str_ends_with($file, '.md') || strpos($file, '..') !== false) {
    http_response_code(400);
    die('Invalid file request.');
}

$filePath = __DIR__ . '/' . $file;

if (!file_exists($filePath)) {
    http_response_code(404);
    die('File not found.');
}

$markdownContent = file_get_contents($filePath);
$Parsedown = new Parsedown();
$htmlContent = $Parsedown->text($markdownContent);

// Get a clean title based on the filename
$title = htmlspecialchars(basename($file));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?> - PHP Course</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <header>
      <h1><?= $title ?></h1>
      <p class="subtitle"><a href="index.php">← Back to Course Navigation</a></p>
    </header>

    <main class="markdown-content">
      <?= $htmlContent ?>
    </main>

    <footer>
      End of File
    </footer>
  </div>

</body>

</html>
