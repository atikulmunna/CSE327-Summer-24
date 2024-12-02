<?php
class PremiumUser extends User {
    public function __construct($id, $name) {
        parent::__construct($id, $name);
        $this->role = 'premium';
    }

    public function getLandingPage() {
        return 'landing-page.php';
    }

    
}
?>