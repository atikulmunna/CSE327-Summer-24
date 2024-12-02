<?php
class Admin extends User {
    public function __construct($id, $name) {
        parent::__construct($id, $name);
        $this->role = 'admin';
    }

    public function getLandingPage() {
        return 'admin.php';
    }

    
}

?>