<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['username']) || empty($_SESSION['role'])) {
    header('Location: /login.html');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Redirection si l'utilisateur n'est pas vétérinaire
if ($_SESSION['role'] !== 'veterinaire') {
    header('Location: /login.html');
    exit();
}

// Génération du token CSRF si inexistant
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Ajout d'un animal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_animal'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur de sécurité (CSRF)');
    }
    $animal_name = $_POST['new_animal_name'];
    $habitat_name = $_POST['new_habitat_name'];
    $species = $_POST['new_species'];
    $age = filter_var($_POST['new_age'], FILTER_VALIDATE_INT);
    if ($age === false) { die('Âge invalide'); }
    $weight = $_POST['new_weight'];
    $food = $_POST['new_food'];
    $health_comment = $_POST['new_health_comment'];
    $private_comment = $_POST['new_private_comment'];
    $image_url = $_POST['new_image_url'];

    $stmt = $conn->prepare("INSERT INTO animals (animal_name, habitat_name, species, age, weight, food, health_comment, private_comment, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $animal_name, $habitat_name, $species, $age, $weight, $food, $health_comment, $private_comment, $image_url);
    $stmt->execute();
    $stmt->close();
    header("Location: vet_dashboard.php");
    exit();
}

// Modification d'un animal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['animal_id'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur de sécurité (CSRF)');
    }
    $id = intval($_POST['animal_id']);
    $weight = $_POST['weight'];
    $food = $_POST['food'];
    $health_comment = $_POST['health_comment'];
    $private_comment = $_POST['private_comment'];

    $stmt = $conn->prepare("UPDATE animals SET weight=?, food=?, health_comment=?, private_comment=? WHERE id=?");
    $stmt->bind_param("ssssi", $weight, $food, $health_comment, $private_comment, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: vet_dashboard.php");
    exit();
}

// Vérifier les droits du vétérinaire
$habitat_veto = isset($_SESSION['habitat']) ? $_SESSION['habitat'] : '';
if ($habitat_veto && $habitat_veto !== 'Tous') {
    $stmt = $conn->prepare("SELECT * FROM animals WHERE habitat_name = ?");
    $stmt->bind_param("s", $habitat_veto);
    $stmt->execute();
    $result_animaux = $stmt->get_result();
} else {
    $sql_animaux = "SELECT * FROM animals";
    $result_animaux = $conn->query($sql_animaux);
}

// Liste des habitats
$sql_habitats = "SELECT * FROM habitats";
$result_habitats = $conn->query($sql_habitats);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Vétérinaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/dashboard.css">
    <script>
    // Force le rechargement si retour navigateur (sécurité)
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        window.location.reload();
    }
    </script>
