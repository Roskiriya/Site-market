<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

if (isset($_POST['form'])) {
    $name = $db->escape($_POST['name']);
    $phone = $db->escape($_POST['phone']);
    $address = $db->escape($_POST['address']);

    $result = $db->insert('provider', [
        'name of_the_organization' => $name,
        'contact_number' => $phone,
        'address' => $address,
    ]);

    if ($result === true) {
        $_SESSION['res'] = 'success';
        $_SESSION['msg'] = 'Успешно сохранено';
        header('Location: /providers.php');
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}

?>

    <main class="container">
        <h2 class="display-4">Добавление поставщика</h2>
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $res; ?>">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
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
