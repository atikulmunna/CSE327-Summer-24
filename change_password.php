<?php
include 'components/connect.php';
session_start();

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Handle password change
$password_change_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if ($new_password === $confirm_new_password) {
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_new_password, $user_id);
        if ($stmt->execute()) {
            $password_change_msg = 'Password successfully changed.';
        } else {
            $password_change_msg = 'Error updating password. Please try again.';
        }
    } else {
        $password_change_msg = 'New passwords do not match.';
    }

    // Redirect back to profile page with a message
    echo "<script>alert('$password_change_msg'); window.location.href='profile.php';</script>";
    exit();
} else {
    echo "<script>alert('Invalid request method.'); window.location.href='profile.php';</script>";
    exit();
}

