<?php
include 'components/connect.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">

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

    <section class="accounts">
        <h3 class="font-pop text-center text-5xl font-bold text-green-950 mt-10">Orders</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 m-10">
            <?php
            $select_order = $conn->prepare("SELECT * FROM `orders`");
            $select_order->execute();
            $result = $select_order->get_result();

            if ($result->num_rows > 0) {
                while ($fetch_order = $result->fetch_assoc()) {
                    ?>
                    <div class="card w-96 bg-base-100 shadow-xl p-5">
                        <div class="text-center">
                            <p class="font-bold text-3xl pb-3"> Order ID : <span><?= $fetch_order['id']; ?></span> </p>
                            <p class="text-xl mb-5"> Username : <span><?= $fetch_order['name']; ?></span> </p>
                            <p class="text-xl mb-5"> Address : <span><?= $fetch_order['address']; ?></span> </p>
                            <p class="text-xl"> Total Amount : <span><?= $fetch_order['total']; ?></span> </p>
                        </div>
                        
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no orders available!</p>';
            }
            $select_order->close();
            ?>

        </div>
    </section>

</body>

</html>