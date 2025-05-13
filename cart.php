<?php
// cart.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menuId = $_POST['menu_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    if (isset($_SESSION['cart'][$menuId])) {
        $_SESSION['cart'][$menuId]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$menuId] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }

    header('Location: view_cart.php');
    exit();
}
?>
