<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

$stmt = $pdo->prepare("
    SELECT c.*, p.name, p.price, p.sale_price, p.image_url 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$cartItems = $stmt->fetchAll();

$total = 0;

$pageTitle = 'Shopping Cart - QuickCart';
$containerClass = 'max-w-5xl mx-auto';

ob_start();
?>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 md:p-8">
    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-gray-800 dark:text-white">Your Shopping Cart</h2>
    
    <?php if (empty($cartItems)): ?>
        <div class="text-center py-12">
            <i class="fas fa-shopping-cart text-gray-300 dark:text-gray-600 text-5xl md:text-6xl mb-4"></i>
            <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl mb-6">Your cart is empty</p>
            <a href="/Rudra/ecommerce/products.php" 
               class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                Continue Shopping
            </a>
        </div>
    <?php else: ?>
        <div class="space-y-4 md:space-y-6">
            <?php foreach ($cartItems as $item): 
                $price = $item['sale_price'] ?? $item['price'];
                $total += $price * $item['quantity'];
            ?>
                <div class="flex flex-col md:flex-row items-start md:items-center border dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition duration-300">
                    <div class="flex items-center w-full md:w-auto">
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>" 
                             class="w-24 h-24 md:w-32 md:h-32 object-cover rounded-lg">
                        
                        <div class="ml-4 flex-grow">
                            <h3 class="text-lg md:text-xl font-bold text-gray-800 dark:text-white">
                                <?= htmlspecialchars($item['name']) ?>
                            </h3>
                            <div class="flex items-center mt-2">
                                <span class="text-xl md:text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                    $<?= number_format($price, 2) ?>
                                </span>
                                <?php if (isset($item['sale_price'])): ?>
                                    <span class="ml-2 text-sm text-gray-400 dark:text-gray-500 line-through">
                                        $<?= number_format($item['price'], 2) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between w-full md:w-auto mt-4 md:mt-0 md:ml-6">
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(<?= $item['id'] ?>, Math.max(1, <?= $item['quantity'] ?> - 1))" 
                                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                <i class="fas fa-minus text-gray-600 dark:text-gray-400"></i>
                            </button>
                            
                            <input type="number" 
                                   value="<?= $item['quantity'] ?>" 
                                   min="1" 
                                   class="w-16 px-2 py-1 text-center border dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   onchange="updateQuantity(<?= $item['id'] ?>, this.value)">
                            
                            <button onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] ?> + 1)" 
                                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                <i class="fas fa-plus text-gray-600 dark:text-gray-400"></i>
                            </button>
                        </div>
                        
                        <button onclick="removeFromCart(<?= $item['id'] ?>)"
                                class="ml-4 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition duration-300">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="hidden md:block ml-6 text-right">
                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                            $<?= number_format($price * $item['quantity'], 2) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="mt-8 border-t dark:border-gray-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white mb-4 md:mb-0">
                        Total: $<?= number_format($total, 2) ?>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <a href="/Rudra/ecommerce/products.php" 
                           class="text-indigo-600 dark:text-indigo-400 px-6 py-2 rounded-lg border border-indigo-600 dark:border-indigo-400 
                                  hover:bg-indigo-50 dark:hover:bg-gray-700 transition duration-300 text-center">
                            Continue Shopping
                        </a>
                        <a href="/Rudra/ecommerce/checkout.php" 
                           class="bg-indigo-600 text-white px-8 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 text-center">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>