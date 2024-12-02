<?php
session_start();
include 'components/connect.php';

// Check if the user is already a premium member
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'premium') {
    header("Location: landing-page.php");
    exit();
}

// Handle subscription logic (this is just a placeholder, you can add your own logic)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the user's role to premium in the database
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("UPDATE users SET role = 'premium' WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Update the session role
    $_SESSION['user_role'] = 'premium';

    // Redirect to the landing page
    header("Location: landing-page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Subscription</title>
    <link rel="icon" href="images/tab-logo.png" type="image/x-icon">
    <!-- tailwind & daisyui cdn -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-pop">
<div
  class="hero min-h-screen"
  style="background-image: url(images/backdrop-green-leaves.jpg);">
  <div class="hero-overlay bg-opacity-60"></div>
  <div class="hero-content text-neutral-content text-center">
    <div class="max-w-md">
      <h1 class="mb-5 text-4xl font-bold">PlantVerse Premium Subscription</h1>
      <p class="mb-5">
      Enjoy exclusive benefits and features by upgrading to a premium subscription.
      </p>
      <form method="POST" action="premium-subscription.php">
                <button type="submit" class="btn btn-primary mb-4">Upgrade to Premium</button>
            </form>
            <a href="landing-page.php" class="btn btn-outline btn-success">Go to Landing Page</a>
    </div>
  </div>
</div>
    
</body>
</html>