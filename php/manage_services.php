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
    $paragraph = filter_input(INPUT_POST, 'paragraph', FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $conn->prepare("INSERT INTO services (service_name, paragraph) VALUES (?, ?)");
    $stmt->bind_param("ss", $service_name, $paragraph);
    $stmt->execute();
    $service_id = $stmt->insert_id;
    $stmt->close();

    // Gestion des images
    if (!empty($_FILES['service_images']['name'][0])) {
        $uploadDir = '../image/services/';
        foreach ($_FILES['service_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['service_images']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['service_images']['name'][$key]);
                $fileName = str_replace(' ', '_', $fileName);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($tmp_name, $targetFile)) {
                    $image_url = 'image/services/' . $fileName;
                    $alt_text = $service_name . ' photo';
                    $stmt_img = $conn->prepare("INSERT INTO service_images (service_id, image_url, alt_text) VALUES (?, ?, ?)");
                    $stmt_img->bind_param("iss", $service_id, $image_url, $alt_text);
                    $stmt_img->execute();
                    $stmt_img->close();
                }
            }
        }
    }
}

$result = $conn->query("SELECT * FROM services");


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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="/php/logout.php" class="btn btn-danger">Déconnexion</a>
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

            <div class="content">
                <div class="container mt-5">
                    <h2>Gestion des services</h2>
                    <div class="card mt-3">
                        <div class="card-header">
                            Ajouter un nouveau service
                        </div>
                        <div class="card-body">
                            <form action="manage_services.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="service_name">Nom du service</label>
                                    <input type="text" class="form-control" id="service_name" name="service_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="paragraph">Paragraphe</label>
                                    <textarea class="form-control" id="paragraph" name="paragraph" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="service_images">Photos (plusieurs possibles)</label>
                                    <input type="file" class="form-control" id="service_images" name="service_images[]" accept="image/*" multiple>
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
                                        <th style="width:120px;">Nom du service</th>
                                        <th>Paragraphe</th>
                                        <th>Images</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row["id"] . "</strong></td>";
        echo "<td style='width:120px;vertical-align:middle;'><span style='font-weight:bold;font-size:1.1em;'>" . htmlspecialchars($row["service_name"]) . "</span></td>";
        echo "<td><div style='max-width:350px;white-space:pre-line;'>" . nl2br(htmlspecialchars($row["paragraph"])) . "</div></td>";
        echo "<td style='text-align:center;'>";
        // Images en carrousel Bootstrap si plusieurs images
        $service_id = $row["id"];
        $img_result = $conn->query("SELECT image_url FROM service_images WHERE service_id = $service_id");
        $imgs = [];
        while($img = $img_result->fetch_assoc()) {
            $imgs[] = $img['image_url'];
        }
        if (count($imgs) > 0) {
            $carouselId = "carouselService" . $service_id;
            echo "<div id='$carouselId' class='carousel slide' data-ride='carousel' style='width:300px;'>";
            echo "<div class='carousel-inner'>";
            foreach ($imgs as $k => $img_url) {
                $active = $k === 0 ? "active" : "";
                echo "<div class='carousel-item $active'>";
                echo "<img src='/" . htmlspecialchars($img_url) . "' alt='' class='d-block w-100' style='height:320px;object-fit:cover;border-radius:6px;'>";
                echo "</div>";
            }
            echo "</div>";
            if (count($imgs) > 1) {
                echo "<a class='carousel-control-prev' href='#$carouselId' role='button' data-slide='prev' style='width:20px;'>
                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                        <span class='sr-only'>Précédent</span>
                      </a>
                      <a class='carousel-control-next' href='#$carouselId' role='button' data-slide='next' style='width:20px;'>
                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                        <span class='sr-only'>Suivant</span>
                      </a>";
            }
            echo "</div>";
        } else {
            echo "<span class='text-muted'>Aucune image</span>";
        }
        echo "</td>";
        echo "<td>
                <a href='#' 
        class='btn btn-warning btn-sm mb-1 edit-service-btn'
        data-id='" . $row["id"] . "'
        data-name='" . htmlspecialchars($row["service_name"], ENT_QUOTES) . "'
        data-paragraph='" . htmlspecialchars($row["paragraph"], ENT_QUOTES) . "'
        >Modifier</a>
                <a href='delete_service.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm mb-1' onclick=\"return confirm('Supprimer ce service ?');\">Supprimer</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Aucun service trouvé</td></tr>";
}
?>
</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de modification de service -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editServiceForm" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editServiceModalLabel">Modifier le service</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_service_id" name="edit_service_id">
          <div class="form-group">
            <label for="edit_service_name">Nom du service</label>
            <input type="text" class="form-control" id="edit_service_name" name="edit_service_name" required>
          </div>
          <div class="form-group">
            <label for="edit_paragraph">Paragraphe</label>
            <textarea class="form-control" id="edit_paragraph" name="edit_paragraph" required></textarea>
          </div>
          <div class="form-group">
            <label>Images actuelles</label>
            <div id="edit_service_images"></div>
          </div>
          <div class="form-group">
            <label for="edit_service_images_new">Ajouter de nouvelles images</label>
            <input type="file" class="form-control" id="edit_service_images_new" name="edit_service_images_new[]" accept="image/*" multiple>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="javascript/dashboard.js"></script>
    <script>
$(document).on('click', '.edit-service-btn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var name = $(this).data('name');
    var paragraph = $(this).data('paragraph');
    $('#edit_service_id').val(id);
    $('#edit_service_name').val(name);
    $('#edit_paragraph').val(paragraph);

    // Charge les images existantes via AJAX
    $.get('get_service_images.php', {service_id: id}, function(data) {
        $('#edit_service_images').html(data);
    });

    $('#editServiceModal').modal('show');
});

// Soumission du formulaire de modification
$('#editServiceForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: 'edit_service.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            location.reload();
        }
    });
});
</script>
    </body>
</html>

