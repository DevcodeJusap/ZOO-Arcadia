document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.reject-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            fetch('reject_request.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Success") {
                    this.closest('tr').remove();
                } else {
                    console.error('Erreur lors de la suppression de la demande:', data);
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});