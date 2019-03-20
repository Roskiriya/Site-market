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

    $employees = $db->select(['employees', 'post'], 'employees.*, post.*',
        'employees.post_ID = post.post_ID AND (
        lower(surname) LIKE lower("%' . $q . '%") OR
        lower(employees.name) LIKE lower("%' . $q . '%") OR
        lower(patronymic) LIKE lower("%' . $q . '%") OR
        lower(post.name) LIKE lower("%' . $q . '%") OR
        lower(phone) LIKE lower("%' . $q . '%") OR
        lower(date_of_birth) LIKE lower("%' . $q . '%") OR
        lower(address) LIKE lower("%' . $q . '%")
        )');
} else {
    $employees = $db->select('employees');
}

?>
    <main class="container">
        <h2 class="display-4">Продавцы</h2>
        <?php if (isset($q)): ?>
            <h4 class="display-5">Результаты по запросу "<?= $q; ?>"</h4>
        <?php endif; ?>
        <div>
            <a href="/add-employee.php" class="btn btn-primary">Добавить</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Должность</th>
                <th>Адрес</th>
                <th>Номер телефона</th>
                <th>Дата рождения</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $employee['employee_ID']; ?></td>
                    <td><?= $employee['surname']; ?></td>
                    <td><?= $employee['name']; ?></td>
                    <td><?= $employee['patronymic']; ?></td>
                    <td><?= $db->selectOne('post', 'name', 'post_ID = ' . $employee['post_ID'])['name']; ?></td>
                    <td><?= $employee['address']; ?></td>
                    <td><?= $employee['phone']; ?></td>
                    <td><?= $employee['date_of_birth']; ?></td>
                    <td class="text-right">
                        <a href="edit-employee.php?id=<?= $employee['employee_ID']; ?>" class="btn btn-warning">Изменить</a>
                        <a href="delete.php?type=employee&id=<?= $employee['employee_ID']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
include "includes/footer.php";