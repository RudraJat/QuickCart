<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$stmt = $pdo->prepare("
    SELECT o.*, u.email as user_email
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: index.php');
    exit();
}

// Fetch order items
$stmt = $pdo->prepare("
    SELECT oi.*, p.name, p.image_url
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->execute([$order['id']]);
$orderItems = $stmt->fetchAll();

$pageTitle = 'Order Confirmation - RudraShop';
$containerClass = 'max-w-2xl mx-auto';

ob_start();
?>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
    <div class="text-center mb-8">
        <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Order Confirmed!</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Order #<?= $order['id'] ?></p>
    </div>

    <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4 mb-4">
        <h2 class="font-bold text-xl mb-4 text-gray-800 dark:text-white">Order Details</h2>
        <?php foreach ($orderItems as $item): ?>
            <div class="flex items-center mb-4">
                <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                     alt="<?= htmlspecialchars($item['name']) ?>"
                     class="w-16 h-16 object-cover rounded">
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Quantity: <?= $item['quantity'] ?> x $<?= number_format($item['price'], 2) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mb-6">
        <h2 class="font-bold text-xl mb-2 text-gray-800 dark:text-white">Order Summary</h2>
        <p class="text-gray-600 dark:text-gray-400">
            Email: <?= htmlspecialchars($order['user_email']) ?>
        </p>
        <p class="text-gray-600 dark:text-gray-400">
            Date: <?= date('F j, Y', strtotime($order['created_at'])) ?>
        </p>
    </div>

    <div class="text-right border-t border-gray-200 dark:border-gray-700 pt-4">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            Total: $<?= number_format($order['total_amount'], 2) ?>
        </p>
    </div>

    <div class="mt-8 text-center">
        <a href="/Rudra/ecommerce/products.php" 
           class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
            Continue Shopping
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>