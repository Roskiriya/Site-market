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

    $categories = $db->select('category', '*',
        'lower(name) LIKE lower("%' . $q . '%")');
} else {
    $categories = $db->select('category');
}

?>
    <main class="container">
        <h2 class="display-4">Категории</h2>
        <?php if (isset($q)): ?>
            <h4 class="display-5">Результаты по запросу "<?= $q; ?>"</h4>
        <?php endif; ?>
        <div>
            <a href="/add-category.php" class="btn btn-primary">Добавить</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Название категории</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['category_ID']; ?></td>
                    <td><?= $category['name']; ?></td>
                    <td class="text-right">
                        <a href="edit-category.php?id=<?= $category['category_ID']; ?>" class="btn btn-warning">Изменить</a>
                        <a href="delete.php?type=category&id=<?= $category['category_ID']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
include "includes/footer.php";