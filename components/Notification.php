<?php
class Notification {
    private $message;

    public function __construct($message) {
        $this->message = $message;
    }
//It allows other parts of the code to access the notification message stored in the instance.
    public function getMessage() {
        return $this->message;
    }
}
?>