<?php
include 'session_check.php';
session_start();

if (!isset($_SESSION['username'])) {
	header("Location: login.html");
	exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Page protégée</title>
</head>
<body>
	<h2>Bienvenue, <?php echo $_SESSION['username']; ?> !</h2>
	<p>Ceci est une page protégée.</p>
	<a href="logout.php">Se déconnecter</a>
</body>
</html>