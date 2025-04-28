<?php 
include 'includes/header.php';
require_once 'config/database.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();
?>

<div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image Gallery -->
            <div class="space-y-4">
                <img src="<?php echo $product['image_url']; ?>" class="w-full h-96 object-cover rounded-lg">
                <div class="grid grid-cols-4 gap-4">
                    <img src="<?php echo $product['image_url']; ?>" class="w-full h-24 object-cover rounded-lg cursor-pointer">
                    <!-- Add more thumbnail images here -->
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <h1 class="text-3xl font-bold text-gray-900"><?php echo $product['name']; ?></h1>
                <p class="text-4xl font-bold text-indigo-600">$<?php echo number_format($product['price'], 2); ?></p>
                <div class="border-t border-b py-4">
                    <p class="text-gray-700"><?php echo $product['description']; ?></p>
                </div>

                <!-- Add to Cart Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <label class="text-gray-700">Quantity:</label>
                        <select id="quantity" class="border rounded-md px-3 py-2">
                            <?php for($i=1; $i<=10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button onclick="addToCartWithQuantity(<?php echo $product['id']; ?>)" 
                            class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition">
                        Add to Cart
                    </button>
                </div>
                <!-- Remove duplicate product info and add to cart button -->
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>