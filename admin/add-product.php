<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Ensure the image is uploaded before saving product
    if (move_uploaded_file($_FILES['image']['tmp_name'], "../images/product-images/" . $image)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)");
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image
        ]);

        echo "Product added successfully!";
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Add New Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>
        
        <label for="description">Product Description:</label>
        <textarea name="description" required></textarea>
        
        <label for="price">Price:</label>
        <input type="number" name="price" required>
        
        <label for="image">Product Image:</label>
        <input type="file" name="image" required>
        
        <button type="submit">Add Product</button>
    </form>
</body>
</html>
