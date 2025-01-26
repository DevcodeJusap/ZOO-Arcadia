<?php
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = intval($_POST['animal_id']);
    
    // Mettre à jour le nombre de likes dans la base de données
    $update_query = "UPDATE animals SET likes = likes + 1 WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $animal_id);
    if ($stmt->execute()) {
        // Récupérer le nouveau nombre de likes
        $select_query = "SELECT likes FROM animals WHERE id = ?";
        $stmt = $conn->prepare($select_query);
        $stmt->bind_param("i", $animal_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $new_likes = $row['likes'];
        
        // Retourner le nouveau nombre de likes en JSON
        echo json_encode(['success' => true, 'new_likes' => $new_likes]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
}

$conn->close();
?>