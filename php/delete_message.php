<?php

include 'session_check.php';
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

// Récupérer l'ID du message à supprimer
$id = $_POST['id'];

// Supprimer le message de la base de données
$sql = "DELETE FROM messages WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Message supprimé avec succès";
} else {
    echo "Erreur lors de la suppression du message: " . $conn->error;
}

$conn->close();

// Rediriger vers le tableau de bord
header("Location: dashboard.php");
exit();
?>