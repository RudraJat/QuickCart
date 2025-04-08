function addToCart(productId, quantity = 1) {
    fetch('/Rudra/ecommerce/includes/cart_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            // Optionally update cart count in navbar
            updateCartCount();
        } else {
            alert(data.message);
            if (data.message.includes('login')) {
                window.location.href = '/Rudra/ecommerce/auth/login.php';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add product to cart');
    });
}

// Function to update cart count in header
function updateCartCount() {
    fetch('/Rudra/ecommerce/api/get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById('cart-count');
            const mobileCartCount = document.getElementById('mobile-cart-count');
            if (cartCount) cartCount.textContent = data.count;
            if (mobileCartCount) mobileCartCount.textContent = data.count;
        });
}

// Function to update quantity
function updateQuantity(cartId, quantity) {
    fetch('/Rudra/ecommerce/api/update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cart_id=${cartId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Function to remove item from cart
function removeFromCart(cartId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch('/Rudra/ecommerce/api/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `cart_id=${cartId}`
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