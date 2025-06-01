<?php
include 'session_check.php';
include 'db_connection.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM habitats WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}
$conn->close();
?>