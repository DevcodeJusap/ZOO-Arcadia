<?php
$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

$sql = "SELECT titre, nom, avis, note FROM avis WHERE status = 'validé'";
$result = $conn->query($sql);

$avisData = array();
while($row = $result->fetch_assoc()) {
    $avisData[] = $row;
}

header('Content-Type: application/json');
echo json_encode($avisData);

$conn->close();
?>