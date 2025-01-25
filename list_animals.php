<?php
include 'session_check.php';
?>
<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Liste des animaux</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Retour au tableau de bord</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container mt-5">
            <h2>Liste des animaux</h2>
            <div class="card mt-3">
                <div class="card-header">
                    Liste des animaux
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>Nom</th>
                            <th>Habitat</th>
                            <th>Espèce</th>
                            <th>Âge</th>
                            <th>Poids</th>
                            <th>Nourriture</th>
                            <th>Commentaire santé</th>
                            <th>Commentaire privé</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");                            if ($conn->connect_error) {
                                die("Échec de la connexion : " . $conn->connect_error);
                            }
                            $result = $conn->query("SELECT * FROM animals");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['animal_name'] . "</td>";
                                    echo "<td>" . $row['habitat_name'] . "</td>";
                                    echo "<td>" . $row['species'] . "</td>";
                                    echo "<td>" . $row['age'] . "</td>";
                                    echo "<td>" . $row['weight'] . "</td>";
                                    echo "<td>" . $row['food'] . "</td>";
                                    echo "<td>" . $row['dernier_repas'] . "</td>";
                                    echo "<td>" . $row['quantité_de_nourriture'] . "</td>";
                                    echo "<td>" . $row['health_comment'] . "</td>";
                                    echo "<td>" . $row['private_comment'] . "</td>";
                                    echo "<td>
                                            <a href='edit_animal.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Modifier</a>
                                            <a href='delete_animal.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Supprimer</a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Aucun animal trouvé</td></tr>";
                            }
                            $conn->close();
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