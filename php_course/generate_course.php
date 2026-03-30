<?php

$curriculum = [
    // Módulo 1: Os Fundamentos
    ['week' => 1, 'title' => 'Introdução e Configuração', 'project' => 'Página de Bio Pessoal'],
    ['week' => 2, 'title' => 'Variáveis e Tipos de Dados', 'project' => 'Página de Bio Pessoal'],
    ['week' => 3, 'title' => 'Operadores', 'project' => 'Página de Bio Pessoal'],
    ['week' => 4, 'title' => 'Strings', 'project' => 'Página de Bio Pessoal'],
    // Módulo 2: Lógica e Fluxo de Controle
    ['week' => 5, 'title' => 'Estruturas de Controle', 'project' => 'Jogo de Adivinhação de Números'],
    ['week' => 6, 'title' => 'Arrays (Vetores)', 'project' => 'Jogo de Adivinhação de Números'],
    ['week' => 7, 'title' => 'Laços de Repetição', 'project' => 'Jogo de Adivinhação de Números'],
    ['week' => 8, 'title' => 'Foreach e Funções de Array', 'project' => 'Jogo de Adivinhação de Números'],
    // Módulo 3: Funções e Estado
    ['week' => 9, 'title' => 'Funções Definidas pelo Usuário', 'project' => 'Web App de Gerenciador de Tarefas'],
    ['week' => 10, 'title' => 'Escopo e Funções Anônimas', 'project' => 'Web App de Gerenciador de Tarefas'],
    ['week' => 11, 'title' => 'Superglobais', 'project' => 'Web App de Gerenciador de Tarefas'],
    ['week' => 12, 'title' => 'Manipulação de Formulários', 'project' => 'Web App de Gerenciador de Tarefas'],
    // Módulo 4: Estado Avançado e Arquivos
    ['week' => 13, 'title' => 'Sessões', 'project' => 'Cofre de Arquivos Seguro'],
    ['week' => 14, 'title' => 'Cookies', 'project' => 'Cofre de Arquivos Seguro'],
    ['week' => 15, 'title' => 'Básico de Sistema de Arquivos', 'project' => 'Cofre de Arquivos Seguro'],
    ['week' => 16, 'title' => 'Upload de Arquivos e Segurança', 'project' => 'Cofre de Arquivos Seguro'],
    // Módulo 5: Programação Orientada a Objetos
    ['week' => 17, 'title' => 'Introdução a POO', 'project' => 'API de Gerador de Personagens'],
    ['week' => 18, 'title' => 'Construtores e Visibilidade', 'project' => 'API de Gerador de Personagens'],
    ['week' => 19, 'title' => 'Herança e Sobrescrita', 'project' => 'API de Gerador de Personagens'],
    ['week' => 20, 'title' => 'Interfaces e Classes Abstratas', 'project' => 'API de Gerador de Personagens'],
    // Módulo 6: Integração com Bancos de Dados
    ['week' => 21, 'title' => 'Bancos de Dados Relacionais e SQL', 'project' => 'Core de CMS de Blog'],
    ['week' => 22, 'title' => 'Conectando com PDO', 'project' => 'Core de CMS de Blog'],
    ['week' => 23, 'title' => 'Instruções Preparadas (Prepared Statements)', 'project' => 'Core de CMS de Blog'],
    ['week' => 24, 'title' => 'Operações CRUD', 'project' => 'Core de CMS de Blog'],
    // Módulo 7: Bancos de Dados Avançados e Arquitetura
    ['week' => 25, 'title' => 'Consultas Relacionais e JOINs', 'project' => 'CMS de Blog Avançado'],
    ['week' => 26, 'title' => 'Introdução ao Padrão MVC', 'project' => 'CMS de Blog Avançado'],
    ['week' => 27, 'title' => 'Roteamento e Front Controller', 'project' => 'CMS de Blog Avançado'],
    ['week' => 28, 'title' => 'Básico de Templates', 'project' => 'CMS de Blog Avançado'],
    // Módulo 8: Segurança e Autenticação
    ['week' => 29, 'title' => 'Registro de Usuários e Hashing', 'project' => 'Backend de E-Commerce Seguro'],
    ['week' => 30, 'title' => 'Fluxo de Autenticação', 'project' => 'Backend de E-Commerce Seguro'],
    ['week' => 31, 'title' => 'Autorização e Papéis (Roles)', 'project' => 'Backend de E-Commerce Seguro'],
    ['week' => 32, 'title' => 'Proteções de Segurança Web', 'project' => 'Backend de E-Commerce Seguro'],
    // Módulo 9: APIs e PHP Moderno
    ['week' => 33, 'title' => 'JSON e Conceitos RESTful', 'project' => 'Aplicativo de Previsão do Tempo'],
    ['week' => 34, 'title' => 'Consumindo APIs Externas', 'project' => 'Aplicativo de Previsão do Tempo'],
    ['week' => 35, 'title' => 'Construindo uma API REST', 'project' => 'Aplicativo de Previsão do Tempo'],
    ['week' => 36, 'title' => 'Composer e PSR-4', 'project' => 'Aplicativo de Previsão do Tempo'],
    // Módulo 10: A Reta Final
    ['week' => 37, 'title' => 'Tratamento de Erros e Logging', 'project' => 'Integração de Aplicativo Full-Stack'],
    ['week' => 38, 'title' => 'Datas, Horários e Localização', 'project' => 'Integração de Aplicativo Full-Stack'],
    ['week' => 39, 'title' => 'Arquitetura do Projeto Final', 'project' => 'Integração de Aplicativo Full-Stack'],
    ['week' => 40, 'title' => 'Implementação do Projeto Final', 'project' => 'Integração de Aplicativo Full-Stack'],
];

