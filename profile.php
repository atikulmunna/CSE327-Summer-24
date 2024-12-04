<?php
include 'components/connect.php';
session_start();

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user's previous orders from the database
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

// Handle password change
$password_change_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
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
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlantVerse</title>
    <link rel="icon" href="images/tab-logo.png" type="image/x-icon">
    <!-- tailwind & daisyui cdn -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- tailwind custom classes -->
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
    <!--custom styles-->
    <style>
        .font-pop {
            font-family: 'Poppins', sans-serif;

        }

        .custom-hr {
            width: 1288px;
            height: 1px;
            background: #1E1E1E;
            border: none;
            margin: 0;
        }
    </style>
</head>

<body class="w-[1519px] h-[1000px] bg-no-repeat bg-cover bg-left"
    style="background-image: url(images/backdrop-green-leaves.jpg)" ;>
    <!-- Header -->
    <header class="md:container md:mx-auto">
        <!-- Nav bar -->
        <?php include 'components/navbar_cart.php'; ?>



        <!-- variety options -->
        <div class="join flex justify-center  mt-5 gap-5">
            <a href="landing-page.php"><button class="btn btn-outline btn-info">Popular</button></a>
            <a href="Indoor.php"><button class="btn btn-outline btn-success">Indoor</button></a>
            <a href="outdoor.php"><button class="btn btn-outline btn-warning">Outdoor</button></a>
        </div>
    </header>
    <main class="h-screen flex items-center justify-center mb-10 mt-5">
        <!-- profile and placed orders -->
        <div class="flex gap-20 mt-10">
            <div class="card w-96 bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-3xl">User Info</h2>
                    <!-- user info change -->
                    <form action="update_user.php" method="POST">
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Your Name</span>
                            </div>
                            <input type="text" name="name" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                        </label>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Your Email Address</span>
                            </div>
                            <input type="email" name="email" placeholder="Email Address" class="input input-bordered w-full max-w-xs" />
                        </label>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Your Phone Number</span>
                            </div>
                            <input type="text" name="phone" placeholder="Phone" class="input input-bordered w-full max-w-xs" />
                        </label>
                        <button type="submit" class="btn btn-primary mt-5">Submit</button>
                        </form>
                        <!-- user password change -->
                        <form action="change_password.php" method="POST" >
                        <h2 class="card-title mt-5">Change Password</h2>
                    <?php if ($password_change_msg): ?>
                        <p class="text-red-500"><?php echo $password_change_msg; ?></p>
                    <?php endif; ?>
                    <form method="POST">
                        <input type="hidden" name="change_password" value="1">
                        <label class="form-control w-full max-w-xs">
                            <span class="label-text">New Password</span>
                            <input type="password" name="new_password" placeholder="Type here" class="input input-bordered w-full max-w-xs" required>
                        </label>
                        <label class="form-control w-full max-w-xs mt-3">
                            <span class="label-text">Confirm New Password</span>
                            <input type="password" name="confirm_new_password" placeholder="Type here" class="input input-bordered w-full max-w-xs" required>
                        </label>
                        <button type="submit" class="btn btn-primary mt-5">Change Password</button>
                    </form>
                </div>
            </div>
            <!-- Order details -->
            <div class="card w-[600px] bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Previous Orders</h2>
                    <?php if ($orders): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="mt-5">
                                <p class="font-bold text-xl">Order ID: <?= $order['id'] ?></p>
                                <p>Order Date: <?= $order['created_at'] ?></p>
                                <p>Status: Placed</p>
                                <p>Total: $<?= $order['total'] ?></p>
                                <hr class="mt-3">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No previous orders found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </main>
    <?php include 'components/footer.php'; ?>

</body>

</html>