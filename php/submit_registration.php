<?php
session_start();
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    die("Erreur de sécurité : token CSRF invalide.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];
$password = $_POST['password']; // Nouveau champ

$sql = "INSERT INTO registration_requests (name, email, role, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $role, $password);

if ($stmt->execute()) {
    echo "<div class='alert alert-success'>Inscription réussie ! Vous serez redirigé vers la page de connexion dans 5 secondes.</div>";
    echo "<script>
            setTimeout(function() {
                window.location.href = '/login.html';
            }, 5000);
        </script>";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>