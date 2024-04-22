<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<?php
session_start();
$jsonFile = '../bdd/user.json';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['email'])) {
            $jsonData = file_get_contents($jsonFile); // je recupere mon json de users
            $users = json_decode($jsonData, true); // je convertie en tableau associatif lisible par PHP mon json
            $foundUser = false; // je declare une variable a false qui me permettra de stoquer mon user
            //je parcourt mes users
            foreach ($users as $user) {
                //si je trouve un user qui correspond a mon mail, je le stoQQQQQue dans foundUser et je break
               if ($user['email'] == $_POST['email']) {
                $foundUser = $user;
                break;
               }
            }
            // je verifie si le mot de passe en post correspond a celui qui est hasher en base
            if (password_verify($_POST['password'], $foundUser['password'])) {
                $_SESSION['user'] = $foundUser['email'];
                header("Location: ./dashboard.php");
                exit;
            }else{
                echo('<p id="errorP">Mot de passe incorect</p>');
            }
        }
    }
?>
<body>
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
            <h1>Connexion</h1>
        </div>
    <form id="formLogin" action="" method="post">
      <div id="form-log">
        <div id="email-container">
            <label for="email">Email</label>
            <input type="text" id="email" name="email">
        </div>
        <div id="password-container">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div id="confirm-container">
        <button id="send">Envoyer</button>
        </div>
        </div>
    </form>
    </main>
</body>
</html>