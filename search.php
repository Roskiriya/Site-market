<?php
ob_start();
session_start();
include "includes/header.php";


$db = new DB('db.db');

$tables = [
    'customers' => 'Покупатели',
    'employees' => 'Продавцы',
    'post' => 'Должности',
    'categories' => 'Категории',
    'products' => 'Товары',
    'providers' => 'Поставщики',
    'selling' => 'Продажи',
];

if (isset($_GET['q'])): ?>
    <?php
    $q = $_GET['q'];

    $table = trim($_GET['table']);
    $table = $db->escape($table);

    header('Location: /' . $table . '.php?q=' . $q);

    ?>
<?php else: ?>
    <main class="container">
        <div class="row">
            <div class="jumbotron col-12">
                <h2 class="display-4">Поиск</h2>
                <form action="" method="get">
                    <div class="form-group">
                        <input type="search" name="q" placeholder="Введите запрос"
                               class="form-control" required minlength="1" maxlength="100" value="">
                    </div>
                    <div class="form-group">
                        <select name="table" id="table" class="form-control" required>
                            <option disabled>Таблица для поиска</option>
                            <?php foreach ($tables as $table => $name): ?>
                                <option value="<?= $table; ?>"><?= $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Найти</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php endif; ?>
<?php
include "includes/footer.php";