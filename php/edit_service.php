<?php
require_once 'db_connection.php';

$conn = OpenCon();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("SELECT * FROM services WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    $stmt->close();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = $conn->prepare("UPDATE services SET service_name=? WHERE id=?");
        $stmt->bind_param("si", $service_name, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_services.php");
        exit();
    }
} else {
    header("Location: manage_services.php");
    exit();
}

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
    <form action="edit_service.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="service_name">Nom du service</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo $service['service_name']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>