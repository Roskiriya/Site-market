<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

if (isset($_GET['q'])) {
    $q = urldecode($_GET['q']);
    $q = trim($q);

    $_sellings = $db->select(['selling', 'coustomer', 'employees', 'products'], 'selling.*, coustomer.*, employees.*, products.product_ID, products.name',
        '(selling.customer_ID = coustomer.coustomer_ID AND selling.employee_ID = employees.employee_ID AND selling.`product ID` = products.product_ID) AND (
        lower(selling.col) LIKE lower("%' . $q . '%") OR
        lower(coustomer.surname) LIKE lower("%' . $q . '%") OR
        lower(coustomer.name) LIKE lower("%' . $q . '%") OR
        lower(coustomer.patronymic) LIKE lower("%' . $q . '%") OR
        lower(employees.surname) LIKE lower("%' . $q . '%") OR
        lower(employees.name) LIKE lower("%' . $q . '%") OR
        lower(employees.patronymic) LIKE lower("%' . $q . '%") OR
        lower(products.name) LIKE lower("%' . $q . '%") OR
        lower(selling.`date selling`) LIKE lower("%' . $q . '%")
        )');
} else {
    $_sellings = $db->select('selling');
}
$sellings = array();

foreach ($_sellings as $selling) {
    $customer = $db->selectOne('coustomer', '*', 'coustomer_ID = ' . $selling['customer_ID']);
    $employee = $db->selectOne('employees', '*', 'employee_ID = ' . $selling['employee_ID']);
    $product = $db->selectOne('products', array('name', 'price'), 'product_ID = ' . $selling['product ID']);
    $sellings[] = array(
        'id' => $selling['selling_ID'],
        'customer' => $customer['surname'] . ' ' . $customer['name'] . ' ' . $customer['patronymic'],
        'employee' => $employee['surname'] . ' ' . $employee['name'] . ' ' . $employee['patronymic'],
        'product' => $product['name'],
        'col' => $selling['col'],
        'date selling' => $selling['date selling'],
        'price' => $product['price'] * $selling['col'],
    );
}

?>
    <main class="container">
        <h2 class="display-4">Продажи</h2>
        <?php if (isset($q)): ?>
            <h4 class="display-5">Результаты по запросу "<?= $q; ?>"</h4>
        <?php endif; ?>
        <div>
            <a href="/add-selling.php" class="btn btn-primary">Добавить</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Покупатель</th>
                <th>Продавец</th>
                <th>Товар</th>
                <th>Количество</th>
                <th>Дата продажи</th>
                <th>Стоимость</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sellings as $selling): ?>
                <tr>
                    <td><?= $selling['id']; ?></td>
                    <td><?= $selling['customer']; ?></td>
                    <td><?= $selling['employee']; ?></td>
                    <td><?= $selling['product']; ?></td>
                    <td><?= $selling['col']; ?></td>
                    <td><?= $selling['date selling']; ?></td>
                    <td><?= $selling['price']; ?> р.</td>
                    <td class="text-right">
                        <a href="edit-selling.php?id=<?= $selling['id']; ?>"
                           class="btn btn-warning">Изменить</a>
                        <a href="delete.php?type=selling&id=<?= $selling['id']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
include "includes/footer.php";