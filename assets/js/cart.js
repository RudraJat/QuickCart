// Cart functionality
function addToCart(productId) {
    fetch('/classproject/api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'add',
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cartCount);
            alert('Product added to cart!');
        } else {
            alert(data.message || 'Error adding product to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product to cart');
    });
}

// Cart functionality
function removeFromCart(productId) {
    // Remove or comment out this line after debugging
    // alert("Remove function called for product ID: " + productId);
    if (confirm('Are you sure you want to remove this item?')) {
        fetch('/classproject/api/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'remove',
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Use a more robust selector for the cart item
                const cartItem = document.querySelector(`div[data-product-id="${productId}"]`);
                if (cartItem) {
                    cartItem.remove();
                }
                updateCartCount(data.cartCount);

                if (data.cartCount === 0) {
                    window.location.reload();
                    return;
                }

                const subtotalElement = document.querySelector('.flex.justify-between.mb-2 span:last-child');
                const totalElement = document.querySelector('.flex.justify-between.mb-4 span:last-child');
                if (subtotalElement && totalElement && data.cartTotal !== undefined) {
                    const formattedTotal = `$${parseFloat(data.cartTotal).toFixed(2)}`;
                    subtotalElement.textContent = formattedTotal;
                    totalElement.textContent = formattedTotal;
                }
            } else {
                alert(data.message || 'Error removing item from cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing item from cart');
        });
    }
}

function updateCart(productId, action) {
    fetch('/classproject/api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: action,
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Use a more robust selector for the cart item
            const container = document.querySelector(`div[data-product-id="${productId}"]`);
            if (container) {
                const quantitySpan = container.querySelector('.mx-4');
                if (quantitySpan) {
                    quantitySpan.textContent = data.quantity;
                }
                if (data.quantity <= 0) {
                    container.remove();
                }
            }

            const subtotalSpan = document.querySelector('.flex.justify-between.mb-2 span:last-child');
            const totalSpan = document.querySelector('.flex.justify-between.mb-4 span:last-child');
            if (subtotalSpan && totalSpan) {
                const formattedTotal = `$${parseFloat(data.cartTotal).toFixed(2)}`;
                subtotalSpan.textContent = formattedTotal;
                totalSpan.textContent = formattedTotal;
            }

            updateCartCount(data.cartCount);

            if (data.cartCount === 0) {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Error updating cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating cart');
    });
}

function updateCartCount(count) {
    const cartCount = document.getElementById('cart-count');
    const mobileCartCount = document.getElementById('mobile-cart-count');
    if (cartCount) cartCount.textContent = count;
    if (mobileCartCount) mobileCartCount.textContent = count;
}

function updateCartTotal(total) {
    const cartTotal = document.getElementById('cart-total');
    if (cartTotal) {
        cartTotal.textContent = `$${parseFloat(total).toFixed(2)}`;
    }
}