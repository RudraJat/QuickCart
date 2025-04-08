<!-- <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Browse Categories</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <a href="/Rudra/ecommerce/products.php?category=<?= htmlspecialchars($category['slug']) ?>" 
                   class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">
                    <div class="text-center mb-2 w-12 h-12 flex items-center justify-center">
                        <i class="fas <?= htmlspecialchars($category['icon']) ?> text-2xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <span class="text-gray-800 dark:text-white text-center font-medium">
                        <?= htmlspecialchars($category['name']) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center text-gray-600 dark:text-gray-400 py-4">
                <p>No categories available</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentCategory = new URLSearchParams(window.location.search).get('category');
    if (currentCategory) {
        document.querySelectorAll('a[href*="category="]').forEach(link => {
            if (link.href.includes(`category=${currentCategory}`)) {
                link.classList.add('bg-gray-50', 'dark:bg-gray-700');
            }
        });
    }
});
</script> -->