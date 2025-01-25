<?php
include 'session_check.php';
$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");
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

        $stmt = $conn->prepare("UPDATE habitats SET habitat_name=? WHERE id=?");
        $stmt->bind_param("si", $habitat_name, $id);
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
    <form action="edit_habitat.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="habitat_name">Nom de l'habitat</label>
            <input type="text" class="form-control" id="habitat_name" name="habitat_name" value="<?php echo $habitat['habitat_name']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>