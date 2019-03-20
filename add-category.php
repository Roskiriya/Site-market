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

    $result = $db->insert('category', [
        'name' => $name,
    ]);

    if ($result === true) {
        $_SESSION['res'] = 'success';
        $_SESSION['msg'] = 'Успешно сохранено';
        header('Location: /categories.php');
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}
?>

    <main class="container">
        <h2 class="display-4">Добавление категории</h2>
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $res; ?>">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Категория</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <input type="submit" class="btn btn-success" value="Сохранить" name="form"/>
        </form>
    </main>

<?php
include "includes/footer.php";
