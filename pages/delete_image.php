<?php
session_start();

if (isset($_GET['image_name'])) {
    $imageNameToDelete = $_GET['image_name'];

    // Chemin vers le fichier JSON contenant les informations sur les images des utilisateurs
    $jsonFilePath = '../bdd/img.json';

    // Charger les données JSON à partir du fichier
    $jsonData = file_get_contents($jsonFilePath);
    $imageData = json_decode($jsonData, true);

    // Vérifier si les données ont été chargées avec succès
    if ($imageData && is_array($imageData)) {
        foreach ($imageData as $key => $imageInfo) {
            if (isset($imageInfo['name']) && $imageInfo['name'] === $imageNameToDelete) {
                // Supprimer l'image correspondante du tableau
                unset($imageData[$key]);

                // Réécrire les données JSON dans le fichier après suppression
                $updatedJsonData = json_encode($imageData, JSON_PRETTY_PRINT);
                file_put_contents($jsonFilePath, $updatedJsonData);

                // Rediriger vers la page dashboard.php après suppression
                header('Location: dashboard.php');
                exit;
            }
        }
    } else {
        echo "Erreur lors du chargement des données.";
    }
} else {
    echo "Nom de l'image à supprimer non spécifié.";
}
?>
    