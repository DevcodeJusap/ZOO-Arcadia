document.addEventListener('DOMContentLoaded', function() {
    // Votre code ici
    var element = document.getElementById('someElementId');
    if (element) {
        element.addEventListener('click', function() {
            // Votre logique ici
        });
    } else {
        console.error('Element with ID someElementId not found.');
    }
});