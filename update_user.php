<?php
include 'components/connect.php';  
session_start();
include 'UpdateStrategy.php';
include 'UpdateName.php';
include 'UpdateEmail.php';
include 'UpdatePhone.php';
include 'UserUpdater.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    
    if (empty($name) || empty($email) || empty($phone)) {
        $_SESSION['error'] = 'All fields are required.';
        header("Location: profile.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format.';
        header("Location: profile.php");
        exit();
    }

    
    $userUpdater = new UserUpdater();

    
    $userUpdater->setStrategy(new UpdateName());
    if (!$userUpdater->updateUser ($conn, $user_id, $name)) {
        $_SESSION['error'] = 'Error updating name. Please try again.';
        header("Location: profile.php");
        exit();
    }

    
    $userUpdater->setStrategy(new UpdateEmail());
    if (!$userUpdater->updateUser ($conn, $user_id, $email)) {
        $_SESSION['error'] = 'Error updating email. Please try again.';
        header("Location: profile.php");
        exit();
    }

    
    $userUpdater->setStrategy(new UpdatePhone());
    if (!$userUpdater->updateUser ($conn, $user_id, $phone)) {
        $_SESSION['error'] = 'Error updating phone. Please try again.';
        header("Location: profile.php");
        exit();
    }

    
    $_SESSION['message'] = 'User  information updated successfully.';
    header("Location: profile.php");
    exit();
} else {
    header("Location: profile.php");
    exit();
}
?>
