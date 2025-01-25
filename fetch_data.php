<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$apiKey = "0c44d7e57c6e30f514d8fe104ba9bbae"; // Remplacez par votre clé API Weatherstack
$city = "Hyères"; // Remplacez par la ville souhaitée

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT animals.id, animals.animal_name, animals.species, animals.age, animals.weight, animals.food_quantity, animals.private_comment, animals.unité_nourriture, COALESCE(animal_likes.likes, 0) AS likes, animals.image_url 
        FROM animals 
        LEFT JOIN animal_likes ON animals.id = animal_likes.id
        ORDER BY likes DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Récupérer les données météo
    $weatherUrl = "http://api.weatherstack.com/current?access_key=$apiKey&query=$city";
    $weatherResponse = file_get_contents($weatherUrl);
    $weatherData = json_decode($weatherResponse, true);

    if ($weatherData && isset($weatherData['current'])) {
        $temperature = $weatherData['current']['temperature'];
        $weatherDescription = $weatherData['current']['weather_descriptions'][0];
        $humidity = $weatherData['current']['humidity'];
    } else {
        $temperature = "N/A";
        $weatherDescription = "N/A";
        $humidity = "N/A";
    }

    echo "<div class='weather'>";
    echo "<h3>Météo à $city</h3>";
    echo "<p>Température: " . $temperature . "°C</p>";
    echo "<p>Description: " . $weatherDescription . "</p>";
    echo "<p>Humidité: " . $humidity . "%</p>";
    echo "</div>";

    while($row = $result->fetch_assoc()) {
        echo "<div class='animal'>";
        echo "<h3>" . $row['animal_name'] . "</h3>";
        echo "<p>Espèce: " . $row['species'] . "</p>";
        echo "<p>Âge: " . $row['age'] . "</p>";
        echo "<p>Poids: " . $row['weight'] . "</p>";
        echo "<p>Quantité de nourriture: " . $row['food_quantity'] . " " . $row['unité_nourriture'] . "</p>";
        echo "<p>Commentaires: " . $row['private_comment'] . "</p>";
        echo "<p>Likes: " . $row['likes'] . "</p>";
        echo "<img src='" . $row['image_url'] . "' alt='" . $row['animal_name'] . "'>";
        echo "</div>";
    }
} else {
    echo "0 résultats";
}

$conn->close();
?>