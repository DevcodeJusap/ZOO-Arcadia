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
    <style>
        .small-text {
            font-size: 0.8em; /* Réduit la taille de la police */
        }
    </style>
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
            <h3>Statistiques</h3>
                <div class="info-block" id="visitors">
                    <?php
                    // Exemple de requête pour récupérer les statistiques des visiteurs
                    $sql_visitors = "SELECT COUNT(*) as total_visitors FROM visitors";
                    $result_visitors = $conn->query($sql_visitors);
                    if ($result_visitors->num_rows > 0) {
                        $row_visitors = $result_visitors->fetch_assoc();
                        echo "<p>Nombre total de visiteurs : " . htmlspecialchars($row_visitors["total_visitors"]) . "</p>";
                    } else {
                        echo "<p>Aucune donnée disponible</p>";
                    }
                    ?>
                </div>
                <div class="info-block">
                    <h3>Messages reçus</h3>
                    <?php if ($result_messages->num_rows > 0): ?>
                        <ul class="list-group">
                            <?php while($row = $result_messages->fetch_assoc()): ?>
                                <li class="list-group-item">
                                    <strong><?php echo $row['name']; ?></strong> (<?php echo $row['email']; ?>) a écrit :
                                    <p><?php echo $row['message']; ?></p>
                                    <form method="post" action="delete_message.php" class="delete-message-form" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>Aucun message reçu.</p>
                    <?php endif; ?>
                </div>
                <div class="info-block" id="block3">
                    <h3>Bloc 3</h3>
                    <p>Contenu du bloc 3</p>
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
                            // Requête pour récupérer les animaux et leurs likes depuis la table animals, triés par nombre de likes
                            $sql_animals = "SELECT id, animal_name, likes FROM animals ORDER BY likes DESC";
                            $result_animals = $conn->query($sql_animals);

                            if ($result_animals->num_rows > 0) {
                                while($row_animals = $result_animals->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><a href='#' class='animal-link' data-toggle='modal' data-target='#animalModal' data-id='" . $row_animals["id"] . "'>" . htmlspecialchars($row_animals["animal_name"]). "</a></td>";
                                    echo "<td>" . htmlspecialchars($row_animals["likes"]). "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>Aucun animal trouvé</td></tr>";
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
                    <!-- Contenu du modal sera chargé ici via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="javascript/dashboard.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#animalModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var animalId = button.data('id');

            $.ajax({
                url: 'get_animal_details.php',
                type: 'GET',
                data: { id: animalId },
                success: function(response) {
                    $('#animalModal .modal-body').html(response);
                },
                error: function() {
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
            // Gestion de la suppression des messages avec AJAX
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
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updateSections() {
                    // Mettre à jour les statistiques des visiteurs
                    fetch('fetch_visitors_stats.php')
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('visitors-stats').innerHTML = data;
                        })
                        .catch(error => console.error('Erreur:', error));

                    // Mettre à jour les messages reçus d'un visiteur
                    fetch('fetch_messages.php')
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('visitor-messages').innerHTML = data;
                        })
                        .catch(error => console.error('Erreur:', error));

                    // Mettre à jour la liste des animaux
                    fetch('fetch_animals_list.php')
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('animals-list').innerHTML = data;
                        })
                        .catch(error => console.error('Erreur:', error));
                }

                function refreshDashboard() {
                    fetch('php/frech_data.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                console.error(data.error);
                            } else {
                                // Mettez à jour votre tableau de bord avec les données reçues
                                console.log(data);
                                // Exemple de mise à jour d'un élément avec les nouvelles données
                                document.getElementById('dashboardElement').innerText = JSON.stringify(data);
                            }
                        })
                        .catch(error => console.error('Erreur:', error));
                }

                // Mettre à jour les sections toutes les 10 secondes
                setInterval(updateSections, 10000);

                // Rafraîchir le tableau de bord toutes les 5 minutes
                setInterval(refreshDashboard, 300000); // 300000 ms = 5 minutes

                // Appeler les fonctions une fois au chargement de la page
                updateSections();
                refreshDashboard();
            });
    </script>
</body>
</html>
<?php
$conn->close();
?>