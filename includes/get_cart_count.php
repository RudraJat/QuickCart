<?php
session_start();
require_once '../config/database.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$count = 0;

if ($user_id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $count = $stmt->fetchColumn();
}

echo json_encode(['count' => $count]);