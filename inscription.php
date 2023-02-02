<?php


require('config.php'); // connexion à la bdd 

/************************ VARIABLES **************/


@$login = $_POST['login'];
@$passwd = $_POST['password'];
@$confirm_passwd = $_POST['confirmpasswd'];
@$submit = $_POST['submit'];
@$mess_error = "";
@$mess_login = "";



if (isset($submit)) {

    $req = mysqli_query($connect, "SELECT login FROM utilisateurs"); //requete pour selectionner tout les logins de la table utilisateurs

    $recup_tab = mysqli_fetch_all($req, MYSQLI_ASSOC);
    //var_dump($recup_tab);

    foreach ($recup_tab as $user) // boucle qui sert à recupere les logins deja existant car transformation bbd en tableau association

        if ($user['login'] == $login) { // si l'input du login = à la valeur du champs login qui est dans la bdd

            $mess_login = "Ce login existe déja";
            echo "sa existe";
        }

    $login = $_POST['login']; //affection d'une variable pour l'utiliser dans mes condtions 

    if (empty($login) && empty($passwd) && empty($confirm_passwd)) { // si tous les champs sont vides

        $mess_error = "Veuillez remplir tout les champs";
    } elseif (!empty($login) && empty($passwd)) { //si le champ login est saisi & que le champs mot de passe est vide

        $mess_error = "Veuillez saisir un mot de passe";
    } elseif (!empty($login) && ($passwd != $confirm_passwd)) { // si les deux saisis de mot de pass sont incorrectes

        $mess_error = "Veuillez saisir le meme mot de passe";
    } elseif (empty($login) && ($passwd === $confirm_passwd)) { //si toutes les entrées saisis sont valides

        $mess_error = "Veuillez saisir un login";
    } else {

        $req2 = $connect->query("INSERT INTO utilisateurs(login,password) VALUES ('$login','$passwd')"); //requete sql pour insert des users avec les valeurs des inputs
        $mess_connect = "Inscription réussi!";
        header('refresh:3 ;url=connexion.php'); //redirection vers la page de connexion avec la fonction header

    }
}


?>
<!DOCTYPE html>
<html lang="Fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuille de style CSS  -->
    <link rel="stylesheet" href="style.css">
    <!-- Font google api -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!-- Titre page -->
    <title>Livre D'or Inscription</title>
</head>

<body>

    <!-- ******************header************************ -->

    <?php require('header.php') ?>

    <div class="container-register">
        <h1>Hermione</h1>
        <small><i>" Maintenant, si ça ne vous dérange pas, je vais me coucher, avant que l'un de vous ait encore une brillante idée pour nous faire tuer…ou pire, nous faire expulser ! "</i></small>
        <br>
    </div>



    <div class="container-form">

        <form action="" method="POST" autocomplete="off">

            <br>
            <label for="login">Login</label>
            <br>
            <br>
            <input type="text" name="login" id="login" placeholder="Votre login">
            <br>
            <br>
            <label for="password">Password</label>
            <br>
            <br>
            <input type="password" name="password" id="login" placeholder="Votre mot de passe">
            <br>
            <br>
            <label for="confirm_passwd">Confirmation Password</label>
            <br>
            <br>
            <input type="password" name="confirmpasswd" id="confirmpasswd" placeholder="Confirmation mot de passe">
            <br>
            <br>

            <hr>

            <input type="submit" value="S'inscrire" name="submit">
            <br>
            <br>
            <?= "<p style='color:red;'>$mess_error</p>" ?>

            <?= "<p style='color:red;'>$mess_login </p>" ?>

            <?= @"<p style='color:red;'>$mess_connect </p>" ?>


        </form>

    </div>

</body>

</html>