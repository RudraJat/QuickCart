// Admin panel JavaScript functions

// Fetch and display a list of users in the admin dashboard
async function fetchUsers() {
    try {
        // Make an API call to get all users
        const response = await fetch('/classproject/api/admin_users.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const users = await response.json();

        // Render users in the admin table (assumes a table with id 'usersTable')
        const tableBody = document.getElementById('usersTableBody');
        tableBody.innerHTML = ''; // Clear previous rows
        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>
                    <button onclick="deleteUser(${user.id})" class="text-red-600">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } catch (error) {
        console.error('Failed to fetch users:', error);
    }
}

// Delete a user by ID
async function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) return;

    try {
        // Send a DELETE request to the API
        const response = await fetch(`/classproject/api/admin_users.php?id=${userId}`, {
            method: 'DELETE'
        });
        const result = await response.json();
        if (result.success) {
            alert('User deleted successfully.');
            fetchUsers(); // Refresh the user list
        } else {
            alert(result.message || 'Failed to delete user.');
        }
    } catch (error) {
        alert('An error occurred while deleting the user.');
        console.error(error);
    }
}

// Handle admin form submissions (e.g., add product)
function handleAdminForm(formId, endpoint) {
    const form = document.getElementById(formId);
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            // Send form data to the API endpoint
            const response = await fetch(endpoint, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                alert('Operation successful!');
                form.reset();
            } else {
                alert(result.message || 'Operation failed.');
            }
        } catch (error) {
            alert('An error occurred. Please try again.');
            console.error(error);
        }
    });
}

// Example: Initialize user list on page load
document.addEventListener('DOMContentLoaded', fetchUsers);