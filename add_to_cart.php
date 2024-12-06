<?php
session_start();
include 'Cart.php';

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    echo "<script>alert('You need to login to purchase'); window.location.href='sign-in.html';</script>";
    exit();
}

// Check if form data is sent via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product details from POST request
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $qty = $_POST['qty'];

    // Prepare product array
    $product = array(
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'image' => $product_image,
        'qty' => $qty
    );

    // Get the cart instance and add the product
    $cart = Cart::getInstance();
    $cart->addItem($product);

    // Redirect to the cart page
    header('Location: landing-page.php');
    exit();
}
?>