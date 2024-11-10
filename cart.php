<?php
include 'includes/db.php'; // Adjust the path if needed based on your file structure
?>

<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    // Store item in cart session
    $_SESSION['cart'][$product_id] = $quantity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Your Cart</h1>
    <div class="cart-items">
        <?php
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
                $stmt->execute(['id' => $product_id]);
                $product = $stmt->fetch();
                ?>
                <div class="cart-item">
                    <h2><?php echo $product['name']; ?></h2>
                    <p>Quantity: <?php echo $quantity; ?></p>
                    <p>Price: $<?php echo $product['price'] * $quantity; ?></p>
                </div>
                <?php
            }
        } else {
            echo "<p>Your cart is empty</p>";
        }
        ?>
    </div>
    <a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
