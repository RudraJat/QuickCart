<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

// Fetch order details
$stmt = $pdo->prepare("
    SELECT o.*, u.email as user_email
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: account.php');
    exit();
}

// Fetch order items with product details
$stmt = $pdo->prepare("
    SELECT oi.*, p.name, p.image_url, p.description
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->execute([$order['id']]);
$orderItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #<?= $order['id'] ?> - QuickCart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <?php include 'templates/header.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Order Details #<?= $order['id'] ?>
                </h1>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    <?= $order['status'] === 'completed' 
                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' ?>">
                    <?= ucfirst($order['status']) ?>
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Order Information</h2>
                    <div class="text-gray-600 dark:text-gray-400">
                        <p>Order Date: <?= date('F j, Y g:i A', strtotime($order['created_at'])) ?></p>
                        <p>Email: <?= htmlspecialchars($order['user_email']) ?></p>
                        <p>Total Amount: $<?= number_format($order['total_amount'], 2) ?></p>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Shipping Address</h2>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                        <?= htmlspecialchars($order['shipping_address']) ?>
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Order Items</h2>
                <div class="space-y-4">
                    <?php foreach ($orderItems as $item): ?>
                        <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                 class="w-24 h-24 object-cover rounded-lg">
                            
                            <div class="ml-6 flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    <?= htmlspecialchars($item['name']) ?>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                    <?= htmlspecialchars($item['description']) ?>
                                </p>
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Quantity: <?= $item['quantity'] ?>
                                    </p>
                                    <p class="font-semibold text-gray-800 dark:text-white">
                                        $<?= number_format($item['price'], 2) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-8 flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-6">
                <a href="/Rudra/ecommerce/account.php" 
                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Account
                </a>
                <div class="text-xl font-bold text-gray-800 dark:text-white">
                    Total: $<?= number_format($order['total_amount'], 2) ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'templates/footer.php'; ?>
    <script src="/Rudra/ecommerce/assets/js/theme.js"></script>
</body>
</html>