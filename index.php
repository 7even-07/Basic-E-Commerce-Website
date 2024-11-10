<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Our Products</h1>
    <div class="product-list">
        <?php
        $stmt = $conn->query("SELECT * FROM products");
        while ($product = $stmt->fetch()) {
        ?>
            <div class="product-item">
                <img src="images/product-images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo $product['description']; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <a href="products/product.php?id=<?php echo $product['id']; ?>">View Product</a>
            </div>
        <?php
        }
        ?>
    </div>
</body>
</html>
