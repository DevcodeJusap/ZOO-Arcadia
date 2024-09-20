<?php
include 'session_check.php';
$servername = "mysql-zooarcadiaa.alwaysdata.net";
$username = "376865";
$password = "Marley2809";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$request_id = $_POST['request_id'];

$sql = "SELECT name, email, role FROM registration_requests WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erreur de préparation de la requête : " . $conn->error);
}
$stmt->bind_param("i", $request_id);
$stmt->execute();
$stmt->bind_result($name, $email, $role);
$stmt->fetch();
$stmt->close();

if (empty($name) || empty($email) || empty($role)) {
    die("Erreur : Les informations de la demande sont incorrectes ou manquantes.");
}

$sql = "INSERT INTO employe (name, email, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erreur de préparation de la requête : " . $conn->error);
}
$stmt->bind_param("sss", $name, $email, $role);

if ($stmt->execute()) {
    $sql = "DELETE FROM registration_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    echo "Demande approuvée et employé ajouté !";
} else {
    echo "Erreur lors de l'insertion dans employees : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>