foreach ($curriculum as $item) {
    $weekNum = str_pad($item['week'], 2, '0', STR_PAD_LEFT);
    $folderName = __DIR__ . '/semana_' . $weekNum . '_' . str_replace(' ', '_', strtolower($item['title']));
    
    if (!is_dir($folderName)) {
        mkdir($folderName, 0777, true);
    }

    // Generate README.md
    $readme = "# Semana {$item['week']}: {$item['title']}\n\n## Visão Geral\nEsta aula cobre {$item['title']} em PHP. \n\n## Interação com o Projeto\n**Projeto Atual:** {$item['project']}\nVamos aplicar os conceitos aprendidos hoje para construir funcionalidades para o {$item['project']}.\n\n## Conteúdo\n- `example_1.php`: Demonstração básica do conceito.\n- `example_2.php`: Uso avançado e casos de borda.\n- `exercises.md`: Problemas práticos para solidificar sua compreensão.\n";
    file_put_contents($folderName . '/README.md', $readme);

    // Generate Example 1
    $ex1 = "<?php\n// Exemplo 1: Conceito básico de {$item['title']}\n\necho \"<h1>Semana {$item['week']} - {$item['title']}</h1>\";\necho \"<p>Explorando os fundamentos de {$item['title']}.</p>\";\n\n// TODO: Implementar lógica básica aqui\n";
    file_put_contents($folderName . '/example_1.php', $ex1);

    // Generate Example 2
    $ex2 = "<?php\n// Exemplo 2: Cenário real para {$item['title']}\n\n// Como {$item['title']} se aplica ao nosso projeto: {$item['project']}\n\necho \"<h2>Aplicando {$item['title']} ao {$item['project']}</h2>\";\n\n// TODO: Implementar lógica específica do projeto aqui\n";
    file_put_contents($folderName . '/example_2.php', $ex2);

    // Generate Exercises
    $exercises = "# Exercícios para a Semana {$item['week']}: {$item['title']}\n\n## Exercício 1\nEscreva um script PHP básico que explore os fundamentos de {$item['title']}. Certifique-se de comentar seu código para explicar o que você está fazendo.\n\n## Exercício 2\nPegue o conceito central de {$item['title']} e integre-o ao {$item['project']}. Como essa parte da linguagem ajuda a construir o projeto?\n\n## Desafio Bônus\nRefatore `example_2.php` para lidar com casos de borda ou entradas inválidas de forma graciosa.\n";
    file_put_contents($folderName . '/exercises.md', $exercises);
}

echo "Estrutura do curso gerada com sucesso!\n";
