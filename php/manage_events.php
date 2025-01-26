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

// Insertion d'un nouvel événement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
    $articles = filter_input(INPUT_POST, 'articles', FILTER_SANITIZE_SPECIAL_CHARS);
    $photos = filter_input(INPUT_POST, 'photos', FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $conn->prepare("INSERT INTO events (Titre, Articles, Photos) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $titre, $articles, $photos);
    $stmt->execute();
    $stmt->close();
}

// Récupération des événements existants
$sql = "SELECT id, Titre, Articles, Photos FROM events";
$result = $conn->query($sql);
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
    
    <div class="container col-md-8">
        <h2>Gestion des événements</h2>
        <div class="card mt-3">
            <div class="card-header">
                Ajouter un nouvel événement
            </div>
            <div class="card-body">
                <form method="post" action="manage_events.php">
                    <div class="form-group">
                        <label for="titre">Titre de l'événement</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="articles">Articles</label>
                        <textarea class="form-control" id="articles" name="articles" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photos">Photos (URL)</label>
                        <input type="text" class="form-control" id="photos" name="photos" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
        <div class="card md-4">
            <div class="card-header">
                Liste des événements
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                    <?php
                        if ($result->num_rows > 0) {
                            // Afficher chaque événement
                            while($row = $result->fetch_assoc()) {
                                echo '<div class="col-md-3 mt-4">'; // Réduire la taille de la colonne
                                echo '<div class="card">';
                                echo '<img src="' . $row["Photos"] . '" class="card-img-top" alt="Image de l\'événement">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . $row["Titre"] . '</h5>';
                                echo '<p class="card-text">' . substr($row["Articles"], 0, 50) . '...</p>'; // Limiter la longueur du texte
                                echo '<form method="POST" action="publish_event.php">';
                                echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                                echo '<button type="submit" class="btn btn-primary btn-sm">Publier</button>'; // Réduire la taille du bouton
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "Aucun événement trouvé.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="javascript/dashboard.js"></script>
</body>
</html>

