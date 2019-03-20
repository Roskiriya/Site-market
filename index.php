<?php
ob_start();
session_start();
include "includes/header.php";

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
}

$db = new DB('db.db');



?>
    <main class="container">

    </main>
<?php
include "includes/footer.php";