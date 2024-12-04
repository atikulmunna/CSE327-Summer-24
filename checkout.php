<?php
include 'components/connect.php';
include 'Order.php';
include 'OrderDecorator.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecting user data from the form
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $card_info = $_POST['card_info'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvc = $_POST['card_cvc'];
    $base_total = $_SESSION['cart_total'] + 5; // Including $5 for shipping

    // Create base order
    $order = new Order($base_total);

    // Check if gift wrap is selected
    if (isset($_POST['gift_wrap']) && $_POST['gift_wrap'] == 'yes') {
        $order = new GiftWrapDecorator($order);
    }

    $total = $order->getTotal();

    // Insert order details into orders table with user_id
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, address, country, card_info, card_expiry, card_cvc, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssd", $user_id, $name, $address, $country, $card_info, $card_expiry, $card_cvc, $total);

    if ($stmt->execute()) {
        // Get the last inserted order ID
        $order_id = $stmt->insert_id;

        // Save order items
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

        foreach ($_SESSION['cart'] as $item) {
            $stmt->bind_param("iiid", $order_id, $item['id'], $item['qty'], $item['price']);
            $stmt->execute();
        }

        // Clear the cart
        unset($_SESSION['cart']);
        unset($_SESSION['cart_total']);
        
        // Display confirmation message and redirect to landing page
        echo "<script>alert('Order confirmed'); window.location.href='landing-page.php';</script>";
    }
}
?>


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
        <div class="join flex justify-center mt-5 gap-5">
            <a href="landing-page.php"><button class="btn btn-outline btn-info">Popular</button></a>
            <a href="Indoor.php"><button class="btn btn-outline btn-success">Indoor</button></a>
            <a href="outdoor.php"><button class="btn btn-outline btn-warning">Outdoor</button></a>
        </div>
    </header>
    <main class="h-screen flex items-center justify-center">
        <!-- cart and payment part -->
        <div class="flex gap-20">
            <!-- cart details -->
            <div class="card w-[600px] bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Cart Summary</h2>
                    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-5 mt-5">
                                    <div class="avatar">
                                        <div class="w-12 mask mask-squircle">
                                            <img src="<?= $item['image'] ?>" />
                                        </div>
                                    </div>
                                    <div>
                                        <p><?= $item['name'] ?></p>
                                        <p>Qty: <span><?= $item['qty'] ?></span></p>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-bold text-xl">$<?= number_format($item['price'] * $item['qty'], 2) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Your cart is empty.</p>
                    <?php endif; ?>
                    <div class="flex justify-between mt-5">
                        <div>
                            <p>Subtotal</p>
                        </div>
                        <div>
                            <p class="font-bold text-xl">$<?= number_format($_SESSION['cart_total'], 2) ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-400">Shipping <br>Within 3-5 working days</p>
                        </div>
                        <div>
                            <p class="font-bold text-xl">$5.00</p>
                        </div>
                    </div>
                    <hr>
                    <div class="flex justify-between">
                        <div>
                            <p class="font-bold text-xl">Total Due</p>
                        </div>
                        <div>
                            <p class="font-bold text-xl">$<?= number_format($_SESSION['cart_total'] + 5, 2) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- payment system -->
            <div class="card w-96 bg-base-100 shadow-xl">
                <div class="card-body">
                    <form method="POST" action="checkout.php">
                        <h2 class="card-title">Shipping Information</h2>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Your Name</span>
                            </div>
                            <input type="text" name="name" placeholder="Type here" class="input input-bordered w-full max-w-xs" required />
                        </label>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Shipping Address</span>
                            </div>
                            <input type="text" name="address" placeholder="Address" class="input input-bordered w-full max-w-xs" required />
                        </label>
                        <label class="form-control w-full max-w-xs">
                            <input type="text" name="country" placeholder="Country" class="input input-bordered w-full max-w-xs" required />
                        </label>
                        <h2 class="card-title mt-5">Payment Details</h2>
                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Card Information</span>
                            </div>
                            <input type="text" name="card_info" placeholder="1234 1234 1234 1234" class="input input-bordered w-full max-w-xs" required />
                        </label>
                        <div class="flex gap-2">
                            <label class="form-control w-full max-w-xs">
                                <input type="text" name="card_expiry" placeholder="MM/YY" class="input input-bordered w-full max-w-xs" required />
                            </label>
                            <label class="form-control w-full max-w-xs">
                                <input type="text" name="card_cvc" placeholder="CVC" class="input input-bordered w-full max-w-xs" required />
                            </label>
                        </div>
                        <button type="submit" class="btn">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>