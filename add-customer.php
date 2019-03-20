<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

if (isset($_POST['form'])) {
    $surname = $db->escape($_POST['surname']);
    $name = $db->escape($_POST['name']);
    $patronymic = $db->escape($_POST['patronymic']);
    $numb_card = (int)$_POST['card_number'];
    $date_of_birth = $db->escape($_POST['birthday']);
    $date = date_create($date_of_birth);
    $date_of_birth = date_format($date, 'd.m.Y');
    $address = $db->escape($_POST['address']);

    $result = $db->insert('coustomer', [
        'surname' => $surname,
        'name' => $name,
        'patronymic' => $patronymic,
        'numb_card' => $numb_card,
        'date_of_birth' => $date_of_birth,
        'address' => $address,
    ]);

    if ($result === true) {
        $_SESSION['res'] = 'success';
        $_SESSION['msg'] = 'Успешно сохранено';
        header('Location: /customers.php');
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}

$today = date('Y-m-d');
?>

    <main class="container">
        <h2 class="display-4">Добавление покупателя</h2>
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $res; ?>">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname"
                       required>
            </div>
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="patronymic">Отчество</label>
                <input type="text" class="form-control" id="patronymic" name="patronymic" required>
            </div>
            <div class="form-group">
                <label for="card_number">Номер карты</label>
                <input type="number" class="form-control" id="card_number" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="birthday">Дата рождения</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required max="<?= $today; ?>">
            </div>
            <div class="form-group">
                <label for="address">Адрес</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <input type="submit" class="btn btn-success" value="Сохранить" name="form"/>
        </form>
    </main>

<?php
include "includes/footer.php";
