<?php include 'includes/header.php'; ?>

<div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Shipping Information</h1>

            <div class="space-y-8">
                <div class="border-b pb-6">
                    <h2 class="text-2xl font-semibold mb-4">Delivery Options</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-truck text-indigo-600 text-xl mr-2"></i>
                                <h3 class="font-semibold">Standard Delivery</h3>
                            </div>
                            <p class="text-gray-600">3-5 business days</p>
                            <p class="font-semibold mt-2">$5.99</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-shipping-fast text-indigo-600 text-xl mr-2"></i>
                                <h3 class="font-semibold">Express Delivery</h3>
                            </div>
                            <p class="text-gray-600">1-2 business days</p>
                            <p class="font-semibold mt-2">$12.99</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-store text-indigo-600 text-xl mr-2"></i>
                                <h3 class="font-semibold">Store Pickup</h3>
                            </div>
                            <p class="text-gray-600">Same day</p>
                            <p class="font-semibold mt-2">Free</p>
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h2 class="text-2xl font-semibold mb-4">Shipping Policy</h2>
                    <ul class="list-disc pl-5 space-y-2 text-gray-600">
                        <li>Orders are processed within 24 hours</li>
                        <li>Free shipping on orders over $50</li>
                        <li>International shipping available</li>
                        <li>Tracking number provided via email</li>
                        <li>Insurance included on all shipments</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold mb-4">Tracking Your Order</h2>
                    <p class="text-gray-600 mb-4">
                        Once your order ships, you'll receive a confirmation email with your tracking number.
                        You can also track your order through your account dashboard.
                    </p>
                    <a href="/Rudra/ecommerce/track-order.php" 
                       class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Track Your Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>