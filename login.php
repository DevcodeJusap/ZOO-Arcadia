<?php
session_start();
$conn = new mysqli("localhost", "root", "MV_12CycB/B7wt4v", "zooarcadia");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT * FROM employe WHERE username=? AND password=?");
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['habitat'] = $user['habitat'];

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($user['role'] === 'veterinaire') {
                header("Location: veto_dashboard.php");
                exit();
            } elseif ($user['role'] === 'employe') {
                header("Location: employe_dashboard.php");
                exit();
            } else {
                echo "Rôle inconnu.";
            }
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>