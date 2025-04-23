<nav class="bg-white dark:bg-gray-800 fixed w-full z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/classproject/index.php" class="text-2xl font-bold text-indigo-600">QuickCart</a>
                </div>
            </div>
            <!-- Right side navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="/classproject/index.php" class="nav-link dark:text-gray-200">Home</a>
                <a href="/classproject/products.php" class="nav-link dark:text-gray-200">Products</a>
                <a href="/classproject/pages/about.php" class="nav-link dark:text-gray-200">About Us</a>
                <a href="/classproject/cart.php" class="nav-link dark:text-gray-200 flex items-center">
                    <span>Cart</span>
                    <span id="cart-count" class="ml-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">0</span>
                </a>

                <!-- Dark mode toggle button -->
                <button id="darkModeToggle" class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i id="darkModeIcon" class="fas fa-moon text-gray-600 dark:text-gray-200 text-xl"></i>
                </button>

                <!-- Auth Links -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/classproject/account.php" class="nav-link dark:text-gray-200">Account</a>
                    <a href="/classproject/logout.php" 
                       class="bg-indigo-700 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-all duration-300 font-medium flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                <?php else: ?>
                    <a href="/classproject/login.php" class="nav-link dark:text-gray-200">Login</a>
                    <a href="/classproject/register.php" class="auth-button">Register</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/classproject/index.php" class="mobile-nav-link block py-2">Home</a>
                <a href="/classproject/products.php" class="mobile-nav-link block py-2">Products</a>
                <a href="/classproject/cart.php" class="mobile-nav-link block py-2 flex items-center justify-between">
                    <span>Cart</span>
                    <span id="mobile-cart-count" class="bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">0</span>
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/classproject/account.php" class="mobile-nav-link block py-2">Account</a>
                    <a href="/classproject/logout.php" class="mobile-auth-button mt-2">Logout</a>
                <?php else: ?>
                    <a href="/classproject/login.php" class="mobile-nav-link block py-2">Login</a>
                    <a href="/classproject/register.php" class="mobile-auth-button mt-2">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Add margin to main content to prevent header overlap -->
<div class="h-16"></div>

<style>
.nav-link {
    @apply text-gray-600 hover:text-indigo-600 dark:text-gray-200 dark:hover:text-white font-medium transition duration-300;
}

.auth-button {
    @apply bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 font-medium;
}

.mobile-nav-link {
    @apply text-gray-600 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-white font-medium transition duration-300 px-2;
}

.mobile-auth-button {
    @apply bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 font-medium text-center block;
}
</style>

<script>
// Mobile menu toggle
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    
    if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
        mobileMenu.classList.add('hidden');
    }
});

// Update both desktop and mobile cart counts
function updateCartCount(count) {
    document.getElementById('cart-count').textContent = count;
    document.getElementById('mobile-cart-count').textContent = count;
}
</script>

    <!-- Replace theme.js with darkMode.js -->
    <script src="/classproject/assets/js/darkMode.js"></script>
    <script src="/classproject/assets/js/cart.js"></script>