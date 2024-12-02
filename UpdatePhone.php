<?php
class UpdatePhone implements UpdateStrategy {
    public function update($conn, $user_id, $value) {
        $stmt = $conn->prepare("UPDATE users SET phone = ? WHERE id = ?");
        $stmt->bind_param("si", $value, $user_id);
        return $stmt->execute();
    }
}
?>