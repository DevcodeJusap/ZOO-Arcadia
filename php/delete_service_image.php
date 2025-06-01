<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);
$id = intval($_GET['id']);
$conn->query("DELETE FROM service_images WHERE id=$id");
$conn->close();
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>