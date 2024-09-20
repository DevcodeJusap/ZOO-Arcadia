<?php
session_start();
include 'session_check.php';
$servername = "mysql-zooarcadiaa.alwaysdata.net";
$username = "376865";
$password = "Marley2809";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql = "SELECT animals.id, animals.animal_name, COALESCE(animal_likes.likes, 0) AS likes 
        FROM animals 
        LEFT JOIN animal_likes ON animals.id = animal_likes.id";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">

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

    <div class="dashboard">
            <div class="column column-1">
                <h2>Bienvenue sur votre tableau de bord</h2>
                    <p>Vous pouvez maintenant accéder à toutes les fonctionnalités réservées à nos utilisateurs inscrits.</p>
            
                    <div id="employees" class="card">
                        <div class="card-header">
                            Gestion des employés
                        </div>
                        <div class="card-body">
                            <p>Ajouter, modifier ou supprimer des employés et gérer leurs autorisations.</p>
                            <a href="manage_employe.php" class="btn btn-primary">Gérer les employés</a>
                        </div>
                    </div> 
                    <br><br>
            
                    <div id="services" class="card">
                        <div class="card-header">
                            Gestion des services
                        </div>
                        <div class="card-body">
                            <p>Ajouter, modifier ou supprimer des services.</p>
                            <a href="manage_services.php" class="btn btn-primary">Gérer les services</a>
                        </div>
                    </div>
                    <br><br>
                        
                    <div id="weather" class="card">
                        <div class="card-header">
                            Météo en temps réel sur le zoo
                        </div>
                        <div class="card-body">
                            <img id="weather-icon" src="" alt="Icône météo" style="width: 50px; height: 50px;">
                            <p id="weather-description">Chargement...</p>
                            <p id="temperature"></p>
                            <p id="humidity"></p>
                        </div>
                    </div>
                    <br><br>
            
                    <div id="habitats" class="card">
                        <div class="card-header">
                            Gestion des habitats
                        </div>
                        <div class="card-body">
                            <p>Ajouter, modifier ou supprimer des habitats.</p>
                            <a href="manage_habitats.php" class="btn btn-primary">Gérer les habitats</a>
                        </div>
                    </div>
                    <br><br>
                    
                    <div id="animals" class="card">
                        <div class="card-header">
                            Gestion des animaux
                        </div>
                        <div class="card-body">
                            <p>Ajouter, modifier ou supprimer des animaux.</p>
                            <a href="manage_animals.php" class="btn btn-primary">Gérer les animaux</a>
                        </div>
                    </div>
            </div>
        </div>

        <div class="column column-2">
                    
                    
            <div class="main-content p-3 bg-white shadow-sm">
            <h2>Chat avec l'équipe.</h2>
                <div class="chat-container p-3 bg-light rounded shadow-sm">
                
                    <div class="chat-message sent d-flex align-items-start mb-3">
                        <div class="avatar mr-2"><i class="fas fa-user icon-bounce"></i></div>
                        <div class="chat-message sent">
                            <div class="message-content">
                                <p>Message envoyé</p>
                            </div>
                        </div>
                        </div>
                        <div class="chat-message received d-flex align-items-start mb-3">
                            <div class="avatar mr-2"><i class="fas fa-user icon-fade-in"></i></div>
                            <div class="chat-message received">
                                <div class="message-content">
                                    <p>Message reçu</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <form id="chat-form" class="chat-form d-flex">
                            <input type="text" id="chat-input" class="chat-input form-control mr-2" placeholder="Écrire un message...">
                            <button type="submit" class="chat-button">Envoyer</button>
                        </form>
                    </div>
                
                <div class="main-content p-3 bg-white shadow-sm mt-4">
                <h2>Demandes d'inscription</h2>
                <?php
                    include 'db_config.php';

                    if ($conn->connect_error) {
                        die("Échec de la connexion : " . $conn->connect_error);
                    }

                    $requests = $conn->query("SELECT * FROM registration_requests WHERE status = 'pending'");

                    if ($requests->num_rows > 0) {
                        echo "<table class='table'>";
                        echo "<thead><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Action</th></tr></thead><tbody>";
                        while ($row = $requests->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                            echo "<td>
                                    <form action='process_request.php' method='POST' class='d-inline'>
                                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                                        <button type='submit' name='action' value='approve' class='btn btn-success btn-sm'>Approuver</button>
                                        <button type='submit' name='action' value='reject' class='btn btn-danger btn-sm'>Rejeter</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<p>Aucune demande d'inscription en attente.</p>";
                    }
                ?>
                </div>
            </div>
        </div>

        <div class="column column-3">
            <div class="main-content">
                <div class="container">
                    <h2>Nombre de Likes</h2>
                        <p>Nombre total de likes:
                            
                        <?php
            $conn = new mysqli("mysql-zooarcadiaa.alwaysdata.net", "376865", "Marley2809", "zooarcadiaa_zoo");

            if ($conn->connect_error) {
                die("Échec de la connexion : " . $conn->connect_error);
            }

            $result = $conn->query("SELECT animal_name, likes FROM animal_likes ORDER BY likes DESC");

            if ($result === false) {
                die("Erreur de requête : " . $conn->error);
            }

            if ($result->num_rows > 0) {
                echo '<table class="likes-table">
                        <tr> 
                            <th>Animal</th>
                            <th>Nb de likes</th>
                        </tr>';

                $counter = 0;
                while ($row = $result->fetch_assoc()) {
                    $class = '';
                    if ($counter == 0) {
                        $class = 'multicolor-1';
                    } elseif ($counter == 1) {
                        $class = 'multicolor-2';
                    } elseif ($counter == 2) {
                        $class = 'multicolor-3';
                    }

                    echo "<tr class='$class'>
                            <td class='$class'>" . htmlspecialchars($row['animal_name']) . "</td>
                            <td class='$class'>" . htmlspecialchars($row['likes']) . "</td>
                        </tr>";
                    $counter++;
                }
                echo "</table>";
            } else {
                echo "Aucun like trouvé.";
            }
            ?>


        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="javascript/dashboard.js"></script>
</body>
</html>