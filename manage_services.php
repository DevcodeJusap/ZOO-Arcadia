<?php
include 'navbar.php';
include 'session_check.php';

$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");
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
        <link rel="stylesheet" href="css/dashboard.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>

        </style>
    </head>
    <body>
        <div class="container-flex">
            <div class="nav-vertical">
                <?php include 'nav-vertical.php'; ?>
            </div>
            <div class="content">
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
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["id"] . "</td>";
                                            echo "<td>" . $row["service_name"] . "</td>";
                                            echo "<td><a href='edit_service.php?id=" . $row["id"] . "' class='btn btn-warning'>Modifier</a> <a href='delete_service.php?id=" . $row["id"] . "' class='btn btn-danger'>Supprimer</a></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>Aucun service trouvé</td></tr>";
                                    }
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>