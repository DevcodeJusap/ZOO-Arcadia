<?php
include 'session_check.php';
include 'db_connection.php';

$habitatId = $_POST['habitatId'];

$query = "DELETE FROM habitats WHERE id='$habitatId'";

if (mysqli_query($conn, $query)) {
    echo "Success";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>