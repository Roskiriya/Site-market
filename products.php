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

    $products = $db->select(['products', 'category', 'provider'], 'products.*, category.*, provider.provider_ID, provider.`name of_the_organization`',
        '(products.category = category.category_ID AND products.provider = provider.provider_ID) AND (
        lower(products.name) LIKE lower("%' . $q . '%") OR
        lower(price) LIKE lower("%' . $q . '%") OR
        lower(provider.`name of_the_organization`) LIKE lower("%' . $q . '%") OR
        lower(category.name) LIKE lower("%' . $q . '%")
        )');
} else {
    $products = $db->select('products');
}

?>
    <main class="container">
        <h2 class="display-4">Товары</h2>
        <?php if (isset($q)): ?>
            <h4 class="display-5">Результаты по запросу "<?= $q; ?>"</h4>
        <?php endif; ?>
        <div>
            <a href="/add-product.php" class="btn btn-primary">Добавить</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Категория</th>
                <th>Название товара</th>
                <th>Цена</th>
                <th>Поставщик</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_ID']; ?></td>
                    <td><?= $db->selectOne('category', 'name', 'category_ID = ' . $product['category'])['name']; ?></td>
                    <td><?= $product[2]; ?></td>
                    <td><?= $product['price']; ?> р.</td>
                    <td><?= $db->selectOne('provider', '`name of_the_organization`', 'provider_ID = ' . $product['provider'])['name of_the_organization']; ?></td>
                    <td class="text-right">
                        <a href="edit-product.php?id=<?= $product['product_ID']; ?>" class="btn btn-warning">Изменить</a>
                        <a href="delete.php?type=product&id=<?= $product['product_ID']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
include "includes/footer.php";