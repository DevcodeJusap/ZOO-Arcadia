<?php
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "MV_12CycB/B7wt4v";
$dbname = "zooarcadia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>