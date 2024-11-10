<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session to access $_SESSION

include 'includes/db.php'; // Include the database connection

// Initialize variables
$cartItems = [];
$total = 0;

// Assuming the cart is stored in the session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Fetch product details from the database
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);
        $product = $stmt->fetch();

        // Check if the product exists
        if ($product) {
            $product['quantity'] = $quantity; // Add quantity to product array
            $cartItems[] = $product; // Append product to cart items
            $total += $product['price'] * $quantity; // Calculate total
        }
    }
} else {
    echo "<p>Your cart is empty.</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>

    <?php if (!empty($cartItems)): ?>
        <h2>Your Cart:</h2>
        <ul>
            <?php foreach ($cartItems as $item): ?>
                <li><?php echo htmlspecialchars($item['name']); ?> (x<?php echo htmlspecialchars($item['quantity']); ?>) - $<?php echo number_format($item['price'], 2); ?></li>
            <?php endforeach; ?>
        </ul>
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
        <form action="process-checkout.php" method="POST">
            <button type="submit">Place Order</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>
