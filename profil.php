<?php


require('config.php'); //connexion à la bdd
session_start(); //start d'une session


if (isset($_POST['submit'])) { // si l'utilsateur clic sur l'input submit

    /************** VARIABLES ***************/

    $log = $_POST['login'];
    @$newlog = $_POST['newlog'];
    $passwd = $_POST['password'];
    $confirmpasswd = $_POST['confirmpasswd'];
    $sess = $_SESSION['login'];

    /************** VARIABLES messages error ***************/

    $mess_login = "";
    $mess_pass = "";
    $mess_error = "";
    $maj_profil = "";


    /******************* CONDTIONS *****************************/

    if (!empty($log) && empty($password) && empty($confirmpasswd)) { //si les deux champs password & confirmation de password ne sont pas remplies

        $mess_error = "Veuillez remplir tout les champs";
    } elseif ($passwd != $confirmpasswd) { //si les deux champs passwd sont differents

        $mess_error = "Veuillez saisir le meme mot de passe";
    } elseif (!empty($log) && $passwd === $confirmpasswd) { //only if the password is confirm

        $req = $connect->query("UPDATE utilisateurs SET login='$newlog',password='$passwd' WHERE login='$log'");
        $_SESSION['login'] = $newlog;
        $maj_profil = "Vous venez de modifier les données de votre profil : " . $sess;
        session_destroy();
        header('refresh:3 index.php');
    } else {
        $mess_error = "Recommencez";
    }
}


if (isset($_POST['delete'])) { //if user click on the button delete 
    $req2 = "DELETE FROM utilisateurs WHERE id='$_SESSION[id]'"; //requete pour select les id des utilisateurs
    $req4 = mysqli_query($connect, $req2);
    session_destroy(); //session detruite apres click
    header('location:usersupp.php'); //redirection 
}
?>

<!DOCTYPE html>
<html lang="Fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuille de style -->
    <link rel="stylesheet" href="style.css">
    <!-- Font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!-- Titre de la plage -->
    <title>Profil Livre d'or</title>
</head>

<body>

    <?php require('header.php'); ?>

    <?php if (isset($_SESSION['login'])) { ?>
        <div class="container-register">
            <h1>Changer d'Acteur<?php if (isset($_SESSION['login'])) {
                                    echo "<p>" . " User : " . ucwords($_SESSION['login']) . "</p>";
                                } ?></h1>
            <br>
            <small><i>Avant, je me disais que ma vie était une tragédie. Je me rends compte que c'est une comédie.</i> </small>
        </div>

        <div class="container-form">

            <form action="" method="POST">


                <label for="login">Login</label>
                <br>
                <br>
                <input type="text" name="login" id="name" value="<?= @$_SESSION['login'] ?>">
                <br>
                <br>
                <label for="newlog">Nouveau login</label>
                <br>
                <br>
                <input type="text" name="newlog">
                <br>
                <br>
                <label for="password">Nouveau mot de passe</label>
                <br>
                <br>
                <input type="password" name="password">
                <br>
                <br>
                <label for="password">Confirmer Mot de passe</label>
                <br>
                <br>
                <input type="password" name="confirmpasswd">
                <br>
                <br>
                <hr>
                <input type="submit" name="submit" value="Modification">
                <br>
                <input style='background-color:red;' type="submit" name="delete" value="Supprimer votre profil">
                <?= @$mess_error ?>
                <?= @$maj_profil ?>


            </form>






        </div>
    <?php } else { ?>
    <?php header('location: connexion.php');
    } ?>
</body>

</html>