<?php
require_once 'db_connection.php';
$conn = OpenCon();

$id = $_SERVER["REQUEST_METHOD"] == "POST"
    ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT)
    : filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id) {
    die("Erreur : ID manquant ou invalide");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Debug
    $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $paragraph = filter_input(INPUT_POST, 'paragraph', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (!$id) {
        die("Erreur : ID manquant ou invalide");
    }

    $stmt = $conn->prepare("UPDATE services SET service_name=?, paragraph=? WHERE id=?");
    $stmt->bind_param("ssi", $service_name, $paragraph, $id);
    $stmt->execute();

    if ($stmt->error) {
        die("Erreur SQL : " . $stmt->error);
    }

    $stmt->close();

    // Ajout de nouvelles images
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
                    $stmt_img->bind_param("iss", $id, $image_url, $alt_text);
                    $stmt_img->execute();
                    $stmt_img->close();
                }
            }
        }
    }

    // header("Location: manage_services.php"); // Commente pour voir les erreurs
    exit();
}

// Récupération des infos pour affichage du formulaire
$stmt = $conn->prepare("SELECT * FROM services WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
$stmt->close();

CloseCon($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un service</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modifier un service</h2>
    <form action="edit_service.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="service_name">Nom du service</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="paragraph">Paragraphe</label>
            <textarea class="form-control" id="paragraph" name="paragraph" required><?php echo htmlspecialchars($service['paragraph']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="service_images">Ajouter des images</label>
            <input type="file" class="form-control" id="service_images" name="service_images[]" accept="image/*" multiple>
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>