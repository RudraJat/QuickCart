// Handles authentication-related JS (login, register, logout)

// Handle login form submission
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    // Send AJAX request to login
    fetch('/classproject/api/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/classproject/account.php';
        } else {
            alert(data.message || 'Login failed');
        }
    });
});

// Handle logout (if using AJAX)
document.getElementById('logoutButton')?.addEventListener('click', function() {
    fetch('/classproject/api/logout.php', { method: 'POST' })
    .then(() => window.location.href = '/classproject/login.php');
});