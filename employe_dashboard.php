<?php
session_start();

include 'session_check.php';
$conn = new mysqli("mysql-zooarcadiaa.alwaysdata.net", "376865", "Marley2809", "zooarcadiaa_zoo");
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

include 'db_connection.php';

$sql = "SELECT * FROM avis WHERE status = 'en attente'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Employé - Zoo-Arcadia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Bienvenue, Employé de l'habitat <?php echo $_SESSION['habitat']; ?>!</h1>
    </header>
    <main class="container mt-4">
        <section>
            <h2 class="mb-4">Avis en attente de validation</h2>
            <?php
            if ($result->num_rows > 0) {
                echo '<div class="row">';
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-6 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['nom']) . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row['note']) . ' étoiles</h6>';
                    echo '<p class="card-text">' . htmlspecialchars($row['avis']) . '</p>';
                    echo '<form action="valider_avis.php" method="post">';
                    echo '<input type="hidden" name="avis_id" value="' . htmlspecialchars($row['id']) . '">';
                    echo '<button type="submit" name="action" value="valider" class="btn btn-success mr-2">Valider</button>';
                    echo '<button type="submit" name="action" value="rejeter" class="btn btn-danger">Rejeter</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>Aucun avis en attente de validation.</p>';
            }
            ?>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>