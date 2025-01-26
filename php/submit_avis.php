<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $avis = $_POST['avis'];
    $note = $_POST['note'];
    $titre = $_POST['titre'];;



    $sql = "INSERT INTO avis (nom, avis, note, titre, status) VALUES (?, ?, ?, ?, 'en attente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $nom, $avis, $note, $titre);
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