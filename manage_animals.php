<?php
include 'navbar.php';
include 'nav-vertical.php';
include 'session_check.php';
include 'db_config.php';

$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Ajouter un nouvel animal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_animal'])) {
    $animal_name = $conn->real_escape_string($_POST['animal_name']);
    $habitat_name = $conn->real_escape_string($_POST['habitat_name']);
    $species = $conn->real_escape_string($_POST['species']);
    $age = intval($_POST['age']);
    $weight = floatval($_POST['weight']);
    $last_meal = $conn->real_escape_string($_POST['last_meal']);
    $food = $conn->real_escape_string($_POST['food']);
    $food_quantity = floatval($_POST['food_quantity']);
    $unité_nourriture = $conn->real_escape_string($_POST['unité_nourriture']);
    $private_comment = isset($_POST['private_comment']) ? $conn->real_escape_string($_POST['private_comment']) : '';
    $image_url = $conn->real_escape_string($_POST['image_url']);

    $sql = "INSERT INTO animals (animal_name, habitat_name, species, age, weight, last_meal, food, food_quantity, unité_nourriture, private_comment, image_url) 
            VALUES ('$animal_name', '$habitat_name', '$species', $age, $weight, '$last_meal', '$food', $food_quantity, '$unité_nourriture', '$private_comment', '$image_url')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouvel animal ajouté avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}

// Mettre à jour un animal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_animal'])) {
    $id = intval($_POST['id']);
    $animal_name = $conn->real_escape_string($_POST['animal_name']);
    $habitat_name = $conn->real_escape_string($_POST['habitat_name']);
    $species = $conn->real_escape_string($_POST['species']);
    $age = intval($_POST['age']);
    $weight = floatval($_POST['weight']);
    $last_meal = $conn->real_escape_string($_POST['last_meal']);
    $food = $conn->real_escape_string($_POST['food']);
    $food_quantity = floatval($_POST['food_quantity']);
    $unité_nourriture = $conn->real_escape_string($_POST['unité_nourriture']);
    $private_comment = isset($_POST['private_comment']) ? $conn->real_escape_string($_POST['private_comment']) : '';
    $image_url = $conn->real_escape_string($_POST['image_url']);

    $sql = "UPDATE animals SET animal_name='$animal_name', habitat_name='$habitat_name', species='$species', age=$age, weight=$weight, last_meal='$last_meal', food='$food', food_quantity=$food_quantity, unité_nourriture='$unité_nourriture', private_comment='$private_comment', image_url='$image_url' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Animal mis à jour avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}

// Supprimer un animal
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM animals WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Animal supprimé avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}

