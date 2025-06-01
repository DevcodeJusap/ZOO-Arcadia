<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);
$service_id = intval($_GET['service_id']);
$res = $conn->query("SELECT id, image_url FROM service_images WHERE service_id = $service_id");
while($img = $res->fetch_assoc()) {
    echo "<div style='display:inline-block;margin:3px;position:relative;'>";
    echo "<img src='/" . htmlspecialchars($img['image_url']) . "' style='height:60px;border-radius:5px;'>";
    echo "<a href='delete_service_image.php?id=" . $img['id'] . "' onclick=\"return confirm('Supprimer cette image ?');\" style='position:absolute;top:0;right:0;color:red;font-weight:bold;background:white;border-radius:50%;padding:2px 6px;text-decoration:none;'>×</a>";
    echo "</div>";
}
$conn->close();
?>