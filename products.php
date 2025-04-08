<?php
session_start();
require_once 'config/database.php';

// Fetch categories
try {
    $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY name");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

// Get category filter
$category = isset($_GET['category']) ? $_GET['category'] : null;

// Fetch products
try {
    if ($category) {
        $query = "SELECT DISTINCT p.* 
                  FROM products p 
                  LEFT JOIN product_categories pc ON p.id = pc.product_id 
                  LEFT JOIN categories c ON pc.category_id = c.id 
                  WHERE c.slug = ? OR c.slug IS NULL
                  ORDER BY p.created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$category]);
    } else {
        $query = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}

$pageTitle = 'Products - QuickCart';
$containerClass = 'max-w-7xl mx-auto';

ob_start();
?>

<!-- Categories Navigation -->
<?php include 'templates/categories_nav.php'; ?>

<!-- Products Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php if (empty($products)): ?>
        <div class="col-span-full text-center py-12">
            <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-600 text-lg">No products found in this category</p>
            <a href="/Rudra/ecommerce/products.php" class="text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                View all products
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" 
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     class="w-full h-48 object-cover">
                
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>
                    
                    <div class="flex justify-between items-center">
                        <div class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                            $<?= number_format($product['price'], 2) ?>
                        </div>
                        
                        <button onclick="addToCart(<?= $product['id'] ?>)"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Add this before the closing </body> tag -->
<script>
function addToCart(productId) {
    if (!<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>) {
        window.location.href = '/Rudra/ecommerce/auth/login.php';
        return;
    }

    fetch('/Rudra/ecommerce/api/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productId + '&quantity=1'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to cart successfully!');
            // Update cart count if you have a cart counter in your header
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }
        } else {
            alert(data.message || 'Error adding product to cart');
        }
    })
    .catch(error => {
        alert('Error adding product to cart');
    });
}
</script>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>