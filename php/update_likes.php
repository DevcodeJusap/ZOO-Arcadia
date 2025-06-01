<?php
include 'session_check.php';
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$animalId = isset($_POST['animal_id']) ? intval($_POST['animal_id']) : 0;

if ($animalId > 0) {
    // Mise à jour des likes
    $stmt = $conn->prepare('UPDATE animal_likes SET likes = likes + 1 WHERE id = ?');
    $stmt->bind_param('i', $animalId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Récupérer le nouveau nombre de likes
        $stmt2 = $conn->prepare("SELECT likes FROM animal_likes WHERE id = ?");
        $stmt2->bind_param('i', $animalId);
        $stmt2->execute();
        $stmt2->bind_result($likes);
        $stmt2->fetch();
        echo json_encode(['success' => true, 'new_likes' => $likes]);
        $stmt2->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update likes']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid animal ID']);
}

$conn->close();