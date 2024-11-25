<?php
include 'components/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and trim whitespace
    $user = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $pass = trim($_POST['password']);
    $confirm_pass = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($pass !== $confirm_pass) {
        die("Passwords do not match. Please try again.");
    }

    // Hash the password
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Escape special characters for SQL
    $user = $conn->real_escape_string($user);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        die("Email already registered. Please use a different email.");
    }
    $stmt_check->close();

    // Construct the SQL query
    $sql = "INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user, $email, $phone, $hashed_pass);

    if ($stmt->execute() === TRUE) {
        echo "<script> window.location.href = 'sign-in.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>