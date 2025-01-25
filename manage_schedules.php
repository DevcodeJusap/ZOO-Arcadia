<?php
include 'navbar.php';
include 'nav-vertical.php';
include 'session_check.php';
include 'db_connection.php'; // Assurez-vous d'inclure votre fichier de connexion à la base de données

// Insertion d'un nouvel horaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $conn->prepare("INSERT INTO schedules (Titre, Description, Date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $titre, $description, $date);
    $stmt->execute();
    $stmt->close();
}

// Récupération des horaires existants
$result = $conn->query("SELECT * FROM schedules");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des horaires</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Gestion des horaires</h2>
        <div class="card mt-3">
            <div class="card-header">
                Ajouter un nouvel horaire
            </div>
            <div class="card-body">
                <form method="post" action="manage_schedules.php">
                    <div class="form-group">
                        <label for="titre">Titre de l'horaire</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                Liste des horaires
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['Titre']; ?></td>
                                <td><?php echo $row['Description']; ?></td>
                                <td><?php echo $row['Date']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>