<?php
session_start();

// Add or update cart
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = (int)$_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $updated = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] = $quantity;
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    header("Location: index.php");
    exit();
}

// Remove item
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>🧺 Your Shopping Cart</h1>

    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
                $grandTotal = 0;
                foreach ($_SESSION['cart'] as $item):
                    $total = $item['price'] * $item['quantity'];
                    $grandTotal += $total;
                    $unit = (strtolower($item['name']) === 'milk') ? 'litre' : 'kg';
            ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['quantity'] . ' ' . $unit; ?></td>
                <td>₹<?php echo $item['price']; ?></td>
                <td>₹<?php echo $total; ?></td>
                <td><a href="cart.php?remove=<?php echo $item['id']; ?>">❌ Remove</a></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Grand Total</strong></td>
                <td colspan="2"><strong>₹<?php echo $grandTotal; ?></strong></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:center;">
                    <a href="checkout.php" class="cart-link">✅ Proceed to Checkout</a>
                </td>
            </tr>
        </table>
    <?php else: ?>
        <p style="text-align:center;">Your cart is empty.</p>
    <?php endif; ?>

    <div style="text-align:center; margin-top: 30px;">
        <a href="index.php" class="cart-link">🛒 Back to Store</a>
    </div>
</body>
</html>
