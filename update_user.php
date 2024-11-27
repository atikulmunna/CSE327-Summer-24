<?php
include 'components/connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare and execute SQL statement to update user information
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);

    if ($stmt->execute()) {
        // User information updated successfully
        $_SESSION['message'] = 'User information updated successfully.';
        header("Location: profile.php"); // Redirect to profile page or any other appropriate page
        exit();
    } else {
        // Error updating user information
        $_SESSION['error'] = 'Error updating user information. Please try again.';
        header("Location: profile.php"); // Redirect to profile page or any other appropriate page
        exit();
    }
} else {
    // Redirect to profile page if form is not submitted
    header("Location: profile.php");
    exit();
}
?>