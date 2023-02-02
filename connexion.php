<?php
session_start(); //start d'une session
//connection bdd
require("config.php");

/***************VARIABLES *************/


@$submit = $_POST['submit']; //le @ servant à cacher les erreurs si les variables sont pas definis
@$log = $_POST['login'];
@$passwd = $_POST['password'];
@$mess_form = "";

if (isset($submit)) {

    if (empty($log) && empty($passwd)) { //si les deux inpouts sont vides

        $mess_form = "Veuillez saisir tout les champs";
    } elseif (!empty($log) && empty($passwd)) { // si l'input log n'est pas vide & que l'input password est vide

        $mess_form = "Veuillez rentrez un mot de passe";
    } else {

        $req = mysqli_query($connect, "SELECT * FROM utilisateurs WHERE login='$log' AND password='$passwd'"); //requete sql
        $tab_result = mysqli_fetch_all($req, MYSQLI_ASSOC); //on vas chercher la bdd et la convertir en tableau 
        $id_ = intval($tab_result[0]['id']); //conversion de l'id en integer car son type est string

        foreach ($tab_result as $user) { //boucle sur la bdd pour recupere log,passwd,id


            if (($user['login'] == $log) && ($user['password'] == $passwd)) { //condition si le log et le passwd sont tout les deux justes

                $_SESSION['login'] = $log;
                $_SESSION['password'] = $passwd;
                $_SESSION['id'] = $id_;


                header("location: index.php"); //redirection une fois que le user est connecté
                die();
            }
        }

        $mess_form = "Utilisateur Inexistant"; //message derreur si tout les conditions sont false

    }
}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuille de style css  -->
    <link rel="stylesheet" href="style.css">
    <!-- Font google  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!-- Titre de la page -->
    <title>Connexion Livre d'or</title>
</head>

<body>

    <?php require('header.php'); ?>

    <div class="container-welcome">
        <h1>Forrest Gump</h1>
        <small><i>"La vie c'est comme une boîte de chocolats, on ne sait jamais sur quoi on va tomber."</i></small>

    </div>

    <div class="container-form">

        <form action="" method="POST" autocomplete="off">


            <label for="login">Login</label>
            <br>
            <br>
            <input type="text" name="login" id="login" placeholder="Votre Login">
            <br>
            <br>
            <label for="password">Mot de passe</label>
            <br>
            <br>
            <input type="password" name="password" id="password" placeholder="Votre mot de passe">
            <br>
            <br>
            <hr>
            <input type="submit" name="submit" value="Connexion"><br>
            <br>
            <?= "<p style='color:red;'>$mess_form </p>" ?>

        </form>

    </div>
</body>

</html>