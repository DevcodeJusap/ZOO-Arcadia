<?php
include 'session_check.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("mysql-zooarcadiaa.alwaysdata.net", "376865", "Marley2809", "zooarcadiaa_zoo");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM animals WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$animal = $result->fetch_assoc();

$animal_name = $animal['animal_name'];
$habitat_name = $animal['habitat_name'];
$species = $animal['species'];
$age = $animal['age'];
$weight = $animal['weight'];
$food = $animal['food'];
$dernier_repas = $animal['dernier_repas'];
$quantité_de_nourriture = $animal['quantité_de_nourriture'];
$unité_nourriture = $animal['unité_nourriture'];
$health_comment = $animal['health_comment'];
$private_comment = $animal['private_comment'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_name = $_POST['animal_name'];
    $habitat_name = $_POST['habitat_name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $food = $_POST['food'];
    $dernier_repas = $_POST['dernier_repas'];
    $quantité_de_nourriture = $_POST['quantité_de_nourriture'];
    $unité_nourriture = $_POST['unité_nourriture'];
    $health_comment = $_POST['health_comment'];
    $private_comment = $_POST['private_comment'];

    $sql = "UPDATE animals SET animal_name = ?, habitat_name = ?, species = ?, age = ?, weight = ?, food = ?, dernier_repas = ?, quantité_de_nourriture = ?, unité_nourriture = ?, health_comment = ?, private_comment = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $animal_name, $habitat_name, $species, $age, $weight, $food, $dernier_repas, $quantité_de_nourriture, $unité_nourriture, $health_comment, $private_comment, $id);

    if ($stmt->execute()) {
        header("Location: manage_animals.php");
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer un animal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Éditer un animal</h2>
        <form action="edit_animal.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="animal_name">Nom de l'animal :</label>
                <input type="text" class="form-control" id="animal_name" name="animal_name" value="<?php echo htmlspecialchars($animal_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="habitat_name">Habitat :</label>
                <select class="form-control" id="habitat_name" name="habitat_name" required>
                    <option value="La Savane" <?php if ($habitat_name == 'La Savane') echo 'selected'; ?>>La Savane</option>
                    <option value="Les Marais" <?php if ($habitat_name == 'Les Marais') echo 'selected'; ?>>Les Marais</option>
                    <option value="La Jungle" <?php if ($habitat_name == 'La Jungle') echo 'selected'; ?>>La Jungle</option>
                </select>
            </div>
            <div class="form-group">
                <label for="species">Espèce :</label>
                <input type="text" class="form-control" id="species" name="species" value="<?php echo htmlspecialchars($species); ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Âge :</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" required>
                    <div class="input-group-append">
                        <span class="input-group-text">ans</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="weight">Poids :</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="weight" name="weight" value="<?php echo htmlspecialchars($weight); ?>" required>
                    <div class="input-group-append">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="food">Nourriture :</label>
                <input type="text" class="form-control" id="food" name="food" value="<?php echo htmlspecialchars($food); ?>" required>
            </div>
            <div class="form-group">
                <label for="dernier_repas">Dernier repas :</label>
                <input type="datetime-local" class="form-control" id="dernier_repas" name="dernier_repas" value="<?php echo htmlspecialchars($dernier_repas); ?>" required>
            </div>
            <div class="form-group">
                <label for="quantité_de_nourriture">Quantité de nourriture :</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="quantité_de_nourriture" name="quantité_de_nourriture" value="<?php echo htmlspecialchars($quantité_de_nourriture); ?>" required>
                    <select class="form-control" id="unité_nourriture" name="unité_nourriture" required>
                        <option value="grammes" <?php if ($unité_nourriture == 'grammes') echo 'selected'; ?>>grammes</option>
                        <option value="kg" <?php if ($unité_nourriture == 'kg') echo 'selected'; ?>>kg</option>
                        <option value="Litre" <?php if ($unité_nourriture == 'Litre') echo 'selected'; ?>>Litre</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="health_comment">Commentaire Santé :</label>
                <textarea class="form-control" id="health_comment" name="health_comment" rows="3" required><?php echo htmlspecialchars($health_comment); ?></textarea>
            </div>
            <div class="form-group">
                <label for="private_comment">Commentaire Privé :</label>
                <textarea class="form-control" id="private_comment" name="private_comment" rows="3" required><?php echo htmlspecialchars($private_comment); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>