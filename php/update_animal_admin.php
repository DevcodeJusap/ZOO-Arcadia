<?php
header('Content-Type: application/json');
session_start();

// Connexion à la base de données
include 'db_connection.php';

$response = array('success' => false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $animal_name = $_POST['animal_name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $food = $_POST['food'];
    $food_quantity = $_POST['food_quantity'];
    $last_meal = $_POST['last_meal'];
    $health_comment = $_POST['health_comment'];
    $private_comment = $_POST['private_comment'];

    // Vérifiez que toutes les données nécessaires sont présentes
    if (
        isset($id, $animal_name, $species, $age, $weight, $food, $food_quantity, $last_meal, $health_comment, $private_comment)
    ) {
        $sql = "UPDATE animals SET animal_name=?, species=?, age=?, weight=?, food=?, food_quantity=?, last_meal=?, health_comment=?, private_comment=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $response['error'] = 'Erreur de préparation de la requête: ' . $conn->error;
        } else {
            $stmt->bind_param(
                'ssidsdsssi',
                $animal_name,
                $species,
                $age,
                $weight,
                $food,
                $food_quantity,
                $last_meal,
                $health_comment,
                $private_comment,
                $id
            );
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = 'Erreur lors de l\'exécution de la requête: ' . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $response['error'] = 'Données manquantes';
    }
} else {
    $response['error'] = 'Méthode de requête non autorisée';
}

$conn->close();
echo json_encode($response);
?>