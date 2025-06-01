<?php
// ...existing code après insertion dans la base...
$nouveau_nom = strtolower(str_replace(' ', '_', $habitat_name)); // ex: "Lac Bleu" => "lac_bleu"
$nouveau_fichier = "d:/ZOO-Arcadia44/php/$nouveau_nom.php";
$modele = "d:/ZOO-Arcadia44/php/modele_habitat.php"; // à créer une fois

if (!file_exists($nouveau_fichier)) {
    $contenu = file_get_contents($modele);
    // Remplace le nom de l'habitat dans le modèle par le nouveau
    $contenu = str_replace('HABITAT_MODELE', $habitat_name, $contenu);
    file_put_contents($nouveau_fichier, $contenu);
}