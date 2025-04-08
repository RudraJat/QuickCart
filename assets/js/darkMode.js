function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.classList.contains('dark');
    
    if (isDark) {
        html.classList.remove('dark');
        html.classList.add('light');
        localStorage.setItem('darkMode', 'false');
    } else {
        html.classList.remove('light');
        html.classList.add('dark');
        localStorage.setItem('darkMode', 'true');
    }
}

// Update toggle button icon
function updateDarkModeIcon() {
    const icon = document.getElementById('darkModeIcon');
    const isDark = document.documentElement.classList.contains('dark');
    icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
}

// Initialize dark mode icon
document.addEventListener('DOMContentLoaded', updateDarkModeIcon);