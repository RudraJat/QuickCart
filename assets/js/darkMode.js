document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeIcon = document.getElementById('darkModeIcon');
    const html = document.documentElement;
    
    // Set initial theme based on localStorage
    function setTheme(isDark) {
        if (isDark) {
            html.classList.add('dark');
            html.classList.remove('light');
            if (darkModeIcon) {
                darkModeIcon.classList.remove('fa-moon');
                darkModeIcon.classList.add('fa-sun');
            }
        } else {
            html.classList.remove('dark');
            html.classList.add('light');
            if (darkModeIcon) {
                darkModeIcon.classList.add('fa-moon');
                darkModeIcon.classList.remove('fa-sun');
            }
        }
        localStorage.setItem('darkMode', isDark);
    }

    // Initialize theme
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    setTheme(isDarkMode);

    // Handle theme toggle
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            const shouldBeDark = !html.classList.contains('dark');
            setTheme(shouldBeDark);
        });
    }
});