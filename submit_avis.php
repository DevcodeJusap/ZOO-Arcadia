<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $avis = $_POST['avis'];
    $note = $_POST['note'];
    $age = isset($_POST['age']) ? $_POST['age'] : null;

    if (empty($age)) {
        $age = null;
    }

    $sql = "INSERT INTO avis (nom, avis, note, age, status) VALUES (?, ?, ?, ?, 'en attente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $nom, $avis, $note, $age);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: merci.html");
        exit();
    } else {
        echo "Erreur lors de la soumission de l'avis.";
    }

    $stmt->close();
    $conn->close();
}
?>