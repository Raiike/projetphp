<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/inscription.css">
</head>
<header>
    <div id="already-log">
        <a id="sub" href="http://localhost/exphp/pages/inscription.php">S'inscrire</a>
        <a id="log" href="http://localhost/exphp/pages/login.php">Se connecter</a>
    </div>
</header>
<main>
    <div id="osef">

    </div>
    <div id="title-container">
    <h1>Inscription</h1>
    </div>
    <form id ="form-register" action="" method="post">
        <div>
        </div>
        <div id="name-container">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" placeholder="ex:bassem">
        </div>
        <div id="email-container">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="example@tuto.com">
        </div>
        <div id="password-container">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="ex:azerty123">
        </div>
        <div id="button-container">
            <button id="send">Envoyer</button>
        </div>
    </form>
</main>
</body>
</html>
<?php
session_start();
$jsonFile = "../bdd/user.json";
$errors = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!isset($_POST['name']) || !preg_match("/^[A-Za-zéèàêëïîç\-']+(?: [A-Za-zéèàêëïîç\-']+)?$/", $_POST['name'])) {
        echo ("le nom n'est pas bon");
        $errors = true;
    }
    if (!isset($_POST['email']) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $_POST['email'])) {
        echo ("l'email n'est pas bon");
        $errors = true;
    }
    if (!isset($_POST['password']) || !preg_match("/^(?=.*[!@#$%^&*()-_+=])[a-zA-Z0-9!@#$%^&*()-_+=]{8,}$/", $_POST['password'])) {
        echo ("le mdp n'est pas bon");
        $errors = true;
    }
    if (!$errors) {
        $jsonData = file_get_contents($jsonFile); // je recupere le json de mes users
            n_decode($jsonData, true); // je decode le json en tableau associatif lisible par PHP      

        //je construit mon nouvel utilisateur
          $newUser = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT) // je hash le mot de passe
        );
        $users[] = $newUser; //j'insere dans le tableau de tout mes users, mon nouvel user
        $jsonUpdated = json_encode($users, JSON_PRETTY_PRINT); // j'encode mon tableau en JSON
        file_put_contents($jsonFile, $jsonUpdated); // j'ecrit mon nouveau tableau dans mon fichier
        header("Location: ./login.php");
    }
}
?>
