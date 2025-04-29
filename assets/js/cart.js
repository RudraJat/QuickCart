// Handles cart operations: add, remove, update, and display cart items

// Add a product to the cart
function addToCart(productId) {
    // Send AJAX request to add product to cart
    fetch('/classproject/api/cart.php', {
        method: 'POST',
        body: JSON.stringify({ action: 'add', product_id: productId }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        // Update cart count in the UI
        if (data.success) {
            updateCartCount(data.cartCount);
            alert('Product added to cart!');
        } else {
            alert(data.message || 'Failed to add product.');
        }
    });
}

// Update the cart count in the header and mobile menu
function updateCartCount(count) {
    const cartCount = document.getElementById('cart-count');
    const mobileCartCount = document.getElementById('mobile-cart-count');
    if (cartCount) cartCount.textContent = count;
    if (mobileCartCount) mobileCartCount.textContent = count;
}

// Remove a product from the cart
function removeFromCart(productId) {
    // Send AJAX request to remove product from cart
    fetch('/classproject/api/cart.php', {
        method: 'POST',
        body: JSON.stringify({ action: 'remove', product_id: productId }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        // Refresh the page or update cart UI
        if (data.success) {
            updateCartCount(data.cartCount);
            window.location.reload();
        } else {
            alert(data.message || 'Failed to remove product.');
        }
    });
}