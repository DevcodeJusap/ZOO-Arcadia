<?php
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

session_start();
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    die("Erreur de sécurité : token CSRF invalide.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    $sql = "SELECT name, email, role, password FROM registration_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $stmt->bind_result($name, $email, $role, $password);
    $stmt->fetch();
    $stmt->close();

    if (empty($name) || empty($email) || empty($role) || empty($password)) {
        die("Erreur : Les informations de la demande sont incorrectes ou manquantes.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO employe (name, email, role, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $role, $hashed_password);

    if ($stmt->execute()) {
        $stmt->close();
        $sql = "DELETE FROM registration_requests WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->close();
        header("Location: manage_employe.php?msg=validation_ok");
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'employé.";
    }
} else {
    echo "Requête invalide.";
}

$conn->close();
?>