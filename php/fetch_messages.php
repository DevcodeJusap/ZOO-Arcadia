<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_messages = "SELECT id, name, email, message FROM messages ORDER BY created_at DESC";
$result_messages = $conn->query($sql_messages);

if (!$result_messages) {
    die("Erreur dans la requête SQL pour les messages : " . $conn->error);
}

if ($result_messages->num_rows > 0) {
    while($row_messages = $result_messages->fetch_assoc()) {
        echo "<div class='message'>";
        echo "<h3>" . htmlspecialchars($row_messages["name"]) . "<h3>";
        echo "<h4>" . htmlspecialchars($row_messages["email"]) . "</h4>";
        echo "<p>" . htmlspecialchars($row_messages["message"]) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>Aucun message trouvé</p>";
}
?>