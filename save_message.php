<?php
// filepath: /c:/Users/julie/Desktop/ZOO-Arcadia/save_message.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données POST
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$email = $data['email'];
$message = $data['message'];

// Insérer les données dans la base de données
$sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>