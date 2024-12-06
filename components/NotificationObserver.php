<?php
include 'Observer.php';

class NotificationObserver implements Observer {
    private $notifications = [];
//method is called by the subject to notify the observer 
    public function update(Notification $notification, $role) {
        if (!isset($this->notifications[$role])) {
            $this->notifications[$role] = [];
        }
        $this->notifications[$role][] = $notification->getMessage();
        // Store the notification in the session for simplicity
        if (!isset($_SESSION['notifications'][$role])) {
            $_SESSION['notifications'][$role] = [];
        }
        $_SESSION['notifications'][$role][] = $notification->getMessage();
    }

    public function getNotifications($role) {
        return isset($this->notifications[$role]) ? $this->notifications[$role] : [];
    }
}
?>