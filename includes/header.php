<?php
include "sqlite.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Отделы супермаркета</title>

    <link rel="stylesheet" href="https://bootswatch.com/4/litera/bootstrap.min.css">
    <link rel="stylesheet" href="/style.css?v=336">
</head>

<body>
<?php if (isset($_SESSION['id'])): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="/logo.svg" alt="Logo" class="logo"> Отделы сурпермаркетов</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
                    aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="peoples" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Люди</a>
                        <div class="dropdown-menu" aria-labelledby="peoples">
                            <a class="dropdown-item" href="/customers.php">Покупатели</a>
                            <a class="dropdown-item" href="/employees.php">Продавцы</a>
                            <a class="dropdown-item" href="/post.php">Должности</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="products" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Товары</a>
                        <div class="dropdown-menu" aria-labelledby="products">
                            <a class="dropdown-item" href="/categories.php">Категории</a>
                            <a class="dropdown-item" href="/products.php">Товары</a>
                            <a class="dropdown-item" href="/providers.php">Поставщики</a>
                            <a class="dropdown-item" href="/selling.php">Продажи</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search.php">Поиск</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION['name']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/logout.php">Выход</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['res']; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['msg']; ?>
            </div>
            <?php $_SESSION['res'] = null; ?>
            <?php $_SESSION['msg'] = null; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if ($_SERVER['REQUEST_URI'] != '/login.php' && !isset($_SESSION['id'])) header('Location: /'); ?>
