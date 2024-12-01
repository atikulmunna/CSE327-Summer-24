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
        return 'landing.php';
    }

    public function renderView() {
        include 'navbar.php';
        
    }
}

class Admin extends User {
    public function __construct($id, $name) {
        parent::__construct($id, $name);
        $this->role = 'admin';
    }

    public function getLandingPage() {
        return 'admin.php';
    }

    public function renderView() {
        include 'navbar.php';
        
    }
}

class PremiumUser extends User {
    public function __construct($id, $name) {
        parent::__construct($id, $name);
        $this->role = 'premium';
    }

    public function getLandingPage() {
        return 'landing.php';
    }

    public function renderView() {
        include 'navbarPremium.php';
        
    }
}
?>


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



<?php
include 'components/connect.php';


session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $stmt = $conn->prepare("SELECT id, name, role, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $role, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Create user instance using the factory
        $user = UserFactory::createUser($id, $name, $role);

        // Store user information in session
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;

        // Redirect to the appropriate landing page
        header("Location: " . $user->getLandingPage());
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>