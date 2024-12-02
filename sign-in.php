
<?php
include 'signin-classes/user-factory.php';
include 'signin-classes/user-class.php';
include 'signin-classes/premium-user-class.php';
include 'signin-classes/admin-class.php';
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