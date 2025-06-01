<?php

include 'session_check.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    

    if (isset($_POST['action']) && $_POST['action'] === 'reject' && isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM registration_requests WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: manage_employe.php?msg=refus_ok");
            exit();
        } else {
            echo "Erreur : Aucun enregistrement supprimé.";
        }

        $stmt->close();
    } else {
        echo "Error: Invalid request. Action or ID missing.";
    }
} else {
    echo "Error: Invalid request method.";
}

$conn->close();
?>