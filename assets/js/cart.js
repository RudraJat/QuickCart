function addToCart(productId, quantity = 1) {
    fetch('/classproject/api/cart_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            updateCartCount();
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
            toast.textContent = 'Product added to cart';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add product to cart');
    });
}

// Function to update cart count in header
function updateCartCount() {
    fetch('/classproject/api/get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById('cart-count');
            const mobileCartCount = document.getElementById('mobile-cart-count');
            if (cartCount) cartCount.textContent = data.count;
            if (mobileCartCount) mobileCartCount.textContent = data.count;
        });
}

// Function to update quantity
function updateQuantity(productId, change) {
    fetch('/classproject/api/update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&change=${change}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Function to remove item from cart
function removeFromCart(productId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch('/classproject/api/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

// Update cart count when page loads
document.addEventListener('DOMContentLoaded', updateCartCount);