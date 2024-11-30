<?php
class UserFacade {
private $conn;

public function __construct() {
$this->conn = Database::getInstance()->getConnection();
}

public function getUserOrders($user_id) {
$stmt = $this->conn->prepare("SELECT * FROM orders WHERE
user_id = ? ORDER BY created_at DESC");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
return $result->fetch_all(MYSQLI_ASSOC);
}

public function changePassword($user_id, $new_password) {
$hashed_new_password = password_hash($new_password,
PASSWORD_DEFAULT);
$stmt = $this->conn->prepare("UPDATE users SET password = ?
WHERE id = ?");
$stmt->bind_param("si", $hashed_new_password, $user_id);
return $stmt->execute();
}
}
?>