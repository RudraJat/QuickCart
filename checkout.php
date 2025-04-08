<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

// Fetch cart items
$stmt = $pdo->prepare("
    SELECT c.*, p.name, p.price, p.sale_price, p.image_url 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$cartItems = $stmt->fetchAll();

// Calculate total
$total = 0;
foreach ($cartItems as $item) {
    $price = $item['sale_price'] ?? $item['price'];
    $total += $price * $item['quantity'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Create order
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_amount, status, shipping_address, created_at)
            VALUES (?, ?, 'pending', ?, NOW())
        ");
        $stmt->execute([
            $_SESSION['user_id'],
            $total,
            $_POST['address']
        ]);
        $orderId = $pdo->lastInsertId();

        // Create order items
        $stmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        foreach ($cartItems as $item) {
            $price = $item['sale_price'] ?? $item['price'];
            $stmt->execute([
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $price
            ]);
        }

        // Clear cart
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);

        $pdo->commit();
        header('Location: order_confirmation.php?id=' . $orderId);
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "An error occurred while processing your order. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - RudraShop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include 'templates/header.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">Checkout</h1>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="flex items-center mb-4">
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                 class="w-16 h-16 object-cover rounded">
                            <div class="ml-4">
                                <h3 class="font-semibold"><?= htmlspecialchars($item['name']) ?></h3>
                                <p class="text-gray-600">
                                    Quantity: <?= $item['quantity'] ?> x 
                                    $<?= number_format($item['sale_price'] ?? $item['price'], 2) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total:</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Shipping Address
                            </label>
                            <textarea name="address" required
                                      class="w-full border rounded-lg px-3 py-2 h-32"
                                      placeholder="Enter your complete shipping address"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include 'templates/footer.php'; ?>
</body>
</html>