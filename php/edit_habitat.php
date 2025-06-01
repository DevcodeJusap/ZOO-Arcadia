<?php
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("SELECT * FROM habitats WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $habitat = $result->fetch_assoc();
    $stmt->close();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $habitat_name = filter_input(INPUT_POST, 'habitat_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = $conn->real_escape_string($_POST['habitatDescription']);
        $image_url = '';

        if (isset($_FILES['habitatImage']) && $_FILES['habitatImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../image/habitats/';
            $fileName = basename($_FILES['habitatImage']['name']);
            $fileName = str_replace(' ', '_', $fileName);
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['habitatImage']['tmp_name'], $targetFile)) {
                $image_url = 'image/habitats/' . $fileName;
            }
        }

        if ($image_url) {
            $stmt = $conn->prepare("UPDATE habitats SET habitat_name=?, description=?, image_url=? WHERE id=?");
            $stmt->bind_param("sssi", $habitat_name, $description, $image_url, $id);
        } else {
            $stmt = $conn->prepare("UPDATE habitats SET habitat_name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $habitat_name, $description, $id);
        }
        $stmt->execute();
        $stmt->close();

        header("Location: manage_habitats.php");
        exit();
    }
} else {
    header("Location: manage_habitats.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un habitat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modifier un habitat</h2>
    <form action="edit_habitat.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="habitat_name">Nom de l'habitat</label>
            <input type="text" class="form-control" id="habitat_name" name="habitat_name" value="<?php echo $habitat['habitat_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="habitatDescription">Description de l'habitat</label>
            <textarea class="form-control" id="habitatDescription" name="habitatDescription" required><?php echo $habitat['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="habitatImage">Image de l'habitat</label>
            <input type="file" class="form-control-file" id="habitatImage" name="habitatImage">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>