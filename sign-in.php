<?php
//factory design pattern
class UserFactory {
    public static function createUser($id, $name, $role) {
        if ($role == 'admin') {
            return new Admin($id, $name);
        } else {
            return new User($id, $name);
        }
    }
}
?>
<?php
class User {
    protected $email;
    protected $name;

    public function __construct($email, $name) {
        $this->email = $email;
        $this->name = $name;
    }

    public function getLandingPage() {
        return 'landing-page.php';
    }
}
?>
<?php
class Admin extends User {
    public function getLandingPage() {
        return 'admin-panel.php';
    }
}
?>
<?php
session_start();
require_once 'UserFactory.php';
require_once 'User.php';
require_once 'Admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $servername = "localhost";
    $db_username = "root"; // Update this if your DB username is different
    $db_password = "";     // Update this if your DB password is different
    $dbname = "plantverse";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Create user object using factory
            $user = UserFactory::createUser($id, $name, $role);

            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;

            // Redirect to the appropriate landing page
            header("Location: " . $user->getLandingPage());
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>