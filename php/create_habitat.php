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
    $image_url = '';

    if (isset($_FILES['habitatImage']) && $_FILES['habitatImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../image/habitats/';
        $fileName = basename($_FILES['habitatImage']['name']);
        $fileName = str_replace(' ', '_', $fileName); // Nettoie le nom
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['habitatImage']['tmp_name'], $targetFile)) {
            $image_url = 'image/habitats/' . $fileName;
        }
    }

    // Insère dans la base
    $stmt = $conn->prepare("INSERT INTO habitats (habitat_name, description, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $habitatName, $habitatDescription, $image_url);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>