<?php
include 'db_connection.php';

$conn = OpenCon();

$sql = "SELECT id, animal_name, likes FROM animals ORDER BY likes DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-sm table-bordered table-striped table-hover small-text">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nom de l\'animal</th>';
    echo '<th>Likes</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td><a href="#" class="animal-link" data-toggle="modal" data-target="#animalModal" data-id="' . $row["id"] . '">' . htmlspecialchars($row["animal_name"]) . '</a></td>';
        echo '<td>' . htmlspecialchars($row["likes"]) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>Aucun animal trouvé.</p>';
}

CloseCon($conn);
?>