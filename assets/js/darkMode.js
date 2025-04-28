document.addEventListener('DOMContentLoaded', function () {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeIcon = document.getElementById('darkModeIcon');

    // Set initial mode based on localStorage
    const darkMode = localStorage.getItem('darkMode') === 'true';
    setTheme(darkMode);

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function () {
            const isDark = document.documentElement.classList.toggle('dark');
            document.documentElement.classList.toggle('light', !isDark);
            localStorage.setItem('darkMode', isDark);

            // Optionally change icon
            if (darkModeIcon) {
                darkModeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            }
        });
    }

    function setTheme(isDark) {
        if (isDark) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
            if (darkModeIcon) darkModeIcon.className = 'fas fa-sun';
        } else {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
            if (darkModeIcon) darkModeIcon.className = 'fas fa-moon';
        }
    }
});