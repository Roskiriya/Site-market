<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

$id = (int)$_GET['id'];

$info = $db->selectOne('selling', '*', 'selling_ID=' . $id);
if (!$info)
    header('Location: /');

if (isset($_POST['form'])) {
    $customer = (int)$_POST['customer'];
    $employee = (int)$_POST['employee'];
    $product = (int)$_POST['product'];
    $col = (int)$_POST['col'];
    $date_selling = $db->escape($_POST['date']);
    $date = date_create($date_selling);
    $date_selling = date_format($date, 'd.m.Y');

    $result = $db->update('selling', [
        'product ID' => $product,
        'customer_ID' => $customer,
        'employee_ID' => $employee,
        'col' => $col,
        'date selling' => $date_selling,
    ], 'selling_ID = ' . $id);

    if ($result === true) {
        $res = 'success';
        $msg = 'Успешно сохранено';
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}

$info = $db->selectOne('selling', '*', 'selling_ID=' . $id);
$date = date_create($info['date selling']);
$info['date selling'] = date_format($date, 'Y-m-d');

$today = date('Y-m-d');

$customers = $db->select('coustomer');
$employees = $db->select('employees');
$products = $db->select('products');
?>

    <main class="container">
        <h2 class="display-4">Редактирование продажи</h2>
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $res; ?>">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="customer">Покупатель</label>
                <select name="customer" id="customer" class="form-control">
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['coustomer_ID']; ?>" <?php if ($customer['coustomer_ID'] == $info['customer_ID']): ?>selected<?php endif; ?>><?= $customer['surname'] . ' ' .$customer['name'] . ' ' . $customer['patronymic']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="employee">Продавец</label>
                <select name="employee" id="employee" class="form-control">
                    <?php foreach ($employees as $employee): ?>
                        <option value="<?= $employee['employee_ID']; ?>" <?php if ($employee['employee_ID'] == $info['employee_ID']): ?>selected<?php endif; ?>><?= $employee['surname'] . ' ' .$employee['name'] . ' ' . $employee['patronymic']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product">Товар</label>
                <select name="product" id="product" class="form-control">
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['product_ID']; ?>" <?php if ($product['product_ID'] == $info['product ID']): ?>selected<?php endif; ?>><?= $product['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="col">Количество</label>
                <input type="number" class="form-control" id="col" name="col"
                       value="<?= $info['col']; ?>" required step="1" min="1">
            </div>
            <div class="form-group">
                <label for="date">Дата продажи</label>
                <input type="date" class="form-control" id="date" name="date"
                       value="<?= $info['date selling']; ?>" required max="<?= $today; ?>">
            </div>
            <input type="submit" class="btn btn-success" value="Сохранить" name="form"/>
        </form>
    </main>

<?php
include "includes/footer.php";
