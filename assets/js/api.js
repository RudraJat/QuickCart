const API_BASE_URL = '/classproject/api';

// Example function to make API calls
async function fetchFromAPI(endpoint, options = {}) {
    try {
        const response = await fetch(`${API_BASE_URL}/${endpoint}`, {
            ...options,
            headers: {
                'Content-Type': 'application/json',
                ...options.headers
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

// Example form submission function
function handleFormSubmit(formId, endpoint) {
    const form = document.getElementById(formId);
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetchFromAPI(endpoint, {
                method: 'POST',
                body: JSON.stringify(data)
            });
            // Handle success
            console.log('Success:', response);
        } catch (error) {
            // Handle error
            console.error('Error:', error);
        }
    });
}