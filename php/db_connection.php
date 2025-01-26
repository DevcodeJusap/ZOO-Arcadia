<?php
function OpenCon() {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "zooarcadiaa_zoo";

    // Crée une connexion
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Vérifie la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function CloseCon($conn) {
    $conn->close();
}
?>