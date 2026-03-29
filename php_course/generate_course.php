<?php

$curriculum = [
    // Module 1: The Basics
    ['week' => 1, 'title' => 'Intro and Setup', 'project' => 'Personal Bio Page'],
    ['week' => 2, 'title' => 'Variables and Data Types', 'project' => 'Personal Bio Page'],
    ['week' => 3, 'title' => 'Operators', 'project' => 'Personal Bio Page'],
    ['week' => 4, 'title' => 'Strings', 'project' => 'Personal Bio Page'],
    // Module 2: Logic & Control Flow
    ['week' => 5, 'title' => 'Control Structures', 'project' => 'Number Guessing Game'],
    ['week' => 6, 'title' => 'Arrays', 'project' => 'Number Guessing Game'],
    ['week' => 7, 'title' => 'Loops', 'project' => 'Number Guessing Game'],
    ['week' => 8, 'title' => 'Foreach and Array Functions', 'project' => 'Number Guessing Game'],
    // Module 3: Functions & State
    ['week' => 9, 'title' => 'User-defined Functions', 'project' => 'Task Manager Web App'],
    ['week' => 10, 'title' => 'Scope and Anonymous Functions', 'project' => 'Task Manager Web App'],
    ['week' => 11, 'title' => 'Superglobals', 'project' => 'Task Manager Web App'],
    ['week' => 12, 'title' => 'Forms Handling', 'project' => 'Task Manager Web App'],
    // Module 4: Advanced State & Files
    ['week' => 13, 'title' => 'Sessions', 'project' => 'Secure File Vault'],
    ['week' => 14, 'title' => 'Cookies', 'project' => 'Secure File Vault'],
    ['week' => 15, 'title' => 'File System Basics', 'project' => 'Secure File Vault'],
    ['week' => 16, 'title' => 'File Uploads and Security', 'project' => 'Secure File Vault'],
    // Module 5: Object-Oriented Programming
    ['week' => 17, 'title' => 'Intro to OOP', 'project' => 'Character Generator API'],
    ['week' => 18, 'title' => 'Constructors and Visibility', 'project' => 'Character Generator API'],
    ['week' => 19, 'title' => 'Inheritance and Overriding', 'project' => 'Character Generator API'],
    ['week' => 20, 'title' => 'Interfaces and Abstract Classes', 'project' => 'Character Generator API'],
    // Module 6: Database Integration
    ['week' => 21, 'title' => 'Relational Databases and SQL', 'project' => 'Blog CMS Core'],
    ['week' => 22, 'title' => 'Connecting with PDO', 'project' => 'Blog CMS Core'],
    ['week' => 23, 'title' => 'Prepared Statements', 'project' => 'Blog CMS Core'],
    ['week' => 24, 'title' => 'CRUD Operations', 'project' => 'Blog CMS Core'],
    // Module 7: Advanced Databases & Architecture
    ['week' => 25, 'title' => 'Relational Queries JOINs', 'project' => 'Blog CMS Advanced'],
    ['week' => 26, 'title' => 'MVC Pattern Intro', 'project' => 'Blog CMS Advanced'],
    ['week' => 27, 'title' => 'Routing and Front Controller', 'project' => 'Blog CMS Advanced'],
    ['week' => 28, 'title' => 'Templating Basics', 'project' => 'Blog CMS Advanced'],
    // Module 8: Security & Authentication
    ['week' => 29, 'title' => 'User Registration and Hashing', 'project' => 'Secure E-Commerce Backend'],
    ['week' => 30, 'title' => 'Authentication Flow', 'project' => 'Secure E-Commerce Backend'],
    ['week' => 31, 'title' => 'Authorization and Roles', 'project' => 'Secure E-Commerce Backend'],
    ['week' => 32, 'title' => 'Web Security Protections', 'project' => 'Secure E-Commerce Backend'],
    // Module 9: APIs & Modern PHP
    ['week' => 33, 'title' => 'JSON and RESTful Concepts', 'project' => 'Weather Application'],
    ['week' => 34, 'title' => 'Consuming External APIs', 'project' => 'Weather Application'],
    ['week' => 35, 'title' => 'Building a REST API', 'project' => 'Weather Application'],
    ['week' => 36, 'title' => 'Composer and PSR-4', 'project' => 'Weather Application'],
    // Module 10: The Final Stretch
    ['week' => 37, 'title' => 'Error Handling and Logging', 'project' => 'Full-Stack Application Integration'],
    ['week' => 38, 'title' => 'Dates Times and Localization', 'project' => 'Full-Stack Application Integration'],
    ['week' => 39, 'title' => 'Final Project Architecture', 'project' => 'Full-Stack Application Integration'],
    ['week' => 40, 'title' => 'Final Project Implementation', 'project' => 'Full-Stack Application Integration'],
];

foreach ($curriculum as $item) {
    $weekNum = str_pad($item['week'], 2, '0', STR_PAD_LEFT);
    $folderName = __DIR__ . '/week_' . $weekNum . '_' . str_replace(' ', '_', strtolower($item['title']));
    
    if (!is_dir($folderName)) {
        mkdir($folderName, 0777, true);
    }

    // Generate README.md
    $readme = "# Week {$item['week']}: {$item['title']}\n\n## Overview\nThis class covers {$item['title']} in PHP. \n\n## Project Interaction\n**Current Project:** {$item['project']}\nWe will apply the concepts learned today to build out features for the {$item['project']}.\n\n## Contents\n- `example_1.php`: Basic demonstration of the concept.\n- `example_2.php`: Advanced usage and edge cases.\n- `exercises.md`: Practice problems to solidify your understanding.\n";
    file_put_contents($folderName . '/README.md', $readme);

    // Generate Example 1
    $ex1 = "<?php\n// Example 1: Basic concept of {$item['title']}\n\necho \"<h1>Week {$item['week']} - {$item['title']}</h1>\";\necho \"<p>Exploring the basics of {$item['title']}.</p>\";\n\n// TODO: Implement basic logic here\n";
    file_put_contents($folderName . '/example_1.php', $ex1);

    // Generate Example 2
    $ex2 = "<?php\n// Example 2: Real-world scenario for {$item['title']}\n\n// How {$item['title']} applies to our project: {$item['project']}\n\necho \"<h2>Applying {$item['title']} to {$item['project']}</h2>\";\n\n// TODO: Implement project-specific logic here\n";
    file_put_contents($folderName . '/example_2.php', $ex2);

    // Generate Exercises
    $exercises = "# Exercises for Week {$item['week']}: {$item['title']}\n\n## Exercise 1\nWrite a basic PHP script that explores the fundamentals of {$item['title']}. Make sure to comment your code to explain what you're doing.\n\n## Exercise 2\nTake the core concept of {$item['title']} and integrate it into the {$item['project']}. How does this piece of the language help build the project?\n\n## Bonus Challenge\nRefactor `example_2.php` to handle edge cases or invalid inputs gracefully.\n";
    file_put_contents($folderName . '/exercises.md', $exercises);
}

echo "Course structure generated successfully!\n";
