<?php

$servername = "mysql-zooarcadiaa.alwaysdata.net";
$username = "376865";
$password = "Marley2809";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];

$sql = "INSERT INTO registration_requests (name, email, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $role);

if ($stmt->execute()) {
    echo "<div class='alert alert-success'>Inscription réussie ! Vous serez redirigé vers la page de connexion dans 5 secondes.</div>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.html';
                    }, 5000);
                </script>";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>