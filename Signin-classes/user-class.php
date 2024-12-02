<?php
class User {
    protected $id;
    protected $name;
    protected $role;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
        $this->role = 'user';
    }

    public function getRole() {
        return $this->role;
    }

    public function getLandingPage() {
        return 'landing-page.php';
    }

    
}


?>