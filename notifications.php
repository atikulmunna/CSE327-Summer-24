<?php
include 'components/connect.php';

// Retrieve notifications for the user role from the database
$stmt = $conn->prepare("SELECT message, created_at FROM notifications WHERE role = 'user' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Notifications</title>
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
    <?php include 'components/navbar.php'; ?>
<div>
        <p class="font-pop text-green-900 font-extrabold text-4xl text-center pt-10">Notifications</p>
    </div>
    
    <div class="overflow-x-auto mt-10">
  <table class="table">
    <!-- head -->
    <thead>
      <tr>
        <th>Serial</th>
        <th>Offers</th>
        <th>Published at</th>
      </tr>
    </thead>
    <tbody>
            <?php 
            $serial = 1;
            foreach ($notifications as $notification): ?>
                <tr>
                <th><?= $serial++ ?></th>
                <td><?= htmlspecialchars($notification['message']) ?></td>
                <td><?= $notification['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
            
        
    </tbody>
  </table>
</div>
    
</body>
</html>