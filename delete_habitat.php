<?php
include 'session_check.php';
$conn = new mysqli("localhost", "376865", "Marley2809", "zooarcadiaa_zoo");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("DELETE FROM habitats WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: manage_habitats.php");
exit();

$conn->close();
?>