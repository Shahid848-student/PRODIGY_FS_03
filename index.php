<?php
include 'db.php';
session_start();

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$cartQuantities = [];
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartQuantities[$item['id']] = $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grocery Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        .product img {
            max-width: 100%;
            height: 140px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .product h3 {
            margin: 5px 0;
        }

        .product p {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }

        .quantity-selector {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
        }

        .quantity-selector button {
            padding: 4px 10px;
            font-size: 16px;
        }

        .quantity-selector input {
            width: 40px;
            text-align: center;
        }

        .added-msg {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }

        .already-added {
            color: #2980b9;
            font-size: 13px;
            margin-top: 5px;
            font-weight: bold;
        }

        .cart-link {
            display: inline-block;
            background: #27ae60;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 30px;
            transition: background 0.3s ease;
        }

        .cart-link:hover {
            background: #1e8449;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>🛒 Grocery Store</h1>

    <div class="products">
        <?php while($row = $result->fetch_assoc()): 
            $existingQty = isset($cartQuantities[$row['id']]) ? $cartQuantities[$row['id']] : 0;
            $unit = (strtolower($row['name']) === 'milk') ? 'litre' : 'kg';
        ?>
            <div class="product">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h3><?php echo $row['name']; ?></h3>
                <p><em><?php echo $row['description']; ?></em></p>
                <p><strong>₹<?php echo $row['price']; ?> per <?php echo $unit; ?></strong></p>

                <form method="post" action="cart.php" class="add-form">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">

                    <div class="quantity-selector">
                        <button type="button" class="minus">-</button>
                        <input type="text" name="quantity" value="1" readonly>
                        <button type="button" class="plus">+</button>
                    </div>

                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <p class="added-msg" style="display:none;">✅ Added!</p>

                    <?php if ($existingQty > 0): ?>
                        <div class="already-added">
                            🧺 Already in Cart: <?php echo $existingQty . ' ' . $unit; ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="center">
        <a href="cart.php" class="cart-link">🧺 Go to Cart</a>
    </div>

    <script>
        const forms = document.querySelectorAll('.add-form');

        forms.forEach(form => {
            const minus = form.querySelector('.minus');
            const plus = form.querySelector('.plus');
            const qtyInput = form.querySelector('input[name="quantity"]');
            const msg = form.querySelector('.added-msg');

            minus.addEventListener('click', () => {
                let qty = parseInt(qtyInput.value);
                if (qty > 1) qtyInput.value = qty - 1;
            });

            plus.addEventListener('click', () => {
                let qty = parseInt(qtyInput.value);
                qtyInput.value = qty + 1;
            });

            form.addEventListener('submit', () => {
                msg.style.display = 'inline';
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 1500);
            });
        });
    </script>
</body>
</html>
