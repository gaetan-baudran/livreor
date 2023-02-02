<?php

require("config.php"); //connection à la bbd

session_start(); //start de session

/* ************************ LOGIC PHP ****************** */

if (isset($_POST['submit'])) {


    $sess = $_SESSION['login'];
    $comment = $_POST['commentaire'];
    $mess_error = "";
    $date = date('Y/m/d H:i:s');

    $req = mysqli_query($connect, "SELECT * FROM utilisateurs WHERE login='$sess'");
    $tab_result = mysqli_fetch_all($req, MYSQLI_ASSOC);
    $id_user = intval($tab_result[0]['id']);


    if (empty($comment)) {

        $mess_error = "Veuillez saisir un commentaire"; //mess error si aucun commentaire n'est saisis 

    } else {


        $comment = mysqli_query($connect, "INSERT INTO commentaires(commentaire,id_utilisateur,date) VALUES ('$comment','$id_user','$date')"); //requete insertion

    }
}

/* ********************* DELETE COMMENT ******************* */

if (isset($_POST['delete'])) {

    $req = "DELETE from commentaires WHERE commentaires.id='$_POST[delete]'";
    $del = mysqli_query($connect, $req);
}

?>


<!DOCTYPE html>
<html lang="Fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuille de style css  -->
    <link rel="stylesheet" href="style.css">
    <!-- Font google api -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!-- Titre page -->
    <title>Livre d'or</title>
</head>

<body>


    <?php require('header.php'); ?>


    <div class="container-register">
        <h1>Filmographie <?php if (isset($_SESSION['login'])) {
                                echo "<p> Acteur : " . " " . ucwords($_SESSION['login']) . "</p>";
                            } ?></h1>

    </div>


    <div class="container-comment">

        <?php

        $query = mysqli_query($connect, "SELECT commentaires.date,  utilisateurs.login, commentaires.commentaire, commentaires.id FROM commentaires INNER JOIN utilisateurs ON commentaires.id_utilisateur=utilisateurs.id ORDER BY date DESC");
        $rowcount = mysqli_num_rows($query);
        $row = mysqli_fetch_all($query, MYSQLI_ASSOC);

        for ($i = 0; $i < $rowcount; $i++) {
            echo "
                          <table>
                            <thead>
                            
                                 <tr>
                                    <th scope='col'>Poster par</th>
                                    <th scope='col'>Commentaires</th>
                                    <th scopte='col'>Date du poste</th>";
            if (@$_SESSION['login'] == $row[$i]['login']) {
                echo "<th scope =col'>Suppression</th>";
            }

            echo " </tr>
                                
                            </thead>
                                 <tbody>
                                    <tr>
                                        <td>" . $row[$i]['login'] . "</td><span class='vertical-line'></span>
                                        <td>" . $row[$i]['commentaire'] . "</td>
                                        <td>" . $row[$i]['date'] . "</td>";
            if (@$_SESSION['login'] == $row[$i]['login']) {

                echo "<td><form action='' method='POST'><button name='delete' value=" . $row[$i]['id'] . ">Supprimer</button> </form></td>";
            }

            echo "      </tr>
                                 </tbody>
                        </table>
                        ";



            echo "<br>";
        }


        ?>

    </div>
    <br>
    <?php if (!isset($_SESSION['login'])) { ?>
    <?php echo "
            <div class='container-form'>
                <p>Laissez un commentaire ? Connectez vous sur votre profil -> <a href='connexion.php'>Connexion</a></p>
            </div>
            ";
    } ?>

    <?php if (isset($_SESSION['login'])) { ?>

        <div class="container-form">

            <form action="" method="POST">


                <label for="comment">Laisser son commentaire:</label>
                <br>
                <br>
                <textarea name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
                <br>
                <br>
                <input class='comment' type="submit" name="submit" value="Poster">
                <br>
                <br>

                <?= "<p style='color:red;'>" . @$mess_error . "<p>" ?>

            </form>
        </div>

    <?php } ?>

</body>

</html>