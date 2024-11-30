<?php
include 'Database.php';
include 'UserFacade.php';
session_start();

// Get user ID from session

$user_id = $_SESSION['user_id'];

$userFacade = new UserFacade();

// Fetch user's previous orders from the database
$orders = $userFacade->getUserOrders($user_id);

// Handle password change
$password_change_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
isset($_POST['change_password'])) {
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

if ($new_password === $confirm_new_password) {
if ($userFacade->changePassword($user_id, $new_password)) {
$password_change_msg = 'Password successfully changed.';
} else {
$password_change_msg = 'Error updating password. Please
try again.';
}
} else {
$password_change_msg = 'New passwords do not match.';
}
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-
scale=1.0">

<title>Profile</title>
<link rel="stylesheet" href="path/to/your/css/file.css">
</head>
<body>
<!-- Your existing HTML content -->
<div>
<h2>Your Orders</h2>
<ul>
<?php foreach ($orders as $order): ?>
<li>Order ID: <?= $order['id'] ?>, Total: <?=
$order['total'] ?>, Date: <?= $order['created_at'] ?></li>
<?php endforeach; ?>
</ul>
</div>
<div>
<h2>Change Password</h2>
<form method="POST" action="profile.php">
<label>
New Password:
<input type="password" name="new_password" required>
</label>

<label>
Confirm New Password:
<input type="password" name="confirm_new_password"
required>
</label>
<button type="submit" name="change_password">Change
Password</button>
</form>
<p><?= $password_change_msg ?></p>
</div>
</body>
</html>