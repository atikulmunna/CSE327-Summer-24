<?php
//defines the update method 
interface Observer {
    public function update(Notification $notification, $role);
}
?>