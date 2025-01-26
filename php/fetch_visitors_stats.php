<?php
// fetch_visitors_stats.php
include 'db_connection.php';

// Vérifiez la structure de la table 'visitors'
$table_check_query = "DESCRIBE visitors";
$table_check_result = $conn->query($table_check_query);

if (!$table_check_result) {
    die("Erreur lors de la vérification de la table visitors : " . $conn->error);
}

// Affichez la structure de la table pour le débogage
while ($row = $table_check_result->fetch_assoc()) {
    echo "Champ : " . $row['Field'] . " - Type : " . $row['Type'] . "<br>";
}

// Insérez les données des visiteurs
$visit_date = date('Y-m-d H:i:s');
$ip_address = $_SERVER['REMOTE_ADDR'];

$insert_query = "INSERT INTO visitors (visit_date, ip_address) VALUES ('$visit_date', '$ip_address')";
if (!$conn->query($insert_query)) {
    die("Erreur lors de l'insertion des données des visiteurs : " . $conn->error);
}

// Mettez à jour la requête SQL avec les noms de colonnes corrects
$sql_visitors = "SELECT visit_date, ip_address FROM visitors";
$result_visitors = $conn->query($sql_visitors);

if (!$result_visitors) {
    die("Erreur dans la requête SQL pour les statistiques des visiteurs : " . $conn->error);
}

// Traitement des résultats
while($row = $result_visitors->fetch_assoc()) {
    echo "Date de visite : " . htmlspecialchars($row['visit_date']) . "<br>";
    echo "Adresse IP : " . htmlspecialchars($row['ip_address']) . "<br>";
}

$conn->close();
?>