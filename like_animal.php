<?php
include 'session_check.php';
$servername = "localhost";
$username = "376865";
$password = "Marley2809";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$action = $_POST['action'];
$animal_id = $_POST['animal_id'];

if ($action == 'like') {
    $sql = "UPDATE animal_likes SET likes = likes + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $animal_id);

    if ($stmt->execute()) {
        $sql = "SELECT likes FROM animal_likes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $animal_id);
        $stmt->execute();
        $stmt->bind_result($likes);
        $stmt->fetch();
        echo $likes;
    } else {
        echo "Erreur lors de la mise à jour des likes";
    }
    $stmt->close();
}

$conn->close();
?>