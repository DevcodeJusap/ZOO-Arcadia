<?php
include 'session_check.php';
$conn = new mysqli("localhost", "root", "MV_12CycB/B7wt4v", "zooarcadia");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT name, username, position, role, habitat, email FROM employe WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $username, $position, $role, $habitat, $email);
    $stmt->fetch();
    $stmt->close();
} else {
    die("ID de l'employé non spécifié.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $habitat = filter_input(INPUT_POST, 'habitat', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($name && $username && $position && $role && $email) {
        $stmt = $conn->prepare("UPDATE employe SET name = ?, username = ?, position = ?, role = ?, habitat = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $name, $username, $position, $role, $habitat, $email, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: manage_employe.php?message=updated");
        exit();
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un employé</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Modifier un employé</h1>
        <form method="post">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="position">Poste</label>
                <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($position ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="employé" <?php echo ($role == 'employé') ? 'selected' : ''; ?>>Employé</option>
                    <option value="vétérinaire" <?php echo ($role == 'vétérinaire') ? 'selected' : ''; ?>>Vétérinaire</option>
                </select>
            </div>
            <div class="form-group">
                <label for="habitat">Habitat</label>
                <select class="form-control" id="habitat" name="habitat" required>
                    <option value="services" <?php echo ($habitat == 'services') ? 'selected' : ''; ?>>Services</option>
                    <option value="savane" <?php echo ($habitat == 'savane') ? 'selected' : ''; ?>>Savane</option>
                    <option value="marais" <?php echo ($habitat == 'marais') ? 'selected' : ''; ?>>Marais</option>
                    <option value="jungle" <?php echo ($habitat == 'jungle') ? 'selected' : ''; ?>>Jungle</option>
                    <option value="tous" <?php echo ($habitat == 'tous') ? 'selected' : ''; ?>>Tous</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            var role = this.value;
            var habitatSelect = document.getElementById('habitat');
            if (role === 'vétérinaire') {
                habitatSelect.value = 'tous';
                habitatSelect.disabled = true;
            } else {
                habitatSelect.disabled = false;
            }
        });

        window.onload = function() {
            var role = document.getElementById('role').value;
            var habitatSelect = document.getElementById('habitat');
            if (role === 'vétérinaire') {
                habitatSelect.value = 'tous';
                habitatSelect.disabled = true;
            }
        };
    </script>
</body>
</html>