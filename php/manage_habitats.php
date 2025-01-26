<?php
session_start();
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Modifiez la requête SQL en fonction des colonnes existantes dans votre table 'animals'
$sql = "SELECT animals.id, animals.animal_name, animals.species, animals.age, animals.weight, animals.food_quantity, animals.private_comment, animals.unité_nourriture, COALESCE(animal_likes.likes, 0) AS likes, animals.image_url 
        FROM animals 
        LEFT JOIN animal_likes ON animals.id = animal_likes.id
        ORDER BY likes DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Erreur dans la requête SQL : " . $conn->error);
}

// Récupérer les messages
$sql_messages = "SELECT id, name, email, message FROM messages";
$result_messages = $conn->query($sql_messages);

if (!$result_messages) {
    die("Erreur dans la requête SQL pour les messages : " . $conn->error);
}

// Récupérer les habitats
$sql_habitats = "SELECT * FROM habitats";
$result_habitats = $conn->query($sql_habitats);

if (!$result_habitats) {
    die("Erreur dans la requête SQL pour les habitats : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Zoo-Arcadia</title>
    <link rel="stylesheet" href="\css\dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    url: 'fetch_data.php',
                    method: 'GET',
                    success: function(data) {
                        $('#data-table').html(data);
                    }
                });
            }
            fetchData();
            setInterval(fetchData, 5000); // Rafraîchit toutes les 5 secondes
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="index.php" class="btn btn-danger">Déconnexion</a>
            <img src="\image\presentation\logo.webp" alt="Logo" style="height: 100px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_dashboard.php">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_habitats.php">Gérer les habitats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_animals.php">Gérer les animaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_services.php">Gérer les services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_employe.php">Gérer les utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_events.php">Gérer les articles événements</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createHabitatModal">
                    Créer un Habitat
                </button>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="createHabitatModal" tabindex="-1" role="dialog" aria-labelledby="createHabitatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createHabitatModalLabel">Créer un Habitat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createHabitatForm">
                        <div class="form-group">
                            <label for="habitatName">Nom de l'Habitat</label>
                            <input type="text" class="form-control" id="habitatName" name="habitatName" required>
                        </div>
                        <div class="form-group">
                            <label for="habitatDescription">Description</label>
                            <textarea class="form-control" id="habitatDescription" name="habitatDescription" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="info-block" id="habitats-list">
                    <?php
                    $sql_habitats = "SELECT * FROM habitats";
                    $result_habitats = $conn->query($sql_habitats);

                    if ($result_habitats->num_rows > 0) {
                        while($row = $result_habitats->fetch_assoc()) {
                            echo "<div class='habitat-block'>";
                            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                            echo "</div>";
                            echo "<hr>"; // Ajout de la ligne horizontale pour séparer les habitats
                        }
                    } else {
                        echo "<p>Aucun habitat trouvé.</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <h2>Liste des animaux</h2>
                <div class="table-responsive" id="animals-list">
                    <table class="table table-sm table-bordered table-striped table-hover small-text">
                        <thead>
                            <tr>
                                <th>Nom de l'animal</th>
                                <th>Likes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_animals = "SELECT animal_name, likes FROM animals";
                            $result_animals = $conn->query($sql_animals);

                            if ($result_animals->num_rows > 0) {
                                while($row = $result_animals->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['animal_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['likes']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>Aucun animal trouvé.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour afficher les détails de l'animal -->
    <div class="modal fade" id="animalModal" tabindex="-1" role="dialog" aria-labelledby="animalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="animalModalLabel">Détails de l'animal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Les détails de l'animal seront chargés ici -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#animalModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var animalId = button.data('id');
            console.log('Bouton cliqué, ID de l\'animal:', animalId);

            if (!animalId) {
                console.error('L\'ID de l\'animal est manquant.');
                return;
            }

            $.ajax({
                url: 'get_animal_details.php',
                type: 'GET',
                data: { id: animalId },
                success: function(response) {
                    console.log('Réponse reçue:', response);
                    $('#animalModal .modal-body').html(response);
                },
                error: function() {
                    console.error('Erreur lors du chargement des détails de l\'animal.');
                    $('#animalModal .modal-body').html('<p>Une erreur est survenue lors du chargement des détails de l\'animal.</p>');
                }
            });
        });

        $('.delete-message-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    form.closest('li').remove();
                },
                error: function() {
                    alert('Erreur lors de la suppression du message.');
                }
            });
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#createHabitatForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'create_habitat.php',
                data: formData,
                success: function(response) {
                    alert('Habitat créé avec succès !');
                    location.reload(); // Recharger la page pour afficher le nouvel habitat
                },
                error: function() {
                    alert('Erreur lors de la création de l\'habitat.');
                }
            });
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        function updateSections() {
            // Mettre à jour la liste des animaux
            $.ajax({
                url: 'fetch_animals_list.php',
                method: 'GET',
                success: function(data) {
                    $('#animals-list').html(data);
                }
            });
        }

        // Mettre à jour les sections toutes les 10 secondes
        setInterval(updateSections, 10000);

        // Appeler la fonction une fois au chargement de la page
        updateSections();
    });
    </script>
</body>
</html>

