<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/addimage.css">
</head>
<body>
    <header>

    </header>
    <main>
        <div id="osef">

        </div>
    <form id="formAdd" action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="img">Upload your image</label>
            <input type="file" id="img" name="img">
        </div>
        <div id="addBut-container">
        <button id="send">Envoyer</button>
        </div>
    </form>
    </main>
</body>
</html>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $targetDir = '../img/';

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $destination = $targetDir . $fileName;

        if (move_uploaded_file($fileTmpName, $destination)) {
            // Récupérer l'email de l'utilisateur (à adapter selon votre système)
            $userEmail = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

            // Construire le tableau avec les informations de l'image
            $imageInfo = array(
                'name' => $fileName,
                'path' => $destination,
                'user_email' => $_SESSION['user']
            );

            // Chemin du fichier JSON
            $imgJsonFile = '../bdd/img.json';

            // Charger le contenu actuel du fichier JSON s'il existe
            $currentData = file_exists($imgJsonFile) ? json_decode(file_get_contents($imgJsonFile), true) : array();

            // Ajouter les informations de l'image au tableau existant
            $currentData[] = $imageInfo;

            // Écrire le tableau mis à jour dans le fichier JSON
            file_put_contents($imgJsonFile, json_encode($currentData, JSON_PRETTY_PRINT));

            echo "L'image a été téléchargée avec succès et les informations ont été enregistrées.";
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
        echo "Une erreur est survenue lors du téléchargement de l'image.";
    }
}

?>
