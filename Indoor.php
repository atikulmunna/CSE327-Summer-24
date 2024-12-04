<?php
  include 'components/connect.php';

$result = $conn->query("SELECT * FROM products ");
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    .cards-container {
            margin: 0 50px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }
        .card {
            width: calc(33.333% - 20px);
            box-sizing: border-box;
        }
        .card img {
            width: 100%;
        }
  </style>
</head>

<body class="font-pop">
  <!-- Header -->
  <header class="md:container md:mx-auto">
    <!-- Nav bar -->
    <?php include 'components/navbar.php'; ?>




    <!-- slider -->
    <?php include 'components/slider.php'; ?>

    <!-- variety options -->
    <div class="join flex justify-center my-4 gap-5">
      <a href="landing-page.php"><button class="btn btn-outline btn-info">Popular</button></a>
      <a href="Indoor.php"><button class="btn btn-outline btn-success">Indoor</button></a>
      <a href="outdoor.php"><button class="btn btn-outline btn-warning">Outdoor</button></a>
    </div>
  </header>

  <main>
    <!-- indoor carts 01-->
<div class="cards-container grid grid-cols-3  mt-10 ml-[100px] mb-10">
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php if ($row['product_type'] === 'indoor'): ?>
            <div class="card w-96 bg-base-100 shadow-xl  mt-10">
                        <figure>
                            <img src="<?= $row['image_url'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title"><?= $row['name'] ?></h2>
                            <p><?= $row['description'] ?></p>
                            <div class="card-actions flex items-center justify-between mt-5">
                                <p class="text-2xl"><strong>$<?= $row['price'] ?></strong></p>
                                <div class="mr-4">
                                <form action="add_to_cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
                                    <input type="hidden" name="product_image" value="<?= $row['image_url'] ?>">
                                    <div class="flex items-center">
                                    <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                                    <input type="number" name="qty" placeholder="qty" class="input input-bordered input-sm w-full max-w-xs mr-3" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                                    <button type="submit" class="btn btn-success">Buy Now</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>

       
  </main>

  <?php include 'components/footer.php'; ?>

</body>

</html>