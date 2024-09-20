<?php
session_start();
include 'session_check.php';
$servername = "mysql-zooarcadiaa.alwaysdata.net";
$username = "376865";
$password = "Marley2809";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$sql_animaux = "SELECT * FROM animals";
$result_animaux = $conn->query($sql_animaux);

$sql_habitats = "SELECT * FROM habitats";
$result_habitats = $conn->query($sql_habitats);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Tableau de Bord Vétérinaire</title>
    </head>
    <body>
        <h1>Bienvenue, Vétérinaire!</h1>

        <h2>Liste des Animaux</h2>
        <table border="1">
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
            </tr>
            <?php
            if ($result_animaux->num_rows > 0) {
                while($row = $result_animaux->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['animal_name']}</td>
                            <td>{$row['habitat_name']}</td>
                            <td>{$row['species']}</td>
                            <td>{$row['age']}</td>
                            <td>{$row['weight']}</td>
                            <td>{$row['food']}</td>
                            <td>{$row['health comment']}</td>
                            <td>{$row['private comment']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Aucun animal trouvé</td></tr>";
            }
            ?>
        </table>

        <h2>Liste des Habitats</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Type d'habitat</th>
            </tr>
            <?php
            if ($result_habitats->num_rows > 0) {
                while($row = $result_habitats->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['habitat_name']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Aucun habitat trouvé</td></tr>";
            }
            ?>
        </table>

        <?php
        $conn->close();
        ?>
    </body>
</html>