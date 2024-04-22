<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images de l'utilisateur connecté</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <header>
        <div class="title-container">
            <h1>Images de l'utilisateur connecté</h1>
        </div>
        <div class="butOff-container">
            <a href="./addimage.php" id="butAddLink">Ajouter une Image</a>
            <a href="./logout.php" id="butOff">Déconnexion</a>
        </div>
    </header>
    <div class="osef">
    </div>
    <div class="imgUserContainer">
        <?php
        session_start();

        // Récupérer l'email de l'utilisateur connecté depuis la session (à adapter selon votre système)
        $userEmail = $_SESSION['user'];

        // Chemin vers le fichier JSON contenant les informations sur les images des utilisateurs
        $jsonFilePath = '../bdd/img.json';

        // Charger les données JSON à partir du fichier
        if (file_exists($jsonFilePath)) {
            $jsonData = file_get_contents($jsonFilePath);
            $imageData = json_decode($jsonData, true);

            // Vérifier si les données ont été chargées avec succès
            if ($imageData && is_array($imageData)) {
                foreach ($imageData as $imageInfo) {
                    // Vérifier si l'email de l'image correspond à l'utilisateur connecté
                    if (isset($imageInfo['user_email']) && $imageInfo['user_email'] === $userEmail) {
                        // Récupérer le nom et le chemin de l'image
                        $imageName = $imageInfo['name'];
                        $imagePath = $imageInfo['path'];

                        // Afficher le nom de l'image et l'image dans une div commune
                        echo '<div class="imgUser">';
                        echo "<h3>$imageName</h3>";
                        echo "<img src='$imagePath' alt='$imageName' style='width: 300px; margin: 10px;'>";

                        // Ajouter le bouton de suppression en utilisant un lien
                        echo "<a href='delete_image.php?image_name=$imageName' class='delete-btn'>Supprimer</a>";

                        echo '</div>';
                    }
                }
            } else {
                echo "<p>Erreur lors du chargement des données.</p>";
            }
        } else {
            echo "<p>Fichier JSON introuvable.</p>";
        }
        ?>
    </div>
        
</body>

</html>
