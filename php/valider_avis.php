<?php
session_start();
require_once 'db_connection.php';
$conn = OpenCon();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action === 'valider') {
        $stmt = $conn->prepare("UPDATE avis SET status='valide' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'refuser') {
        $stmt = $conn->prepare("UPDATE avis SET status='refuse' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header('Location: admin_dashboard.php');
exit();
?>