<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

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
    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_password FROM admin WHERE admin_email = ?");
    $stmt->bind_param("s", $admin_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $admin_name, $hashed_password);
        $stmt->fetch();

        // Debugging: Display the hashed password retrieved from the database
        echo "Hashed Password from DB: " . htmlspecialchars($hashed_password) . "<br>";
        echo "Entered Password: " . htmlspecialchars($admin_password) . "<br>";
        
        if (password_verify($admin_password, $hashed_password)) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;
            header("Location: admin.php");
            exit; // Always exit after redirecting
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No admin found with that email address.";
    }

    $stmt->close();
    $conn->close();
}
?>
