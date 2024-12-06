<?php
//maintains a list of observers and notifies
class Subject {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function notify($notification, $role) {

        foreach ($this->observers as $observer) {
    
            $observer->update($notification, $role);
    
        }
    
    }
}
?>