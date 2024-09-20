document.addEventListener('DOMContentLoaded', function() {
    const apiKey = '523de7acc3c14aead2ce125e7188e3e3'; // attention clé API OpenWeatherMap.
    const city = 'hyeres'; 
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=fr`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const weatherDescription = data.weather[0].description;
            const temperature = data.main.temp;
            const humidity = data.main.humidity;
            const iconCode = data.weather[0].icon;
            const iconUrl = `https://openweathermap.org/img/wn/${iconCode}.png`;

            document.getElementById('weather-icon').src = iconUrl;
            document.getElementById('weather-description').textContent = `Conditions météorologiques : ${weatherDescription}`;
            document.getElementById('temperature').textContent = `Température : ${temperature}°C`;
            document.getElementById('humidity').textContent = `Humidité : ${humidity}%`;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données météo :', error);
            document.getElementById('weather-description').textContent = 'Impossible de récupérer les données météo.';
        });

    // Gestion des likes du site.
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function() {
            const animalId = this.getAttribute('data-animal-id');
            fetch(`like_animal.php?animal_id=${animalId}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeCountElement = document.querySelector(`.like-count[data-animal-id="${animalId}"]`);
                    likeCountElement.textContent = data.likes;
                } else {
                    console.error('Erreur lors de la mise à jour des likes');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la requête AJAX :', error);
            });
        });
    });
});