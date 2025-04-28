<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'QuickCart' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .dark body { background-color: #1a1a1a; color: #ffffff; }
        .dark .bg-white { background-color: #2d2d2d; }
        .dark .text-gray-700 { color: #e5e5e5; }
        .dark .bg-gray-50 { background-color: #1a1a1a; }
        .dark .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5); }
        .dark .text-gray-600 { color: #d1d1d1; }
        .dark .text-gray-500 { color: #a3a3a3; }
        .dark .text-gray-400 { color: #737373; }
    </style>
    <script>
        // Initialize dark mode based on localStorage
        const darkMode = localStorage.getItem('darkMode') === 'true';
        if (darkMode) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        }
    </script>
    <?php if (isset($additionalStyles)) echo $additionalStyles; ?>
</head>
<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <?php include __DIR__ . '/header.php'; ?>

    <main class="flex-1 <?= $containerClass ?? '' ?>">
        <?= $content ?>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>
    <?= $additionalScripts ?? '' ?>
</body>
</html>