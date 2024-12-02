<?php
session_start();
include 'connect.php';

// Retrieve notifications for the premium role from the database
$stmt = $conn->prepare("SELECT message, created_at FROM notifications WHERE role = 'premium' ORDER BY created_at DESC");
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
    <title>Premium Notifications</title>
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
    <h1>Premium Notifications</h1>
    <ul>
        <?php foreach ($notifications as $notification): ?>
            <li><?= htmlspecialchars($notification['message']) ?> (<?= $notification['created_at'] ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>