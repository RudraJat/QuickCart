<?php
session_start();
require_once 'config/database.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart_items = [];
$total = 0;

// Get cart items from database if there are items in cart
if (!empty($_SESSION['cart'])) {
    $database = new Database();
    $pdo = $database->getConnection();
    
    $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($_SESSION['cart']));
    $cart_items = $stmt->fetchAll();
    
    // Calculate total
    foreach ($cart_items as $item) {
        $quantity = $_SESSION['cart'][$item['id']];
        $total += $item['price'] * $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - QuickCart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dark body { background-color: #1a1a1a; color: #ffffff; }
        .dark .bg-white { background-color: #2d2d2d; }
        .dark .text-gray-700 { color: #e5e5e5; }
        .dark .bg-gray-50 { background-color: #1a1a1a; }
        .dark .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5); }
        .dark .text-gray-600 { color: #d1d1d1; }
        .dark .text-gray-500 { color: #a3a3a3; }
        .dark .text-gray-400 { color: #737373; }
    </style>
    <script>
        // Initialize dark mode based on localStorage
        const darkMode = localStorage.getItem('darkMode') === 'true';
        if (darkMode) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <?php include 'templates/header.php'; ?>
    
    <main class="max-w-7xl mx-auto px-4 py-8 flex-1">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
        
        <?php if (empty($cart_items)): ?>
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500 text-xl">Your cart is empty</p>
                <a href="/classproject/products.php" 
                   class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="bg-white rounded-lg shadow-md p-6 mb-4 flex items-center" data-product-id="<?php echo $item['id']; ?>">
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>"
                                 class="w-24 h-24 object-cover rounded">
                            <div class="ml-6 flex-grow">
                                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p class="text-gray-600">$<?php echo number_format($item['price'], 2); ?></p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <button onclick="updateCart(<?php echo $item['id']; ?>, 'decrease')" 
                                                class="bg-gray-200 px-3 py-1 rounded">-</button>
                                        <span class="mx-4"><?php echo $_SESSION['cart'][$item['id']]; ?></span>
                                        <button onclick="updateCart(<?php echo $item['id']; ?>, 'increase')" 
                                                class="bg-gray-200 px-3 py-1 rounded">+</button>
                                    </div>
                                    <button onclick="removeFromCart(<?php echo $item['id']; ?>)" 
                                            class="text-red-600 hover:text-red-800 ml-4">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 h-fit">
                    <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <hr class="my-4">
                    <div class="flex justify-between mb-4">
                        <span class="font-bold">Total</span>
                        <span class="font-bold">$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <!-- Replace the existing checkout button with this -->
                    <button onclick="processCheckout(<?php echo $total; ?>)" 
                            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                        Proceed to Payment
                    </button>
                    
                    <!-- Add this script at the bottom of the file -->
                    <script>
                    function processCheckout(totalAmount) {
                        fetch('/classproject/api/process_checkout.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `total_amount=${totalAmount}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                window.location.href = data.redirect;
                            } else {
                                alert(data.message);
                                if (data.message.includes('login')) {
                                    window.location.href = '/classproject/auth/login.php';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to process checkout');
                        });
                    }
                    </script>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'templates/footer.php'; ?>
    <script src="/classproject/assets/js/cart.js"></script>
</body>
</html>