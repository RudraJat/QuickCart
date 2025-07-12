// Theme management

// Initialize the theme on page load based on saved preference or default to light
function initTheme() {
    const theme = localStorage.getItem('theme') || 'light';
    document.documentElement.className = theme;
    updateThemeIcon(theme);
}

// Toggle between dark and light themes
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.classList.contains('dark') ? 'light' : 'dark';
    html.className = currentTheme;
    localStorage.setItem('theme', currentTheme);
    updateThemeIcon(currentTheme);
}

// Update the theme icon (sun for dark mode, moon for light mode)
function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('themeIcon');
    if (themeIcon) {
        themeIcon.className = theme === 'dark'
            ? 'fas fa-sun text-gray-200 text-xl'
            : 'fas fa-moon text-gray-600 text-xl';
    }
}

// Add event listener to the header theme toggle button
document.addEventListener('DOMContentLoaded', function() {
    initTheme();
    const themeBtn = document.getElementById('themeToggleBtn');
    if (themeBtn) {
        themeBtn.onclick = toggleTheme;
    }
});