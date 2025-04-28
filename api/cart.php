<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['action']) && isset($data['product_id'])) {
    $product_id = (int)$data['product_id'];
    
    switch($data['action']) {
        case 'add':
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = 1;
            } else {
                $_SESSION['cart'][$product_id]++;
            }
            break;
            
        case 'increase':
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = 1;
            } else {
                $_SESSION['cart'][$product_id]++;
            }
            break;
            
        case 'decrease':
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]--;
                if ($_SESSION['cart'][$product_id] <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
            break;
            
        case 'remove':
            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }
            break;
    }
    
    // Calculate new total
    $total = 0;
    $quantity = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] : 0;
    
    if (!empty($_SESSION['cart'])) {
        require_once '../config/database.php';
        $database = new Database();
        $pdo = $database->getConnection();
        
        $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute(array_keys($_SESSION['cart']));
        $items = $stmt->fetchAll();
        
        foreach ($items as $item) {
            $total += $item['price'] * $_SESSION['cart'][$item['id']];
        }
    }
    
    echo json_encode([
        'success' => true,
        // FIX: Use array_sum to get total quantity, not just unique products
        'cartCount' => array_sum($_SESSION['cart']),
        'cartTotal' => $total,
        'quantity' => $quantity
    ]);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Invalid request'
]);