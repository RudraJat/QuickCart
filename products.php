<?php
session_start();
require_once 'config/database.php';

// Initialize database connection
$database = new Database();
$pdo = $database->getConnection();

// Get products with optional category filter
$category = isset($_GET['category']) ? $_GET['category'] : null;

$sql = "SELECT * FROM products";
if ($category) {
    $sql .= " WHERE LOWER(category) = LOWER(?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category]);
} else {
    $stmt = $pdo->query($sql);
}
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - QuickCart</title>
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
<body class="bg-gray-50">
    <?php include 'templates/header.php'; ?>
    
    <main class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Our Products</h1>
        
        <!-- Add Category Filter UI -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-4">
                <a href="/classproject/products.php" 
                   class="px-4 py-2 rounded-lg <?php echo !$category ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'; ?>">
                    All Products
                </a>
                <a href="/classproject/products.php?category=electronics" 
                   class="px-4 py-2 rounded-lg <?php echo $category === 'electronics' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'; ?>">
                    Electronics
                </a>
                <a href="/classproject/products.php?category=home" 
                   class="px-4 py-2 rounded-lg <?php echo $category === 'home' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'; ?>">
                    Home & Living
                </a>
                <a href="/classproject/products.php?category=fashion" 
                   class="px-4 py-2 rounded-lg <?php echo $category === 'fashion' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'; ?>">
                    Fashion
                </a>
                <a href="/classproject/products.php?category=sports" 
                   class="px-4 py-2 rounded-lg <?php echo $category === 'sports' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'; ?>">
                    Sports
                </a>
            </div>
        </div>

        <!-- Existing product grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($product['name']); ?></h2>
                        <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold">$<?php echo number_format($product['price'], 2); ?></span>
                            <button onclick="addToCart(<?php echo $product['id']; ?>)"
                                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'templates/footer.php'; ?>
</body>
</html>