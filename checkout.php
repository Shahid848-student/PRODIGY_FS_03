<?php
session_start();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header("Location: index.php");
    exit();
}

$grandTotal = 0;
$items = [];

foreach ($_SESSION['cart'] as $item) {
    $unit = (strtolower($item['name']) === 'milk') ? 'litre' : 'kg';
    $line = $item['name'] . ': ' . $item['quantity'] . ' ' . $unit;
    $items[] = $line;
    $grandTotal += $item['price'] * $item['quantity'];
}

// Clear cart
$_SESSION['cart'] = [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>✅ Order Placed!</h1>
    <p style="text-align:center;"><strong>Items:</strong><br>
    <?php foreach ($items as $line): ?>
        <?php echo $line; ?><br>
    <?php endforeach; ?></p>

    <p style="text-align:center;">Your total bill: <strong>₹<?php echo $grandTotal; ?></strong></p>
    <p style="text-align:center;">Thank you for shopping! 😊</p>

    <div style="text-align:center; margin-top:30px;">
        <a href="index.php" class="cart-link">🛍 Back to Store</a>
    </div>
</body>
</html>
