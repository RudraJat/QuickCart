<?php
$pageTitle = 'Page Title - QuickCart';
$containerClass = 'max-w-4xl mx-auto'; // Optional custom container class

// Optional additional styles
$additionalStyles = '
<style>
    /* Custom styles */
</style>';

// Start output buffering
ob_start();
?>

<!-- Your page content here -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Content -->
</div>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'templates/layout.php';
?>