// Récupérer la liste des animaux
$sql = "SELECT * FROM animals";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les animaux</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Gérer les animaux</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAnimalModal">Créer</button>

        <!-- Modal pour ajouter un nouvel animal -->
        <div class="modal fade" id="addAnimalModal" tabindex="-1" role="dialog" aria-labelledby="addAnimalModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAnimalModalLabel">Ajouter un nouvel animal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="manage_animals.php">
                        <div class="form-group">
                                <label for="habitat_name">Habitat</label>
                                <input type="text" class="form-control" id="habitat_name" name="habitat_name" required>
                            </div>
                            <div class="form-group">
                                <label for="animal_name">Nom de l'animal</label>
                                <input type="text" class="form-control" id="animal_name" name="animal_name" required>
                            </div>
                            <div class="form-group">
                                <label for="species">Espèce</label>
                                <input type="text" class="form-control" id="species" name="species" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Âge</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="weight">Poids (en Kg)</label>
                                <input type="number" class="form-control" id="weight" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="last_meal">Dernier repas (date et heure)</label>
                                <input type="datetime-local" class="form-control" id="last_meal" name="last_meal" required>
                            </div>
                            <div class="form-group">
                                <label for="food">Nourriture</label>
                                <input type="text" class="form-control" id="food" name="food" required>
                            </div>
                            <div class="form-group">
                                <label for="food_quantity">Quantité de nourriture (en Kg)</label>
                                <input type="number" class="form-control" id="food_quantity" name="food_quantity" required>
                            </div>
                            <div class="form-group">
                                <label for="unité_nourriture">Unité de nourriture</label>
                                <input type="text" class="form-control" id="unité_nourriture" name="unité_nourriture" required>
                            </div>
                            <div class="form-group">
                                <label for="private_comment">Commentaire privé</label>
                                <textarea class="form-control" id="private_comment" name="private_comment" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image_url">URL de l'image</label>
                                <input type="text" class="form-control" id="image_url" name="image_url" required>
                            </div>
                            <button type="submit" name="add_animal" class="btn btn-primary">Ajouter l'animal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour modifier un animal -->
        <div class="modal fade" id="editAnimalModal" tabindex="-1" role="dialog" aria-labelledby="editAnimalModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAnimalModalLabel">Modifier l'animal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="manage_animals.php">
                            <input type="hidden" id="edit_id" name="id">
                            <div class="form-group">
                                <label for="edit_habitat_name">Habitat</label>
                                <input type="text" class="form-control" id="edit_habitat_name" name="habitat_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_animal_name">Nom de l'animal</label>
                                <input type="text" class="form-control" id="edit_animal_name" name="animal_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_species">Espèce</label>
                                <input type="text" class="form-control" id="edit_species" name="species" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_age">Âge</label>
                                <input type="number" class="form-control" id="edit_age" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_weight">Poids (en Kg)</label>
                                <input type="number" class="form-control" id="edit_weight" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_last_meal">Dernier repas (date et heure)</label>
                                <input type="datetime-local" class="form-control" id="edit_last_meal" name="last_meal" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_food">Nourriture</label>
                                <input type="text" class="form-control" id="edit_food" name="food" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_food_quantity">Quantité de nourriture (en Kg)</label>
                                <input type="number" class="form-control" id="edit_food_quantity" name="food_quantity" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_unité_nourriture">Unité de nourriture</label>
                                <input type="text" class="form-control" id="edit_unité_nourriture" name="unité_nourriture" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_private_comment">Commentaire privé</label>
                                <textarea class="form-control" id="edit_private_comment" name="private_comment" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_image_url">URL de l'image</label>
                                <input type="text" class="form-control" id="edit_image_url" name="image_url" required>
                            </div>
                            <button type="submit" name="update_animal" class="btn btn-primary">Mettre à jour l'animal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h3>Liste des animaux</h3>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>habitat</th>
                    <th>Nom</th>
                    <th>Espèce</th>
                    <th>Âge</th>
                    <th>Poids (en Kg)</th>
                    <th>Dernier Repas</th>
                    <th>Nourriture</th>
                    <th>Quantité (en Kg)</th>
                    <th>Commentaire privé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if (!empty($row['image_url'])) {
                            echo "<td><img src='" . htmlspecialchars($row['image_url']) . "' alt='Photo de " . htmlspecialchars($row['animal_name']) . "' style='height: 100px;'></td>";
                        } else {
                            echo "<td>Aucune image</td>";
                        }
                        echo "<td>" . htmlspecialchars($row['habitat_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['animal_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['species']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['weight']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_meal']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['food']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['food_quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['private_comment']) . "</td>";
                        echo "<td>
                                <button class='btn btn-warning btn-sm edit-btn' data-id='" . $row["id"] . "' data-toggle='modal' data-target='#editAnimalModal'>Modifier</button>
                                <a href='manage_animals.php?delete_id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Supprimer</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10' class='text-center'>Aucun animal trouvé</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.edit-btn').on('click', function(){
                var id = $(this).data('id');
                $.ajax({
                    url: 'get_animal_details.php',
                    type: 'GET',
                    data: {id: id},
                    success: function(response){
                        var animal = JSON.parse(response);
                        $('#edit_id').val(animal.id);
                        $('#edit_habitat_name').val(animal.habitat_name);
                        $('#edit_animal_name').val(animal.animal_name);
                        $('#edit_species').val(animal.species);
                        $('#edit_age').val(animal.age);
                        $('#edit_weight').val(animal.weight);
                        $('#edit_last_meal').val(animal.last_meal);
                        $('#edit_food').val(animal.food);
                        $('#edit_food_quantity').val(animal.food_quantity);
                        $('#edit_unité_nourriture').val(animal.unité_nourriture);
                        $('#edit_private_comment').val(animal.private_comment);
                        $('#edit_image_url').val(animal.image_url);
                    }
                });
            });
        });
    </script>
</body>
</html>