<?php
// track_visitors.php

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer l'adresse IP du visiteur
$ip_address = $_SERVER['REMOTE_ADDR'];

// Récupérer le user agent du visiteur
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Insérer les informations du visiteur dans la base de données
$sql = "INSERT INTO visitors (ip_address, user_agent) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $ip_address, $user_agent);
$stmt->execute();
$stmt->close();

// Fermer la connexion
$conn->close();
?>