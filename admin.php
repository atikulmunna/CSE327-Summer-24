<?php
include 'components/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['image_url']) && isset($_POST['product_type'])) {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image_url = $_POST['image_url'];
        $product_type = $_POST['product_type'];

        $stmt = $conn->prepare("INSERT INTO products (product_id, name, description, price, image_url, product_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdss", $product_id, $name, $description, $price, $image_url, $product_type);
        $stmt->execute();
        $stmt->close();

        echo "<p class='alert alert-success'>Product added successfully!</p>";
    } elseif (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];

        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("s", $delete_id);
        $stmt->execute();
        $stmt->close();

        echo "<p class='alert alert-success'>Product deleted successfully!</p>";
    } elseif (isset($_POST['update_id']) && isset($_POST['update_name']) && isset($_POST['update_description']) && isset($_POST['update_price']) && isset($_POST['update_image_url']) && isset($_POST['update_product_type'])) {
        $update_id = $_POST['update_id'];
        $name = $_POST['update_name'];
        $description = $_POST['update_description'];
        $price = $_POST['update_price'];
        $image_url = $_POST['update_image_url'];
        $product_type = $_POST['update_product_type'];

        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, product_type = ? WHERE product_id = ?");
        $stmt->bind_param("ssdsss", $name, $description, $price, $image_url, $product_type, $update_id);
        $stmt->execute();
        $stmt->close();

        echo "<p class='alert alert-success'>Product updated successfully!</p>";
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM `products` WHERE product_id = ?");
    $stmt->bind_param("s", $delete_id);
    $stmt->execute();
    $stmt->close();
    header('location:admin.php');
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
<body style="padding-top: 2px;">

<?php include 'components/admin_header.php'; ?>
<div class="container pl-12 pt-5">
    <div class="flex gap-20">
    <!-- Add Product -->
    <form method="POST" class=" card bg-base-100 shadow-xl h-full p-10">
        <p class="text-4xl pb-10">Add Product</p>
        <div class="flex gap-5">
        <div class="mb-3 ">
            <label for="product_id" class="form-label">Product ID</label>
            <input type="text" class="form-control input input-bordered w-full max-w-xs mt-2" id="product_id" name="product_id" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control input input-bordered w-full max-w-xs mt-2" id="name" name="name" required>
        </div>
        </div>
        <div class="flex gap-9">
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control input input-bordered w-full max-w-xs mt-2" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control input input-bordered w-full max-w-xs mt-2" id="price" name="price" required>
        </div>
        </div>
        <div class="flex gap-5">
        <div class="mb-3">
            <label for="image_url" class="form-label">Image URL</label>
            <input type="url" class="form-control input input-bordered w-full max-w-xs mt-2" id="image_url" name="image_url" required>
        </div>
        <div class="mb-3">
            <label for="product_type" class="form-label">Category</label>
            <input type="text" class="form-control input input-bordered w-full max-w-xs mt-2" id="product_type" name="product_type" required>
        </div>
        </div>
        <button type="submit" class="btn btn-primary ">Add Product</button>
    </form>
    <!-- Update products --> 
    <!-- Delete products -->
    </div>
</div>

<!-- cards that are added -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
