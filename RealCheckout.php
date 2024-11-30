<?php
include 'components/connect.php';

class RealCheckout implements CheckoutInterface {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function processCheckout($userData, $cartData) {
        $user_id = $userData['user_id'];
        $name = $userData['name'];
        $address = $userData['address'];
        $country = $userData['country'];
        $card_info = $userData['card_info'];
        $card_expiry = $userData['card_expiry'];
        $card_cvc = $userData['card_cvc'];
        $total = $userData['cart_total'] + 5; // Including $5 for shipping

        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, name, address, country, card_info, card_expiry, card_cvc, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssd", $user_id, $name, $address, $country, $card_info, $card_expiry, $card_cvc, $total);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cartData as $item) {
                $stmt->bind_param("iiid", $order_id, $item['id'], $item['qty'], $item['price']);
                $stmt->execute();
            }

            unset($_SESSION['cart']);
            unset($_SESSION['cart_total']);

            echo "<script>alert('Order confirmed'); window.location.href='landing-page.php';</script>";
        }
    }
}
?>