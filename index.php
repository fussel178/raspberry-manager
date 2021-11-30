<?php
require_once 'app/setup.php';
?>
<!doctype html>
<html lang="en">
<head>
    <!-- basic stuff -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">

    <title>Raspberry Manager</title>

    <!-- icon setup -->
    <meta name="theme-color" content="#ffffff">

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png?v=sfji238dfs">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png?v=sfji238dfs">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png?v=sfji238dfs">
    <link rel="manifest" href="site.webmanifest?v=sfji238dfs">
    <link rel="mask-icon" href="safari-pinned-tab.svg?v=sfji238dfs" color="#88e147">
    <link rel="shortcut icon" href="favicon.ico?v=sfji238dfs">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="browserconfig.xml?v=sfji238dfs">

    <!-- default (light) stylesheet -->
    <!--    <link href="styles/mini.css/mini-default.min.css" type="text/css" rel="stylesheet">-->
    <!-- dark stylesheet -->
    <!--    <link href="styles/mini.css/mini-dark.min.css" type="text/css" rel="stylesheet">-->
    <!-- nord stylesheet -->
    <link href="styles/mini.css/mini-nord.min.css" type="text/css" rel="stylesheet">

    <link href="styles/fixes.css" type="text/css" rel="stylesheet">
</head>

<body>

<header class="sticky row">
    <a href="./" class="button logo-img">
        <img src="favicon.ico" alt="Raspberry Manager logo"/>
    </a>

    <?php foreach ($config['controllers'] as $controller): ?>
        <a href="#<?= $controller->getId() ?>" class="button"><?= $controller->getTitle() ?></a>
    <?php endforeach; ?>
</header>

<main>
    <?php
    foreach ($config['controllers'] as $controller) {
        $card = [
            "id" => $controller->getId(),
            "title" => $controller->getTitle(),
            "body" => $controller->render()
        ];
        include "app/views/elements/card.php";
    }

    if (count($config['controllers']) == 0) {
        echo '<p>No controllers registered.</p>';
    }
    ?>
</main>

</body>
</html>
