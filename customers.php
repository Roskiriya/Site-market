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

    $customers = $db->select('coustomer', '*',
        'lower(surname) LIKE lower("%' . $q . '%") OR
        lower(name) LIKE lower("%' . $q . '%") OR
        lower(patronymic) LIKE lower("%' . $q . '%") OR
        lower(numb_card) LIKE lower("%' . $q . '%") OR
        lower(date_of_birth) LIKE lower("%' . $q . '%") OR
        lower(address) LIKE lower("%' . $q . '%")');
} else {
    $customers = $db->select('coustomer');
}

?>
    <main class="container">
        <h2 class="display-4">Покупатели</h2>
        <?php if (isset($q)): ?>
            <h4 class="display-5">Результаты по запросу "<?= $q; ?>"</h4>
        <?php endif; ?>
        <div>
            <a href="/add-customer.php" class="btn btn-primary">Добавить</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Номер карты</th>
                <th>Дата рождения</th>
                <th>Адрес</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= $customer['coustomer_ID']; ?></td>
                    <td><?= $customer['surname']; ?></td>
                    <td><?= $customer['name']; ?></td>
                    <td><?= $customer['patronymic']; ?></td>
                    <td><?= $customer['numb_card']; ?></td>
                    <td><?= $customer['date_of_birth']; ?></td>
                    <td><?= $customer['address']; ?></td>
                    <td class="text-right">
                        <a href="edit-customer.php?id=<?= $customer['coustomer_ID']; ?>" class="btn btn-warning">Изменить</a>
                        <a href="delete.php?type=customer&id=<?= $customer['coustomer_ID']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
include "includes/footer.php";