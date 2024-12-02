<?php
interface Observer {
    public function update(Notification $notification, $role);
}
?>