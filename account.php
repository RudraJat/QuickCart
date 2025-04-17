<?php
session_start();
require_once 'config/database.php';

// Initialize database connection
$database = new Database();
$pdo = $database->getConnection();

// Get user information
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
} else {
    // Redirect to login if not logged in
    header('Location: /classproject/login.php');
    exit();
}

// Fetch user data
// Update this query to include name
$stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Remove this duplicate query since we already have all user data
// $stmt = $pdo->prepare("SELECT id, email FROM users WHERE id = ?");
// $stmt->execute([$_SESSION['user_id']]);
// $user = $stmt->fetch();

// Set default values if fields are missing
$user['name'] = $user['name'] ?? explode('@', $user['email'])[0];
$user['email'] = $user['email'] ?? '';

// Fetch user's orders
$stmt = $pdo->prepare("
    SELECT o.*, COUNT(oi.id) as item_count 
    FROM orders o 
    LEFT JOIN order_items oi ON o.id = oi.order_id 
    WHERE o.user_id = ? 
    GROUP BY o.id 
    ORDER BY o.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();

$pageTitle = 'My Account - QuickCart';
$containerClass = 'max-w-4xl mx-auto';

// Add this line to include necessary scripts
$additionalScripts = '
    <script src="/classproject/assets/js/darkMode.js"></script>
    <script src="/classproject/assets/js/cart.js"></script>
';

ob_start();
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Profile Section -->
    <div class="md:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user text-4xl text-indigo-600 dark:text-indigo-400"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                    <?= htmlspecialchars($user['name']) ?>
                </h2>
                <p class="text-gray-600 dark:text-gray-400"><?= htmlspecialchars($user['email']) ?></p>
            </div>
            
            <button onclick="openEditProfile()" 
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                Edit Profile
            </button>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="md:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Order History</h2>
            
            <?php if (empty($orders)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-shopping-bag text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">No orders yet</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($orders as $order): ?>
                        <a href="/Rudra/ecommerce/order_details.php?id=<?= $order['id'] ?>" 
                           class="block border dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">
                                        Order #<?= $order['id'] ?>
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <?= date('F j, Y', strtotime($order['created_at'])) ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-indigo-600 dark:text-indigo-400">
                                        $<?= number_format($order['total_amount'], 2) ?>
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <?= $order['item_count'] ?> items
                                    </p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="inline-block px-3 py-1 text-sm rounded-full
                                    <?= $order['status'] === 'completed' 
                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="min-h-screen px-4 text-center">
        <!-- Modal close button -->
        <span class="absolute top-4 right-4">
            <button onclick="closeEditProfile()" class="text-white text-xl">&times;</button>
        </span>
        
        <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Edit Profile</h2>
            <form id="updateProfileForm" class="space-y-4">
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password (leave blank to keep current)</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditProfile()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditProfile() {
    document.getElementById('editProfileModal').classList.remove('hidden');
}

function closeEditProfile() {
    document.getElementById('editProfileModal').classList.add('hidden');
}

// Fix the form ID and event listener
document.getElementById('updateProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('/classproject/api/update_profile.php', {  // Fixed URL path
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully!');
            window.location.reload();
        } else {
            alert(data.message || 'An error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});
</script>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>