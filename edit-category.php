<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

$id = (int)$_GET['id'];

$info = $db->selectOne('category', '*', 'category_ID=' . $id);
if (!$info)
    header('Location: /');

if (isset($_POST['form'])) {
    $name = $db->escape($_POST['name']);

    $result = $db->update('category', [
        'name' => $name,
    ], 'category_ID = ' . $id);

    if ($result === true) {
        $res = 'success';
        $msg = 'Успешно сохранено';
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}

$info = $db->selectOne('category', '*', 'category_ID=' . $id);
?>

    <main class="container">
        <h2 class="display-4">Редактирование категории</h2>
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $res; ?>">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Категория</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $info['name']; ?>" required>
            </div>
            <input type="submit" class="btn btn-success" value="Сохранить" name="form"/>
        </form>
    </main>

<?php
include "includes/footer.php";
