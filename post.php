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
    $q = $db->escape($q);

    $posts = $db->select('post', '*',
        'lower(name) LIKE lower("%' . $q . '%")');
} else {
    $posts = $db->select('post');
}

?>
    <main class="container">
        <h2 class="display-4">Должности</h2>
        <?php if (isset($q)): ?>
            <h4 class="display-5">Результаты по запросу "<?= $q; ?>"</h4>
        <?php endif; ?>
        <div>
            <a href="/add-post.php" class="btn btn-primary">Добавить</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Название должности</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= $post['post_ID']; ?></td>
                    <td><?= $post['name']; ?></td>
                    <td class="text-right">
                        <a href="edit-post.php?id=<?= $post['post_ID']; ?>" class="btn btn-warning">Изменить</a>
                        <a href="delete.php?type=post&id=<?= $post['post_ID']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
include "includes/footer.php";