<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header('Location: /classproject/index.php');
    exit;
}

$database = new Database();
$pdo = $database->getConnection();

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['order_id'], $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: /classproject/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - QuickCart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include '../templates/header.php'; ?>

    <!-- Order Confirmation Modal -->
    <div id="confirmationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="text-center">
                <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-4">Order Confirmed!</h2>
                <p class="text-gray-600 mb-6">Your order has been successfully placed. Thank you for shopping with us!</p>
                <p class="text-gray-600 mb-6">Order Total: $<?php echo number_format($order['total_amount'], 2); ?></p>
                <button onclick="window.location.href='/classproject/index.php'" 
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Payment Details</h1>
            <div class="mb-6">
                <p class="text-lg">Order Total: $<?php echo number_format($order['total_amount'], 2); ?></p>
            </div>
            <form id="payment-form" class="space-y-4" onsubmit="showConfirmation(event)">
                <!-- Shipping Address Section -->
                <div class="border-b pb-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Full Name</label>
                            <input type="text" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="(123) 456-7890">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 mb-2">Street Address</label>
                            <input type="text" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="123 Main St">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">City</label>
                            <input type="text" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="City">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">State</label>
                            <input type="text" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="State">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">ZIP Code</label>
                            <input type="text" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="12345">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Country</label>
                            <input type="text" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Country">
                        </div>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Complete Payment
                </button>
            </form>
        </div>
    </main>

    <?php include '../templates/footer.php'; ?>

    <script>
    function showConfirmation(event) {
        event.preventDefault();
        document.getElementById('confirmationModal').classList.remove('hidden');
    }
    </script>
</body>
</html>