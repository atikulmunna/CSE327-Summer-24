<?php

include 'components/connect.php';

session_start();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    $role = $_POST['role'];
    $role = filter_var($role, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->bind_param('s', $email);
    $select_user->execute();
    $select_user->store_result();

    if ($select_user->num_rows > 0) {
        $message[] = 'Email already exists!';
    } else {
        if ($password != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_user = $conn->prepare("INSERT INTO `users` (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
            $insert_user->bind_param('sssss', $name, $email, $phone, $hashed_password, $role);
            if ($insert_user->execute()) {
                $message[] = 'Registration successful!';
            } else {
                $message[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!-- HTML form for registration -->

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin</title>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    clifford: '#da373d',
                    'plant-primary': '#E76F51',
                    'plant-primary-bg': 'rgba(231, 111, 81, 0.10)',
                }
            }
        }
    }
    </script>
</head>
<body>

<?php include 'components/admin_header.php'; ?>

<section class="form-container">
    <div>
        <p class="font-pop text-green-900 font-extrabold text-4xl text-center pt-10">Register New Admin</p>
    </div>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<p class="text-red-600 text-center mt-5">' . $msg . '</p>';
        }
    }
    ?>

<form class="card-body w-[400px] mx-[570px]" action="" method="post">
    <input type="text" name="name" placeholder="Enter your name" required>
    <input type="email" name="email" placeholder="Enter your email" required>
    <input type="text" name="phone" placeholder="Enter your phone number" required>
    <input type="password" name="password" placeholder="Enter your password" required>
    <input type="password" name="cpass" placeholder="Confirm your password" required>
    <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <input type="submit" name="submit" value="Register">
</form>
</section>

</body>
</html>