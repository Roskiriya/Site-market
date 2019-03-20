<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

$id = (int)$_GET['id'];

$info = $db->selectOne('employees', '*', 'employee_ID=' . $id);
if (!$info)
    header('Location: /');

if (isset($_POST['form'])) {
    $surname = $db->escape($_POST['surname']);
    $name = $db->escape($_POST['name']);
    $patronymic = $db->escape($_POST['patronymic']);
    $phone = $db->escape($_POST['phone']);
    $date_of_birth = $db->escape($_POST['birthday']);
    $date = date_create($date_of_birth);
    $date_of_birth = date_format($date, 'd.m.Y');
    $address = $db->escape($_POST['address']);
    $post = (int)$_POST['post'];

    $result = $db->update('employees', [
        'surname' => $surname,
        'name' => $name,
        'patronymic' => $patronymic,
        'phone' => $phone,
        'date_of_birth' => $date_of_birth,
        'address' => $address,
        'post_ID' => $post,
    ], 'employee_ID = ' . $id);

    if ($result === true) {
        $res = 'success';
        $msg = 'Успешно сохранено';
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}

$info = $db->selectOne('employees', '*', 'employee_ID=' . $id);
$date = date_create($info['date_of_birth']);
$info['date_of_birth'] = date_format($date, 'Y-m-d');

$today = date('Y-m-d');

$posts = $db->select('post');
?>

    <main class="container">
        <h2 class="display-4">Редактирование продавца</h2>
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $res; ?>">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?= $info['surname']; ?>"
                       required>
            </div>
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $info['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="patronymic">Отчество</label>
                <input type="text" class="form-control" id="patronymic" name="patronymic"
                       value="<?= $info['patronymic']; ?>" required>
            </div>
            <div class="form-group">
                <label for="post">Номер телефона</label>
                <select name="post" id="post" class="form-control">
                    <?php foreach ($posts as $post): ?>
                        <option value="<?= $post['post_ID']; ?>" <?php if ($post['post_ID'] == $info['post_ID']): ?>selected<?php endif; ?>><?= $post['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона</label>
                <input type="text" class="form-control" id="phone" name="phone"
                       value="<?= $info['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="birthday">Дата рождения</label>
                <input type="date" class="form-control" id="birthday" name="birthday"
                       value="<?= $info['date_of_birth']; ?>" required max="<?= $today; ?>">
            </div>
            <div class="form-group">
                <label for="address">Адрес</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= $info['address']; ?>"
                       required>
            </div>
            <input type="submit" class="btn btn-success" value="Сохранить" name="form"/>
        </form>
    </main>

<?php
include "includes/footer.php";
