<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login to checkout']);
        exit;
    }

    if (empty($_SESSION['cart'])) {
        echo json_encode(['status' => 'error', 'message' => 'Your cart is empty']);
        exit;
    }

    try {
        $database = new Database();
        $pdo = $database->getConnection();
        
        // Create order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $_POST['total_amount']]);
        $order_id = $pdo->lastInsertId();

        // Create order items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product_stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $product_stmt->execute([$product_id]);
            $price = $product_stmt->fetchColumn();
            
            $stmt->execute([$order_id, $product_id, $quantity, $price]);
        }

        // Clear cart
        $_SESSION['cart'] = [];
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'redirect' => '/classproject/checkout/payment.php?order_id=' . $order_id
        ]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to process order']);
    }
}
?>