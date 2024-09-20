
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.heart-btn').forEach(button => {
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);

        newButton.addEventListener('click', function() {
            const animalId = this.getAttribute('id').split('-')[1];
            const likeCountElement = document.getElementById(`likes-${animalId}`);
            let likeCount = parseInt(likeCountElement.innerText);
            likeCount++;
            likeCountElement.innerText = likeCount;

            likeAnimal(animalId);

            fetch('update_likes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `animal_id=${animalId}`
            })
            .then(response => response.text())
            .then(data => {
                if (data !== "Success") {
                    console.error('Erreur lors de la mise à jour des likes:', data);
                }
            })
            .catch(error => {
                console.error('Erreur réseau:', error);
            });
        });
    });
});