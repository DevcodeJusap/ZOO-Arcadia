<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $habitatName = $conn->real_escape_string($_POST['habitatName']);
    $habitatDescription = $conn->real_escape_string($_POST['habitatDescription']);

    $sql = "INSERT INTO habitats (name, description) VALUES ('$habitatName', '$habitatDescription')";

    if ($conn->query($sql) === TRUE) {
        echo "New habitat created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>