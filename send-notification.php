<?php
session_start();
include 'components/connect.php';
include 'components/Notification.php';
include 'components/NotificationObserver.php';
include 'components/Subject.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['message']) && isset($_POST['role'])) {
        $message = $_POST['message'];
        $role = $_POST['role'];

        // Create a notification
        $notification = new Notification($message);

        // Create a subject and attach an observer
        $subject = new Subject();
        $observer = new NotificationObserver();
        $subject->attach($observer);

        // Notify the observer with the role
        $subject->notify($notification, $role);

        // Store the notification in the database
        $stmt = $conn->prepare("INSERT INTO notifications (role, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $role, $message);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];

        // Delete the notification from the database
        $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Retrieve notifications for the user role from the database
$stmt = $conn->prepare("SELECT id, message, created_at FROM notifications WHERE role = 'user' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$user_notifications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Retrieve notifications for the premium role from the database
$stmt = $conn->prepare("SELECT id, message, created_at FROM notifications WHERE role = 'premium' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$premium_notifications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Send Notification</title>
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
    <form method="POST" action="send-notification.php" >

        <input type="text" placeholder="Message" class="input input-bordered input-success w-full max-w-xs ml-10 mt-10" type="text"
            id="message" name="message" required />

        <br>
        
        <select class="select select-accent w-full max-w-xs ml-10 mt-5" id="role" name="role" required>
            <option disabled selected>Which user?</option>
            <option value="user">User</option>
            <option value="premium">Premium</option>
            
        </select>
        
        <br>
    

        <button class="btn btn-outline btn-success ml-10 mt-5" type="submit">Send Notification</button>
    </form>
    <div class="overflow-x-auto">
  <table class="table">
  <h2 class="text-center font-pop font-semibold text-lime-600 text-3xl mt-10">User Notifications</h2>
    <!-- head -->
    <thead>
      <tr>
        <th></th>
        <th>Message</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php $serial = 1;
     foreach ($user_notifications as $notification): ?>
        
            <tr>
            <th><?= $serial++ ?></th>
                <td><?= htmlspecialchars($notification['message']) ?></td>
                <td><?= $notification['created_at'] ?></td>
                <td>
                    <form method="POST" action="send-notification.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $notification['id'] ?>">
                        <button type="submit" class="btn btn-outline btn-error btn-xs">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
</div>


    
    <div class="overflow-x-auto">
  <table class="table">
  <h2 class="text-center font-pop font-semibold text-lime-600 text-3xl mt-10">Premium Notifications</h2>
    <!-- head -->
    <thead>
      <tr>
        <th></th>
        <th>Message</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php $serial = 1;
     foreach ($premium_notifications as $notification): ?>
        
            <tr>
            <th><?= $serial++ ?></th>
                <td><?= htmlspecialchars($notification['message']) ?></td>
                <td><?= $notification['created_at'] ?></td>
                <td>
                    <form method="POST" action="send-notification.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $notification['id'] ?>">
                        <button type="submit" class="btn btn-outline btn-error btn-xs">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
</div>
    
</body>

</html>