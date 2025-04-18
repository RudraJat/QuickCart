<?php
session_start();
require_once '../config/database.php';

$pageTitle = 'FAQ - QuickCart';
$containerClass = 'max-w-7xl mx-auto px-4';

ob_start();
?>

<div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-8">Frequently Asked Questions</h1>
            
            <div class="space-y-6">
                <!-- Shopping -->
                <div class="border-b pb-6">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Shopping</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">How do I create an account?</h3>
                            <p class="text-gray-600 dark:text-gray-300">Click on the 'Sign Up' button and fill in your details to create an account.</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">How can I track my order?</h3>
                            <p class="text-gray-600 dark:text-gray-300">Log into your account and visit the 'Order History' section to track your orders.</p>
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="border-b pb-6">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Payment</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">What payment methods do you accept?</h3>
                            <p class="text-gray-600 dark:text-gray-300">We accept credit cards, debit cards, and various digital payment methods.</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Is my payment information secure?</h3>
                            <p class="text-gray-600 dark:text-gray-300">Yes, we use industry-standard encryption to protect your payment information.</p>
                        </div>
                    </div>
                </div>

                <!-- Returns -->
                <div>
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Returns</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">What is your return policy?</h3>
                            <p class="text-gray-600 dark:text-gray-300">We offer a 30-day return policy. Visit our <a href="/classproject/returns.php" class="text-indigo-600 hover:text-indigo-500">Returns page</a> for more details.</p>
                        </div>
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