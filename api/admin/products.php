<?php
session_start();
require_once '../../config/database.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Handle image upload
    $image = $_FILES['image'];
    $imagePath = uploadImage($image);

    $stmt = $pdo->prepare("INSERT INTO products (name, price, description, category, stock, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $success = $stmt->execute([$name, $price, $description, $category, $stock, $imagePath]);

    echo json_encode(['success' => $success]);
}

function uploadImage($image) {
    $target_dir = "../../uploads/products/";
    $fileName = uniqid() . "_" . basename($image["name"]);
    $target_file = $target_dir . $fileName;
    
    move_uploaded_file($image["tmp_name"], $target_file);
    return "uploads/products/" . $fileName;
}
?>