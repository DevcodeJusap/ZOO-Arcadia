<?php

include 'session_check.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "MV_12CycB/B7wt4v", "zooarcadia");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$result = $conn->query("SHOW COLUMNS FROM animals LIKE 'unité_nourriture'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE animals ADD COLUMN unité_nourriture VARCHAR(255) NOT NULL");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_name = $_POST['animal_name'] ?? '';
    $habitat_name = $_POST['habitat_name'] ?? '';
    $species = $_POST['species'] ?? '';
    $age = $_POST['age'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $food = $_POST['food'] ?? '';
    $last_meal = $_POST['last_meal'] ?? '';
    $food_quantity = $_POST['food_quantity'] ?? '';
    $unité_nourriture = $_POST['unité_nourriture'] ?? '';
    $health_comment = $_POST['health_comment'] ?? '';
    $private_comment = $_POST['private_comment'] ?? '';

    if (!empty($animal_name) && !empty($habitat_name) && !empty($species) && !empty($age) && !empty($weight) && !empty($food) && !empty($last_meal) && !empty($food_quantity) && !empty($unité_nourriture)) {
        $sql = "INSERT INTO animals (animal_name, habitat_name, species, age, weight, food, last_meal, food_quantity, unité_nourriture, health_comment, private_comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }
        $stmt->bind_param("sssssssssss", $animal_name, $habitat_name, $species, $age, $weight, $food, $last_meal, $food_quantity, $unité_nourriture, $health_comment, $private_comment);

        if ($stmt->execute()) {
            echo "Nouvel enregistrement créé avec succès";
        } else {
            echo "Erreur : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Tous les champs sont requis.";
    }
}

$sql = "SELECT * FROM animals";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des Animaux</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .small-column {
                width: 80px;
            }
        </style>
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
            <h2>Ajouter un nouvel animal</h2>
            <form action="manage_animals.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="animal_name">Nom de l'animal</label>
                            <input type="text" class="form-control" id="animal_name" name="animal_name" required>
                        </div>
                        <div class="form-group">
                            <label for="habitat_name">Habitat</label>
                            <select class="form-control" id="habitat_name" name="habitat_name" required>
                                <option value="La Savane">La Savane</option>
                                <option value="Les Marais">Les Marais</option>
                                <option value="La Jungle">La Jungle</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="species">Espèce</label>
                            <input type="text" class="form-control" id="species" name="species" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Âge</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="age" name="age" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">ans</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="health_comment">Commentaire santé</label>
                        <textarea class="form-control" id="health_comment" name="health_comment" rows="3"></textarea>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight">Poids</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="weight" name="weight" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="food">Nourriture</label>
                            <input type="text" class="form-control" id="food" name="food" required>
                        </div>
                        <div class="form-group">
                            <label for="last_meal">Dernier repas</label>
                            <input type="datetime-local" class="form-control" id="last_meal" name="last_meal" required>
                        </div>
                        <div class="form-group">
                            <label for="food_quantity">Quantité de nourriture</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="food_quantity" name="food_quantity" required>
                                <select class="form-control" id="unité_nourriture" name="unité_nourriture" required>
                                    <option value="grammes">grammes</option>
                                    <option value="kg">kg</option>
                                    <option value="Litre">Litre</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="private_comment">Commentaire privé</label>
                        <textarea class="form-control" id="private_comment" name="private_comment" rows="3"></textarea>
                    </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

        <h1>Liste des Animaux</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="small-column">Nom</th>
                    <th>Espèce</th>
                    <th class="small-column">Âge</th>
                    <th>Poids</th>
                    <th>Nourriture</th>
                    <th>Dernier Repas</th>
                    <th class="small-column">Qu</th>
                    <th>Unité</th>
                    <th>Commentaire Santé</th>
                    <th>Commentaire Privé</th>
                    <th class="small-column">Modif</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "MV_12CycB/B7wt4v", "zooarcadia");

                if ($conn->connect_error) {
                    die("Échec de la connexion : " . $conn->connect_error);
                }

                $sql = "SELECT * FROM animals";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['animal_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['species']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . " ans</td>";
                        echo "<td>" . htmlspecialchars($row['weight']) . " kg</td>";
                        echo "<td>" . htmlspecialchars($row['food']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_meal']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['food_quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['unité_nourriture']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['health_comment']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['private_comment']) . "</td>";
                        echo "<td><a href='edit_animal.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Modifier</a> ";
                        echo "<a href='delete_animal.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Supprimer</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>Aucun animal trouvé.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>