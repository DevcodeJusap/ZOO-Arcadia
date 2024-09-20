<?php
include 'session_check.php';

$conn = new mysqli("localhost", "root", "MV_12CycB/B7wt4v", "zooarcadia");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$tableExists = $conn->query("SHOW TABLES LIKE 'services'");
if ($tableExists->num_rows == 0) {
    $createTableSql = "
    CREATE TABLE services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        service_name VARCHAR(255) NOT NULL
    )";
    if ($conn->query($createTableSql) === TRUE) {
        echo "Table 'services' créée avec succès.";
    } else {
        echo "Erreur lors de la création de la table 'services' : " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $conn->prepare("INSERT INTO services (service_name) VALUES (?)");
    $stmt->bind_param("s", $service_name);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("SELECT * FROM services");

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des services</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <header>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarResponsive">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="admin_dashboard.php">Tableau de bord</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage_employe.php">Gérer les employés</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="manage_animals.php">Gérer les animaux</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Déconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

        <div class="container mt-5">
            <h2>Gestion des services</h2>
            <div class="card mt-3">
                <div class="card-header">
                    Ajouter un nouveau service
                </div>
                <div class="card-body">
                    <form action="manage_services.php" method="POST">
                        <div class="form-group">
                            <label for="service_name">Nom du service</label>
                            <input type="text" class="form-control" id="service_name" name="service_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Liste des services
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du service</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['service_name'] . "</td>";
                                    echo "<td>
                                            <a href='edit_service.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Modifier</a>
                                            <a href='delete_service.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Supprimer</a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Aucun service trouvé</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>