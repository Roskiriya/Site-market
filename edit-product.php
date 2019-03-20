<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

$id = (int)$_GET['id'];

$info = $db->selectOne('products', '*', 'product_ID=' . $id);
if (!$info)
    header('Location: /');

if (isset($_POST['form'])) {
    $name = $db->escape($_POST['name']);
    $price = (float)$_POST['price'];
    $category = (int)$_POST['category'];
    $provider = (int)$_POST['provider'];

    $result = $db->update('products', [
        'name' => $name,
        'price' => $price,
        'category' => $category,
        'provider' => $provider,
    ], 'product_ID = ' . $id);

    if ($result === true) {
        $res = 'success';
        $msg = 'Успешно сохранено';
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}

$info = $db->selectOne('products', '*', 'product_ID=' . $id);

$categories = $db->select('category');
$providers = $db->select('provider');
?>

    <main class="container">
        <h2 class="display-4">Редактирование товара</h2>
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $res; ?>">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $info['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Цена</label>
                <input type="number" class="form-control" id="price" name="price"
                       value="<?= $info['price']; ?>" required step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="category">Категория</label>
                <select name="category" id="category" class="form-control">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_ID']; ?>" <?php if ($category['category_ID'] == $info['category']): ?>selected<?php endif; ?>><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="provider">Поставщик</label>
                <select name="provider" id="provider" class="form-control">
                    <?php foreach ($providers as $provider): ?>
                        <option value="<?= $provider['provider_ID']; ?>" <?php if ($provider['provider_ID'] == $info['provider']): ?>selected<?php endif; ?>><?= $provider['name of_the_organization']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="submit" class="btn btn-success" value="Сохранить" name="form"/>
        </form>
    </main>

<?php
include "includes/footer.php";
