<?php
session_start();
require_once 'config/database.php';

$database = new Database();
$pdo = $database->getConnection();

try {
    $pdo->beginTransaction();

    // Create the order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, created_at) VALUES (?, ?, 'pending', NOW())");
    $stmt->execute([$_SESSION['user_id'], $_SESSION['cart_total']]);
    $orderId = $pdo->lastInsertId();

    // Process each cart item and update stock
    foreach ($_SESSION['cart'] as $productId => $item) {
        // Check current stock first
        $stockCheck = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
        $stockCheck->execute([$productId]);
        $currentStock = $stockCheck->fetchColumn();

        if ($currentStock < $item['quantity']) {
            throw new Exception("Not enough stock available for product ID: " . $productId);
        }

        // Insert order item
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $productId, $item['quantity'], $item['price']]);

        // Update product stock with direct calculation
        $updateStock = $pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $newStock = $currentStock - $item['quantity'];
        $updateStock->execute([$newStock, $productId]);
        
        if ($updateStock->rowCount() === 0) {
            throw new Exception("Failed to update stock for product ID: " . $productId);
        }
    }

    $pdo->commit();
    
    // Clear the cart
    unset($_SESSION['cart']);
    unset($_SESSION['cart_total']);
    
    echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to place order. ' . $e->getMessage()]);
}
?>