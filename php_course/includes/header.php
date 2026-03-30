<?php
$pageTitle = $pageTitle ?? "PHP Professional Course";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/style.css">
    <style>
        .content-box { border: 1px solid var(--border-color); padding: 20px; margin-bottom: 20px; background: #fff; }
        .success-box { border: 1px solid #155724; border-left: 5px solid #155724; padding: 15px; margin-bottom: 20px; background: #d4edda; color: #155724;}
        .error-box { border: 1px solid #721c24; border-left: 5px solid #721c24; padding: 15px; margin-bottom: 20px; background: #f8d7da; color: #721c24;}
        .info-box { border: 1px solid #0c5460; border-left: 5px solid #0c5460; padding: 15px; margin-bottom: 20px; background: #d1ecf1; color: #0c5460;}
        input[type="text"], input[type="number"], input[type="password"], select, textarea { 
            width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; 
            border: 1px solid var(--border-color); font-family: inherit; box-sizing: border-box;
        }
        button, input[type="submit"] { 
            background: var(--text-color); color: var(--bg-color); border: 2px solid var(--text-color); 
            cursor: pointer; padding: 10px 20px; font-weight: bold; text-transform: uppercase; transition: all 0.2s;
        }
        button:hover, input[type="submit"]:hover { background: var(--bg-color); color: var(--text-color); }
        pre { background: #f4f4f4; padding: 15px; overflow-x: auto; border: 1px solid #ddd; }
        code { font-family: 'Courier New', Courier, monospace; background: #f4f4f4; padding: 2px 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid var(--border-color); padding: 10px; text-align: left; }
        th { background: var(--hover-bg); text-transform: uppercase; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="subtitle">Ambiente Interativo de Execução PHP</p>
        </header>
        <main>
