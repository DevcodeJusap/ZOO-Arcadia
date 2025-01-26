<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $avis_id = $_POST['avis_id'];
    $action = $_POST['action'];

    if ($action === 'valider') {
        $sql = "SELECT * FROM avis WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $avis_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $avis = $result->fetch_assoc();

        $age = isset($avis['age']) ? $avis['age'] : 'N/A';

        $avisContent = "
        <div class='item'>
            <div class='avis-content'>
                <p>\"{$avis['avis']}\"</p>
                <span>— {$avis['nom']}, {$age} ans</span>
            </div>
            <div class='rating'>
                " . genererEtoiles($avis['note']) . "
            </div>
        </div>
        ";

        $indexFile = 'index.html';
        $indexContent = file_get_contents($indexFile);
        $updatedContent = str_replace('</div><!-- Fin de la section carousel-avis -->', $avisContent . '</div><!-- Fin de la section carousel-avis -->', $indexContent);
        file_put_contents($indexFile, $updatedContent);

        // Mettre à jour l'état de l'avis dans la base de données
        $sql = "UPDATE avis SET status = 'validé' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $avis_id);
        $stmt->execute();
    } elseif ($action === 'rejeter') {
        // Mettre à jour l'état de l'avis dans la base de données
        $sql = "UPDATE avis SET status = 'rejeté' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $avis_id);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();
    header('Location: employe_dashboard.php');
    exit();
}

function genererEtoiles($note) {
    $etoiles = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $note) {
            $etoiles .= '<i class="fas fa-star"></i>';
        } elseif ($i === ceil($note) && $note % 1 !== 0) {
            $etoiles .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $etoiles .= '<i class="far fa-star"></i>';
        }
    }
    return $etoiles;
}
?>