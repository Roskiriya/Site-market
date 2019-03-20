<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

if (isset($_POST['form'])) {
    $customer = (int)$_POST['customer'];
    $employee = (int)$_POST['employee'];
    $product = (int)$_POST['product'];
    $col = (int)$_POST['col'];
    $date_selling = $db->escape($_POST['date']);
    $date = date_create($date_selling);
    $date_selling = date_format($date, 'd.m.Y');

    $result = $db->insert('selling', [
        'product ID' => $product,
        'customer_ID' => $customer,
        'employee_ID' => $employee,
        'col' => $col,
        'date selling' => $date_selling,
    ]);

    if ($result === true) {
        $_SESSION['res'] = 'success';
        $_SESSION['msg'] = 'Успешно сохранено';
        header('Location: /selling.php');
    } else {
        $res = 'danger';
        $msg = 'Ошибка сохранения';
    }
}

$today = date('Y-m-d');

$customers = $db->select('coustomer');
$employees = $db->select('employees');
$products = $db->select('products');
?>

    <main class="container">
        <h2 class="display-4">Добавление продажи</h2>
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
                        <option value="<?= $customer['coustomer_ID']; ?>"><?= $customer['surname'] . ' ' .$customer['name'] . ' ' . $customer['patronymic']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="employee">Продавец</label>
                <select name="employee" id="employee" class="form-control">
                    <?php foreach ($employees as $employee): ?>
                        <option value="<?= $employee['employee_ID']; ?>"><?= $employee['surname'] . ' ' .$employee['name'] . ' ' . $employee['patronymic']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product">Товар</label>
                <select name="product" id="product" class="form-control">
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['product_ID']; ?>"><?= $product['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="col">Количество</label>
                <input type="number" class="form-control" id="col" name="col" required step="1" min="1">
            </div>
            <div class="form-group">
                <label for="date">Дата продажи</label>
                <input type="date" class="form-control" id="date" name="date" required max="<?= $today; ?>">
            </div>
            <input type="submit" class="btn btn-success" value="Сохранить" name="form"/>
        </form>
    </main>

<?php
include "includes/footer.php";
