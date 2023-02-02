<?php

session_start(); // start d'une session

?>


<!DOCTYPE html>
<html lang="Fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuille de style css -->
    <link rel="stylesheet" href="style.css">
    <!-- Import font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!-- Titre de la page -->
    <title>Livre d'or</title>
</head>

<body>

    <?php require("header.php") ?>

    <div class="container-welcome">

        <?php if (!isset($_SESSION['login'])) { // si la session n'est pas start 
        ?>

            <h1>Pulp Fiction</h1>

            <small><i>"C'est à une demi-heure d'ici. J'y suis dans dix minutes."</i></small>
            <br>


        <?php } else { ?>

            <?= '<h1> ' . ucwords($_SESSION['login']) . " " . ' veut jouer dans nos films </h1>'; ?> <!--fonction ucwords pour mettre la premiere lettre en majuscules -->

        <?php } ?>



    </div>


</body>

</html>