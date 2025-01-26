<?php
session_start();

include 'session_check.php';
$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

include 'db_connection.php';

// Gérer l'ajout des avis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_avis'])) {
    $titre = $conn->real_escape_string($_POST['titre']);
    $nom = $conn->real_escape_string($_POST['nom']);
    $avis = $conn->real_escape_string($_POST['avis']);
    $note = $conn->real_escape_string($_POST['note']);
    $status = 'en attente';

    $sql = "INSERT INTO avis (titre, nom, avis, note, status) VALUES ('$titre', '$nom', '$avis', '$note', '$status')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Avis ajouté avec succès !');</script>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}

// Gérer la validation des avis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['validate_avis'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $sql = "UPDATE avis SET status='validé' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Avis validé avec succès !');</script>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}

// Récupérer les avis en attente
$sql_avis = "SELECT * FROM avis WHERE status = 'en attente'";
$result_avis = $conn->query($sql_avis);

// Récupérer les animaux de la savane
$sql_animals = "SELECT id, image_url, animal_name FROM animals WHERE habitat_name = 'savane'";
$result_animals = $conn->query($sql_animals);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Zoo-Arcadia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            <img src="\image\presentation\logo.webp" alt="Logo" style="height: 100px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="employe_dashboard.php">Tableau de bord</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="bg-primary text-white text-center py-3">
        <h1>Bienvenue dans l'équipe habitat <?php echo $_SESSION['habitat']; ?>!</h1>
    </header>

    <main class="container mt-4">

        <section class="avis-validation">
            <div class="mt-5 ">
            <h2 class="mb-4">Avis en attente de validation</h2>
            <?php
            if ($result_avis->num_rows > 0) {
                echo '<div class="row">';
                while($row = $result_avis->fetch_assoc()) {
                    echo '<div class="col-md-6 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['titre'] . '</h5>';
                    echo '<p class="card-text">' . $row['avis'] . '</p>';
                    echo '<p><strong>Nom :</strong> ' . $row['nom'] . '</p>';
                    echo '<p><strong>Note :</strong> ' . $row['note'] . '</p>';
                    echo '<p><strong>Status :</strong> ' . $row['status'] . '</p>';
                    echo '<form method="POST" action="">';
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '<button type="submit" class="btn btn-success" name="validate_avis">Valider</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>Aucun avis en attente de validation.</p>';
            }
            ?>
            </div>
        </section>

        <section class="animals-modif">
            <h2>Animaux dans la savane</h2>
            <?php
            if ($result_animals->num_rows > 0) {
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Photo</th>';
                echo '<th>Nom</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while($row = $result_animals->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td><img src="' . $row['image_url'] . '" alt="' . $row['animal_name'] . '" style="width:100px;height:auto;"></td>';
                    echo '<td>' . $row['animal_name'] . '</td>';
                    echo '<td>';
                    echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAnimalModal" data-id="' . $row['id'] . '">Modifier</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>Aucun animal trouvé dans la savane.</p>';
            }
            ?>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="editAnimalModal" tabindex="-1" role="dialog" aria-labelledby="editAnimalModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAnimalModalLabel">Modifier Animal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editAnimalForm">
                            <input type="hidden" id="animal_id" name="id">
                            <div class="form-group">
                                <label for="animal_weight">Poids (kg)</label>
                                <input type="number" class="form-control" id="animal_weight" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="animal_food">Nourriture</label>
                                <input type="text" class="form-control" id="animal_food" name="food" required>
                            </div>
                            <div class="form-group">
                                <label for="food_quantity">Quantité (kg)</label>
                                <input type="number" class="form-control" id="food_quantity" name="food_quantity" required>
                            </div>
                            <div class="form-group">
                                <label for="last_meal">Date et Heure</label>
                                <input type="datetime-local" class="form-control" id="last_meal" name="last_meal" required>
                            </div>
                            <div class="form-group">
                                <label for="private_comment">Commentaires privés</label>
                                <textarea class="form-control" id="private_comment" name="private_comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function() {
            $('#editAnimalModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var animalId = button.data('id');

                $.ajax({
                    url: 'get_animal.php',
                    method: 'GET',
                    data: { id: animalId },
                    success: function(response) {
                        var animal = JSON.parse(response);
                        $('#animal_id').val(animal.id);
                        $('#editAnimalModalLabel').text('Modifier ' + animal.animal_name);
                        $('#animal_weight').val(animal.weight);
                        $('#animal_food').val(animal.food);
                        $('#food_quantity').val(animal.food_quantity);
                        $('#last_meal').val(animal.last_meal);
                        $('#private_comment').val(animal.private_comment);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la récupération des données de l\'animal:', error);
                    }
                });
            });

            $('#editAnimalForm').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: 'update_animal.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Animal mis à jour avec succès !');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la mise à jour de l\'animal:', error);
                    }
                });
            });
        });
        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editAnimalForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Empêche la soumission normale du formulaire

                // Récupère les données du formulaire
                const formData = new FormData(this);

                // Affiche les données du formulaire pour le débogage
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                // Envoie les données via AJAX
                fetch('update_animal.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Ferme le modal
                        $('#editAnimalModal').modal('hide');
                        // Actualise les informations de l'animal sur la page (à implémenter)
                        alert('Animal mis à jour avec succès');
                    } else {
                        alert('Erreur lors de la mise à jour de l\'animal: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour de l\'animal');
                });
            });
        });
        </script>

    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>