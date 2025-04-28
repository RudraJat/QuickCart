<?php
session_start();
$pageTitle = 'Contact Us - QuickCart';
include 'templates/layout.php';
?>

<div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Contact Us</h1>
            <!-- Add your contact form here -->
        </div>
    </div>
</div>

document.addEventListener('DOMContentLoaded', function() {
    // Move all your addEventListener code inside this function
    var myElement = document.getElementById('yourElementId');
    if (myElement) {
        myElement.addEventListener('click', function() {
            // ... your code ...
        });
    }
    // ... any other DOM-dependent code ...
});