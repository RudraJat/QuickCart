// Handles profile modal open/close and profile update via AJAX

// Show the edit profile modal
function openEditProfile() {
    document.getElementById('editProfileModal').classList.remove('hidden');
}

// Hide the edit profile modal
function closeEditProfile() {
    document.getElementById('editProfileModal').classList.add('hidden');
}

// Handle profile update form submission
document.getElementById('updateProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    // Send AJAX request to update profile
    fetch('/classproject/api/update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully!');
            window.location.reload();
        } else {
            alert(data.message || 'An error occurred');
        }
    })
    .catch(error => {
        alert('An error occurred. Please try again.');
    });
});