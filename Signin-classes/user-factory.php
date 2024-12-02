<?php
class UserFactory {
    public static function createUser($id, $name, $role) {
        switch ($role) {
            case 'admin':
                return new Admin($id, $name);
            case 'premium':
                return new PremiumUser($id, $name);
            default:
                return new User($id, $name);
        }
    }
}
?>