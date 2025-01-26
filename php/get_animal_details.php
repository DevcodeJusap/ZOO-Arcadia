<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $animalId = intval($_GET['id']);
    $sql = "SELECT * FROM animals WHERE id = $animalId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p>Nom: " . htmlspecialchars($row['animal_name']) . "</p>";
        echo "<p>Espèce: " . htmlspecialchars($row['species']) . "</p>";
        echo "<p>Âge: " . htmlspecialchars($row['age']) . "</p>";
        echo "<p>Poids: " . htmlspecialchars($row['weight']) . " Kg</p>";
        echo "<p>Quantité de nourriture: " . htmlspecialchars($row['food_quantity']) . " " . htmlspecialchars($row['unité_nourriture']) . "</p>";
        echo "<p>Commentaire privé: " . htmlspecialchars($row['private_comment']) . "</p>";
        echo "<p>Likes: " . htmlspecialchars($row['likes']) . "</p>";
        if (!empty($row['image_url'])) {
            echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='Photo de " . htmlspecialchars($row['animal_name']) . "' style='width: 100%; height: auto;'>";
        } else {
            echo "<p>Aucune image disponible</p>";
        }
    } else {
        echo "<p>Aucun détail trouvé pour cet animal.</p>";
    }
} else {
    echo "<p>ID de l'animal non spécifié ou invalide.</p>";
}

$conn->close();
?>