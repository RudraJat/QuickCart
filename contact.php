<?php 
include 'includes/header.php';

if(isset($_POST['submit'])) {
    // Handle contact form submission
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    
    // Here you can add code to send email or save to database
    $success = true; // Set based on your email sending logic
}
?>

<div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Contact Us</h1>
                
                <?php if(isset($success)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        Thank you for your message. We'll get back to you soon!
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Subject</label>
                        <input type="text" name="subject" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="5" required
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <button type="submit" name="submit"
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
                        Send Message
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-map-marker-alt text-xl text-indigo-600 mt-1"></i>
                        <div>
                            <h3 class="font-semibold">Address</h3>
                            <p class="text-gray-600">123 Shopping Street, Market Area, City, Country</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-phone text-xl text-indigo-600 mt-1"></i>
                        <div>
                            <h3 class="font-semibold">Phone</h3>
                            <p class="text-gray-600">+1 234 567 890</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-envelope text-xl text-indigo-600 mt-1"></i>
                        <div>
                            <h3 class="font-semibold">Email</h3>
                            <p class="text-gray-600">support@rudrashop.com</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-indigo-600 hover:text-indigo-700">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>