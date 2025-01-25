<?php
include 'session_check.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, nom, espece, age, poids, nourriture, last_meal, food_quantity FROM animals";
$result = $conn->query($sql);

$animals = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $animals[] = $row;
    }
}

$conn->close();

echo json_encode($animals);
?>