<?php
session_start();
require_once 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RudraShop - Your Premium Shopping Destination</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add this before closing </head> tag -->
    <script src="/Rudra/ecommerce/assets/js/cart.js"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/Rudra/ecommerce/" class="text-2xl font-bold text-indigo-600">RudraShop</a>
                </div>
                <div class="flex-1 flex items-center justify-center px-6">
                    <div class="w-full max-w-lg">
                        <div class="relative">
                            <input type="text" class="w-full bg-gray-100 rounded-full pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search products...">
                            <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-search text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/Rudra/ecommerce/categories.php" class="text-gray-700 hover:text-indigo-600">Categories</a>
                    <a href="/Rudra/ecommerce/cart.php" class="relative text-gray-700 hover:text-indigo-600">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">0</span>
                    </a>
                    <a href="/Rudra/ecommerce/account.php" class="text-gray-700 hover:text-indigo-600">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>