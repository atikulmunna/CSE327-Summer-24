<?php
include 'components/connect.php';

session_start();

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_user->bind_param("i", $delete_id);
    $delete_user->execute();
    $delete_user->close();
    header('location:admin-usersAccount.php');
    exit();
}

if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];
    $update_role = $conn->prepare("UPDATE `users` SET role = ? WHERE id = ?");
    $update_role->bind_param("si", $new_role, $user_id);
    $update_role->execute();
    $update_role->close();
    header('location:admin-usersAccount.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin - User Accounts</title>
</head>
<body>
<?php include 'components/admin_header.php'; ?>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">User Accounts</h1>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();
                $result = $select_users->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>{$row['id']}</td>";
                    echo "<td class='border px-4 py-2'>{$row['name']}</td>";
                    echo "<td class='border px-4 py-2'>{$row['email']}</td>";
                    echo "<td class='border px-4 py-2'>{$row['phone']}</td>";
                    echo "<td class='border px-4 py-2'>
                            <form method='POST' action='admin-usersAccount.php'>
                                <input type='hidden' name='user_id' value='{$row['id']}'>
                                <select name='role' class='select select-bordered'>
                                    <option value='user' " . ($row['role'] == 'user' ? 'selected' : '') . ">User</option>
                                    <option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Admin</option>
                                    <option value='premium' " . ($row['role'] == 'premium' ? 'selected' : '') . ">Premium</option>
                                </select>
                                <button type='submit' name='update_role' class='btn btn-primary ml-2'>Update</button>
                            </form>
                          </td>";
                    echo "<td class='border px-4 py-2'>
                            <a href='admin-usersAccount.php?delete={$row['id']}' class='btn btn-error'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                $select_users->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>