</head>
<body>
    <!-- Navbar responsive -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="/image/presentation/logo.webp" width="40" height="40" class="d-inline-block align-top mr-2" alt="Logo">
        <span class="h5 mb-0">ZOO Arcadia - Espace Vétérinaire</span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarVet" aria-controls="navbarVet" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarVet">
        <span class="navbar-text text-white mx-auto">
          Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !
        </span>
        <div class="ml-auto">
          <a href="logout.php" class="btn btn-outline-light">Déconnexion</a>
        </div>
      </div>
    </nav>
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-12 col-lg-8 mb-4">
                <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addAnimalModal">
                    Ajouter un animal
                </button>
                <h2>Liste des animaux</h2>
                <div class="info-block">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped table-hover small-text">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Habitat</th>
                                    <th>Espèce</th>
                                    <th>Âge</th>
                                    <th>Poids</th>
                                    <th>Nourriture</th>
                                    <th>Commentaire santé</th>
                                    <th>Commentaire privé</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($result_animaux->num_rows > 0) {
                                while($row = $result_animaux->fetch_assoc()) {
                                    echo "<tr>
                                        <td>".htmlspecialchars($row['id'])."</td>
                                        <td>".htmlspecialchars($row['animal_name'])."</td>
                                        <td>".htmlspecialchars($row['habitat_name'])."</td>
                                        <td>".htmlspecialchars($row['species'])."</td>
                                        <td>".htmlspecialchars($row['age'])."</td>
                                        <td>".htmlspecialchars($row['weight'])."</td>
                                        <td>".htmlspecialchars($row['food'])."</td>
                                        <td>".htmlspecialchars($row['health_comment'])."</td>
                                        <td>".htmlspecialchars($row['private_comment'])."</td>
                                        <td>
                                            <button 
                                                class='btn btn-primary btn-sm' 
                                                data-toggle='modal' 
                                                data-target='#editModal".htmlspecialchars($row['id'])."'>
                                                Modifier
                                            </button>
                                        </td>
                                    </tr>";

                                    // Modal pour modification
                                    ?>
                                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <form method="post" action="vet_dashboard.php" class="w-100">
                                          <input type="hidden" name="animal_id" value="<?php echo $row['id']; ?>">
                                          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <div class="d-flex align-items-center w-100">
                                                <?php if (!empty($row['image_url'])): ?>
                                                  <img src="/<?php echo ltrim(htmlspecialchars($row['image_url']), '/'); ?>" alt="photo" style="height:150px; margin-right:10px; border-radius:5px; max-width:160px;">
                                                <?php endif; ?>
                                                <h5 class="modal-title flex-grow-1 text-center m-0" id="editModalLabel<?php echo $row['id']; ?>">
                                                  <?php echo htmlspecialchars($row['animal_name']); ?>
                                                </h5>
                                                <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Fermer">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                            </div>
                                            <div class="modal-body">
                                              <div class="form-group">
                                                <label>Poids</label>
                                                <input type="text" class="form-control" name="weight" value="<?php echo htmlspecialchars($row['weight']); ?>">
                                              </div>
                                              <div class="form-group">
                                                <label>Nourriture</label>
                                                <input type="text" class="form-control" name="food" value="<?php echo htmlspecialchars($row['food']); ?>">
                                              </div>
                                              <div class="form-group">
                                                <label>Commentaire santé</label>
                                                <textarea class="form-control" name="health_comment"><?php echo htmlspecialchars($row['health_comment']); ?></textarea>
                                              </div>
                                              <div class="form-group">
                                                <label>Commentaire privé</label>
                                                <textarea class="form-control" name="private_comment"><?php echo htmlspecialchars($row['private_comment']); ?></textarea>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                              <button type="submit" class="btn btn-success">Enregistrer</button>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='10'>Aucun animal trouvé</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="info-block mt-4">
                    <h3>Liste des habitats</h3>
                    <ul class="list-group">
                        <?php
                        if ($result_habitats->num_rows > 0) {
                            while($row = $result_habitats->fetch_assoc()) {
                                echo "<li class='list-group-item'><strong>".htmlspecialchars($row['habitat_name'])."</strong></li>";
                            }
                        } else {
                            echo "<li class='list-group-item'>Aucun habitat trouvé</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-4"></div>
        </div>
    </div>

    <!-- Modal d'ajout d'animal -->
    <div class="modal fade" id="addAnimalModal" tabindex="-1" role="dialog" aria-labelledby="addAnimalModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="post" action="vet_dashboard.php">
          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addAnimalModalLabel">Ajouter un animal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control" name="new_animal_name" required>
              </div>
              <div class="form-group">
                <label>Habitat</label>
                <input type="text" class="form-control" name="new_habitat_name" required>
              </div>
              <div class="form-group">
                <label>Espèce</label>
                <input type="text" class="form-control" name="new_species" required>
              </div>
              <div class="form-group">
                <label>Âge</label>
                <input type="number" class="form-control" name="new_age" required>
              </div>
              <div class="form-group">
                <label>Poids</label>
                <input type="text" class="form-control" name="new_weight" required>
              </div>
              <div class="form-group">
                <label>Nourriture</label>
                <input type="text" class="form-control" name="new_food" required>
              </div>
              <div class="form-group">
                <label>Commentaire santé</label>
                <textarea class="form-control" name="new_health_comment"></textarea>
              </div>
              <div class="form-group">
                <label>Commentaire privé</label>
                <textarea class="form-control" name="new_private_comment"></textarea>
              </div>
              <div class="form-group">
                <label>Image (URL ou chemin relatif)</label>
                <input type="text" class="form-control" name="new_image_url">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
              <button type="submit" class="btn btn-success" name="add_animal">Ajouter</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <?php $conn->close(); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>