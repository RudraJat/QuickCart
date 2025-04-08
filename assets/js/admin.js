// Product management
function saveProduct(formData) {
    fetch('api/admin/products.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Product saved successfully!');
            loadProducts();
        }
    });
}

// Analytics dashboard
function loadAnalytics() {
    fetch('api/admin/analytics.php')
        .then(response => response.json())
        .then(data => {
            updateSalesChart(data.sales);
            updateTopProducts(data.topProducts);
            updateUserStats(data.users);
        });
}

// Order management
function updateOrderStatus(orderId, status) {
    fetch('api/admin/orders.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            order_id: orderId,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            loadOrders();
        }
    });
}