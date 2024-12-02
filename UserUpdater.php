<?php
class UserUpdater {
    private $strategy;

    public function setStrategy(UpdateStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function updateUser ($conn, $user_id, $value) {
        return $this->strategy->update($conn, $user_id, $value);
    }
}
?>