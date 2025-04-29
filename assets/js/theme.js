// Theme management

// Initialize the theme on page load based on saved preference or default to light
function initTheme() {
    const theme = localStorage.getItem('theme') || 'light'; // Get saved theme or use 'light'
    document.documentElement.className = theme; // Set the <html> class to the theme
    updateThemeIcon(theme); // Update the theme icon accordingly
}

// Toggle between dark and light themes
function toggleTheme() {
    const html = document.documentElement; // Reference to the <html> element
    // If currently dark, switch to light; otherwise, switch to dark
    const currentTheme = html.classList.contains('dark') ? 'light' : 'dark';
    html.className = currentTheme; // Set the <html> class to the new theme
    localStorage.setItem('theme', currentTheme); // Save the new theme in localStorage
    updateThemeIcon(currentTheme); // Update the theme icon
}

// Update the theme icon (sun for dark mode, moon for light mode)
function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('themeIcon'); // Get the theme icon element
    if (themeIcon) {
        themeIcon.className = theme === 'dark' 
            ? 'fas fa-sun text-gray-200 text-xl' // Sun icon for dark mode
            : 'fas fa-moon text-gray-600 text-xl'; // Moon icon for light mode
    }
}

// Initialize theme when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initTheme);