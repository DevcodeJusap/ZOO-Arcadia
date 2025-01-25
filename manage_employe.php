<?php
include 'navbar.php';
include 'nav-vertical.php';
include 'session_check.php';
include 'db_config.php';
$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $habitat = filter_input(INPUT_POST, 'habitat', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($name && $username && $password && $position && $role && $email) {
        $stmt = $conn->prepare("INSERT INTO employe (name, username, password, position, role, habitat,email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $username, $password, $position, $role, $habitat,$email);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

$result = $conn->query("SELECT id, name, username, position, role, habitat,email FROM employe");
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des employés</title>
        <link rel="stylesheet" href="css/dashboard.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        

        <div class="container mt-5">
            <h2>Gestion des employés</h2>
            <div class="card mt-3">
                <div class="card-header">
                    Ajouter un nouvel employé
                </div>
                <div class="card-body">
                    <form action="manage_employe.php" method="POST">
                        <div class="form-group">
                            <label for="name">Nom de l'employé</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Poste</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="form-group">
                            <label for="position">email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Rôle</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="veterinaire">Vétérinaire</option>
                                <option value="employe">Employé</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="habitat">Habitat (pour les employés)</label>
                            <select class="form-control" id="habitat" name="habitat">
                                <option value="">Aucun</option>
                                <option value="savane">Savane</option>
                                <option value="jungle">Jungle</option>
                                <option value="marais">Marais</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Liste des employés
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom de l'employé</th>
                                <th>Nom d'utilisateur</th>
                                <th>Poste</th>
                                <th>Rôle</th>
                                <th>Habitat</th>
                                <th>Actions</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['position'] . "</td>";
                                echo "<td>" . $row['role'] . "</td>";
                                echo "<td>" . $row['habitat'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>
                                        <a href='edit_employe.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Modifier</a>
                                        <a href='delete_employe.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet employé ?\");'>Supprimer</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Aucun employé trouvé</td></tr>";
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