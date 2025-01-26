<?php
include 'db_connection.php'; // Assurez-vous d'inclure votre fichier de connexion à la base de données

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM animals WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $animal = $result->fetch_assoc();
    } else {
        echo "Animal non trouvé.";
        exit;
    }
} else {
    echo "ID non spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_animal'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $animal_name = $conn->real_escape_string($_POST['animal_name']);
    $image_url = $conn->real_escape_string($_POST['image_url']);
    $habitat_name = $conn->real_escape_string($_POST['habitat_name']);

    $sql = "UPDATE animals SET animal_name='$animal_name', image_url='$image_url', habitat_name='$habitat_name' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Animal mis à jour avec succès !'); window.location.href='employe_dashboard.php';</script>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Animal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier Animal</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
            <div class="form-group">
                <label for="animal_name">Nom de l'animal</label>
                <input type="text" class="form-control" id="animal_name" name="animal_name" value="<?php echo $animal['animal_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="image_url">URL de l'image</label>
                <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo $animal['image_url']; ?>" required>
            </div>
            <div class="form-group">
                <label for="habitat_name">Nom de l'habitat</label>
                <input type="text" class="form-control" id="habitat_name" name="habitat_name" value="<?php echo $animal['habitat_name']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_animal">Mettre à jour</button>
        </form>
    </div>
</body>
</html>