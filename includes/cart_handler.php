<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Please login to add items to cart']);
        exit;
    }

    try {
        // Check if product already exists in cart
        $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $existing_item = $stmt->fetch();

        if ($existing_item) {
            // Update quantity
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE id = ?");
            $stmt->execute([$quantity, $existing_item['id']]);
        } else {
            // Insert new item
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $product_id, $quantity]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart']);
    }
}