<?php
session_start();
include 'components/connect.php';
include 'components/Notification.php';
include 'components/NotificationObserver.php';
include 'components/Subject.php';

$subject = new Subject();
$attachedRoles = [];

if (isset($_SESSION['attached_roles'])) {
    $attachedRoles = $_SESSION['attached_roles'];
} else {
    $_SESSION['attached_roles'] = $attachedRoles;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['message'])) {
        $message = $_POST['message'];

        // Create a notification
        $notification = new Notification($message);

        // Notify all attached observers
        foreach ($attachedRoles as $role) {
            $observer = new NotificationObserver();
            $subject->attach($observer);
        }

        $subject->notify($notification, null);

        // Store the notification in the database
        $stmt = $conn->prepare("INSERT INTO notifications (role, message) VALUES (?, ?)");
        foreach ($attachedRoles as $role) {
            $stmt->bind_param("ss", $role, $message);
            $stmt->execute();
        }
        $stmt->close();
    } elseif (isset($_POST['attach_observer'])) {
        $role = $_POST['role'];
        if (!in_array($role, $attachedRoles)) {
            $attachedRoles[] = $role;
            $_SESSION['attached_roles'] = $attachedRoles;
            echo "<p class='alert alert-success'>Observer for role $role attached successfully!</p>";
        }
    } elseif (isset($_POST['detach_observer'])) {
        $role = $_POST['role'];
        if (($key = array_search($role, $attachedRoles)) !== false) {
            unset($attachedRoles[$key]);
            $_SESSION['attached_roles'] = $attachedRoles;
            echo "<p class='alert alert-success'>Observer for role $role detached successfully!</p>";
        }
    }
elseif (isset($_POST['delete_id'])) {
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
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Send Notification</h1>
        <form method="POST" action="send-notification.php">
            <input type="text" placeholder="Message" class="input input-bordered input-success w-full max-w-xs ml-10 mt-10" id="message" name="message" required />
            <br>
            <button type="submit" class="btn btn-primary ml-10 mt-5">Send Notification</button>
        </form>

        <h2 class="text-xl font-bold mt-10">Manage Observers</h2>
        <form method="POST" action="send-notification.php" class="mt-5">
            <select class="select select-accent w-full max-w-xs ml-10 mt-5" id="role" name="role" required>
                <option disabled selected>Select role to attach/detach</option>
                <option value="user">User</option>
                <option value="premium">Premium</option>
            </select>
            <br>
            <button type="submit" name="attach_observer" class="btn btn-success ml-10 mt-5">Attach Observer</button>
            <button type="submit" name="detach_observer" class="btn btn-warning ml-10 mt-5">Detach Observer</button>
        </form>
    </div>
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