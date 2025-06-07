function createLogout() {
    document.querySelector('.dock__logout').addEventListener('click', async () => {
        try {
            const response = await fetch('http://localhost:8080/api/logout.php', {
                method: 'POST'
            });
            if (response.ok) {
                window.location.href = '/login';
            } else {
                console.error('Logout failed');
            }
        } catch (error) {
            console.error('Error during logout:', error);
        }
    });
}