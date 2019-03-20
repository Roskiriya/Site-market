<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');

$providers = $db->select('provider');
if (isset($_GET['q'])) {
    $q = urldecode($_GET['q']);
    $q = trim($q);

    $providers = $db->select('provider', '*',
        'lower(`name of_the_organization`) LIKE lower("%' . $q . '%") OR
        lower(`contact_number`) LIKE lower("%' . $q . '%") OR
        lower(`address`) LIKE lower("%' . $q . '%")');
} else {
    $providers = $db->select('provider');
}

?>
    <main class="container">
        <h2 class="display-4">Поставщики</h2>
        <?php if (isset($q)): ?>
            <h4 class="display-5">Результаты по запросу "<?= $q; ?>"</h4>
        <?php endif; ?>
        <div>
            <a href="/add-provider.php" class="btn btn-primary">Добавить</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Название поставщика</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($providers as $provider): ?>
                <tr>
                    <td><?= $provider['provider_ID']; ?></td>
                    <td><?= $provider['name of_the_organization']; ?></td>
                    <td><?= $provider['contact_number']; ?></td>
                    <td><?= $provider['address']; ?></td>
                    <td class="text-right">
                        <a href="edit-provider.php?id=<?= $provider['provider_ID']; ?>" class="btn btn-warning">Изменить</a>
                        <a href="delete.php?type=provider&id=<?= $provider['provider_ID']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
include "includes/footer.php";