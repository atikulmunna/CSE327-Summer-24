<?php
require_once 'components/connect.php';
require_once 'BaseCart.php';
require_once 'CartDecorator.php';

session_start();

// Check if the form is submitted and product_id and qty are set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['qty'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['qty']);

    $cart = new BaseCart();
    $decoratedCart = new CartDecorator($cart);
    $decoratedCart->addProduct($product_id, $quantity);

    // Redirect to the cart page
    header("Location: cart.php");
}