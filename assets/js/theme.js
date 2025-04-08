// Theme management
function initTheme() {
    const theme = localStorage.getItem('theme') || 'light';
    document.documentElement.className = theme;
    updateThemeIcon(theme);
}

function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.classList.contains('dark') ? 'light' : 'dark';
    html.className = currentTheme;
    localStorage.setItem('theme', currentTheme);
    updateThemeIcon(currentTheme);
}

function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('themeIcon');
    if (themeIcon) {
        themeIcon.className = theme === 'dark' 
            ? 'fas fa-sun text-gray-200 text-xl' 
            : 'fas fa-moon text-gray-600 text-xl';
    }
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', initTheme);