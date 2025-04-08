<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'QuickCart' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?php if (isset($additionalStyles)) echo $additionalStyles; ?>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <?php include 'header.php'; ?>

    <main class="container mx-auto px-4 py-8 mt-16 sm:mt-20">
        <div class="<?= $containerClass ?? 'max-w-7xl mx-auto' ?>">
            <?= $content ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    
    <script src="/Rudra/ecommerce/assets/js/theme.js"></script>
    <?php if (isset($additionalScripts)) echo $additionalScripts; ?>
</body>
</html>