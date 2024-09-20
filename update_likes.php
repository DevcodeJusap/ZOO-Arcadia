<?php
include 'session_check.php';
$servername = "localhost";
$username = "376865";
$password = "Marley2809";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animalId = $_POST['animal_id'];

    $sql = "SELECT likes FROM animal_likes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $animalId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE animal_likes SET likes = likes + 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $animalId);
        $stmt->execute();
    } else {
        $sql = "INSERT INTO animal_likes (id, likes) VALUES (?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $animalId);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        echo "Success";
    } else {
        echo "Error";
    }

    $stmt->close();
}

$conn->close();
?>