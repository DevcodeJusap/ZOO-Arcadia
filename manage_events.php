<?php
include 'navbar.php';
include 'nav-vertical.php';
include 'session_check.php';
include 'db_connection.php'; // Assurez-vous d'inclure votre fichier de connexion à la base de données

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
$result = $conn->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des événements</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
        <div class="card mt-3">
            <div class="card-header">
                Liste des événements
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Articles</th>
                            <th>Photos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['Titre']; ?></td>
                                <td><?php echo $row['Articles']; ?></td>
                                <td><?php echo $row['Photos']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>