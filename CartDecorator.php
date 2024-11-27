<?php
require_once 'BaseCart.php';

class CartDecorator {
    protected $cart;

    public function __construct(BaseCart $cart) {
        $this->cart = $cart;
    }

    public function addProduct($product_id, $quantity) {
        $this->cart->addProduct($product_id, $quantity);
    }
}
?>