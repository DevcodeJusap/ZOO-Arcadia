document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function() {
            const animalId = this.dataset.animalId;
            fetch('/php/like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ animalId: animalId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeCount = document.querySelector(`#like-count-${animalId}`);
                    likeCount.textContent = data.newLikeCount;
                } else {
                    console.error('Erreur lors de la mise à jour des likes');
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});