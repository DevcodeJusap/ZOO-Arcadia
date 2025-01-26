<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT id, animal_name, species, weight, food, last_meal, food_quantity, private_comment FROM animals WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Animal non trouvé.']);
    }
} else {
    echo json_encode(['error' => 'ID non spécifié.']);
}
?>