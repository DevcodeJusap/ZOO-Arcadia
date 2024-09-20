<?php
include 'db_config.php';
include 'session_check.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->prepare("DELETE FROM employe WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: manage_employe.php?message=success");
    } else {
        header("Location: manage_employe.php?message=error");
    }

    $stmt->close();
} else {
    header("Location: manage_employe.php");
}
$db->close();
?>