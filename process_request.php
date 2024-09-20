<?php

include 'session_check.php';

$servername = "mysql-zooarcadiaa.alwaysdata.net";
$username = "376865";
$password = "Marley2809";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    if (isset($_POST['action']) && $_POST['action'] === 'reject' && isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM registration_requests WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Success";
        } else {
            echo "Error: No rows affected. ID may not exist.";
        }

        $stmt->close();
    } else {
        echo "Error: Invalid request. Action or ID missing.";
    }
} else {
    echo "Error: Invalid request method.";
}

$conn->close();
?>