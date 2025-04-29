// Cart functionality
function addToCartWithQuantity(productId) {
    const quantity = document.getElementById('quantity').value;
    fetch('/Rudra/ecommerce/api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity,
            action: 'add'
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            updateCartCount();
            showNotification('Product added to cart!');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartCount() {
    fetch('/Rudra/ecommerce/api/cart.php?action=count')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.cart-count').textContent = data.count;
        });
}

function updateQuantity(productId, quantity) {
    fetch('/Rudra/ecommerce/api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity,
            action: 'update'
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            window.location.reload();
        }
    });
}

function removeFromCart(productId) {
    if(confirm('Are you sure you want to remove this item?')) {
        fetch('/Rudra/ecommerce/api/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                action: 'remove'
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                window.location.reload();
            }
        });
    }
}

// Notification system
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-500 translate-y-[-100%]';
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateY(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateY(-100%)';
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);
}

// Update cart count in header
function updateCartCount() {
    fetch('api/cart.php?action=count')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.count;
        });
}

// Product filtering and sorting
function filterProducts() {
    const category = document.getElementById('category').value;
    const priceRange = document.getElementById('price-range').value;
    const sortBy = document.getElementById('sort-by').value;

    fetch(`api/products.php?category=${category}&price=${priceRange}&sort=${sortBy}`)
        .then(response => response.json())
        .then(data => updateProductGrid(data));
}

// Wishlist functionality
function toggleWishlist(productId) {
    fetch('api/wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        const icon = document.querySelector(`#wishlist-${productId}`);
        icon.classList.toggle('active');
    });
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
        } else {
            input.classList.remove('error');
        }
    });

    return isValid;
}

// Main site-wide JS: handles navigation, mobile menu, and other global features

// Toggle mobile menu visibility
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