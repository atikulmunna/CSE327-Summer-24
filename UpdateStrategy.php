<?php
interface UpdateStrategy {
    public function update($conn, $user_id, $value);
}
?>