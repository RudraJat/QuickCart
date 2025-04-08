<?php
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../includes/login.php');
        exit();
    }
}

function checkAdmin() {
    if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        header('Location: ../index.php');
        exit();
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getUsername() {
    return $_SESSION['username'] ?? null;
}
?>