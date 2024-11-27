<?php
// FILE: components/ProductFacade.php

class ProductFacade {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addProduct($product_id, $name, $description, $price, $image_url, $product_type) {
        $stmt = $this->conn->prepare("INSERT INTO products (product_id, name, description, price, image_url, product_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdss", $product_id, $name, $description, $price, $image_url, $product_type);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteProduct($product_id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $stmt->close();
    }

    public function updateProduct($product_id, $name, $description, $price, $image_url, $product_type) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, product_type = ? WHERE product_id = ?");
        $stmt->bind_param("ssdsss", $name, $description, $price, $image_url, $product_type, $product_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>