// Handles dark mode toggling and persistence

// Toggle dark mode and save preference
function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.classList.toggle('dark');
    html.classList.toggle('light', !isDark);
    localStorage.setItem('darkMode', isDark);
    updateDarkModeIcon(isDark);
}

// Update the dark mode icon (moon/sun)
function updateDarkModeIcon(isDark) {
    const icon = document.getElementById('darkModeIcon');
    if (icon) {
        icon.className = isDark
            ? 'fas fa-sun text-gray-200 text-xl'
            : 'fas fa-moon text-gray-600 text-xl';
    }
}

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', function() {
    const darkMode = localStorage.getItem('darkMode') === 'true';
    document.documentElement.classList.toggle('dark', darkMode);
    document.documentElement.classList.toggle('light', !darkMode);
    updateDarkModeIcon(darkMode);
});