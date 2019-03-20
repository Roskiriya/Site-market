<?php
ob_start();
session_start();
include "includes/header.php";

$db = new DB('db.db');

$type = $_GET['type'];
$id = (int)$_GET['id'];

$table = '';
$text = '';
$field = '';
$return = '';
switch ($type) {
    case 'category':
        $table = 'category';
        $text = 'категорию';
        $field = 'category_ID';
        $return = 'categories.php';
        break;
    case 'customer':
        $table = 'coustomer';
        $text = 'покупателя';
        $field = 'coustomer_ID';
        $return = 'customers.php';
        break;
    case 'employee':
        $table = 'employees';
        $text = 'продавца';
        $field = 'employee_ID';
        $return = 'employees.php';
        break;
    case 'post':
        $table = 'post';
        $text = 'должность';
        $field = 'post_ID';
        $return = 'post.php';
        break;
    case 'product':
        $table = 'products';
        $text = 'товар';
        $field = 'product_ID';
        $return = 'products.php';
        break;
    case 'provider':
        $table = 'provider';
        $text = 'поставщика';
        $field = 'provider_ID';
        $return = 'providers.php';
        break;
    case 'selling':
        $table = 'selling';
        $text = 'продажу';
        $field = 'selling_ID';
        $return = 'selling.php';
        break;
    default:
        exit();
}

$error = false;
if (isset($_POST['delete'])) {
    $result = $db->delete($table, $field . ' = ' . $id);

    if (!$result) {
        $error = 'Ошибка базы данных';
    } else {
        $_SESSION['res'] = 'success';
        $_SESSION['msg'] = 'Удалено';
        header('Location: /' . $return);
    }
}

$item = $db->selectOne($table, $field, $field . ' = ' . $id);
if (!$item) header('Location: /' . $return);

?>
    <main class="container">
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $error ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="display-4">Удалить <?= $text; ?>? Отменить будет невозможно!</h2>
                <form action="" method="post">
                    <input type="hidden" name="delete" value="<?= $post['ID']; ?>">
                    <button class="btn btn-success btn-lg" type="submit">Да</button>
                    <a href="/<?= $return; ?>" class="btn btn-danger btn-lg">Нет</a>
                </form>
            </div>
        </div>
    </main>
<?php
include "includes/footer.php";
