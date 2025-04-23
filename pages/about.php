<?php
session_start();
require_once '../config/database.php';

$pageTitle = 'About Us - QuickCart';
$containerClass = 'max-w-7xl mx-auto px-4';

ob_start();
?>

<div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-8">About QuickCart</h1>
            
            <div class="space-y-8">
                <!-- Our Story -->
                <div class="border-b pb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Our Story</h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Founded in 2024, QuickCart has grown from a small startup to a trusted online shopping destination. 
                        We believe in providing quality products at competitive prices while ensuring an exceptional shopping experience.
                    </p>
                </div>

                <!-- Our Mission -->
                <div class="border-b pb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Our Mission</h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        To provide a seamless and enjoyable shopping experience by offering high-quality products, 
                        excellent customer service, and innovative solutions that make online shopping convenient and reliable.
                    </p>
                </div>

                <!-- Why Choose Us -->
                <div class="grid md:grid-cols-3 gap-8 border-b pb-8">
                    <div class="text-center">
                        <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-truck text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold mb-2">Fast Delivery</h3>
                        <p class="text-gray-600 dark:text-gray-300">Quick and reliable shipping to your doorstep</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold mb-2">Secure Shopping</h3>
                        <p class="text-gray-600 dark:text-gray-300">Protected payments and data privacy</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold mb-2">24/7 Support</h3>
                        <p class="text-gray-600 dark:text-gray-300">Always here to help you</p>
                    </div>
                </div>

                <!-- Contact Section -->
                <div>
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Get in Touch</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Have questions or suggestions? We'd love to hear from you.
                    </p>
                    <div class="flex space-x-4">
                        <a href="mailto:rps9827256181@gmail.com" 
                           class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-envelope mr-2"></i> Email Us
                        </a>
                        <a href="tel:+918103000577" 
                           class="inline-flex items-center px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-phone mr-2"></i> Call Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../templates/layout.php';
?>