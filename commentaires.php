<?php

require("config.php"); //connexion à la bbd

session_start();

/* ************************ LOGIQUE PHP ****************** */

if (isset($_POST['submit'])) {
    $sess = $_SESSION['login'];
    $comment = $_POST['commentaire'];
    $mess_error = "";
    $date = date('Y/m/d H:i:s');

    // Rechercher l'utilisateur actuel par son login
    $sql = "SELECT * FROM utilisateurs WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':login', $sess, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($comment)) {
        $mess_error = "Veuillez saisir un commentaire"; // message d'erreur si aucun commentaire n'est saisi
    } else {
        // Insérer le commentaire dans la base de données
        $sql = "INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (:comment, :id_user, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $user['id'], PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
    }
}

/* ********************* SUPPRIMER UN COMMENTAIRE ******************* */

if (isset($_POST['delete'])) {
    $commentId = $_POST['delete'];
    $sql = "DELETE FROM commentaires WHERE id = :commentId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $stmt->execute();
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
    $sql = "SELECT commentaires.date, utilisateurs.login, commentaires.commentaire, commentaires.id
            FROM commentaires
            INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
            ORDER BY date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    // Récupérez toutes les lignes sous forme de tableau associatif
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo "<table>
                <thead>
                    <tr>
                        <th scope='col'>Posté par</th>
                        <th scope='col'>Commentaire</th>
                        <th scope='col'>Date du poste</th>";
        if (isset($_SESSION['login']) && $_SESSION['login'] == $row['login']) {
            echo "<th scope='col'>Suppression</th>";
        }
        echo "</tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$row['login']}</td>
                        <td>{$row['commentaire']}</td>
                        <td>{$row['date']}</td>";
        if (isset($_SESSION['login']) && $_SESSION['login'] == $row['login']) {
            echo "<td><form action='' method='POST'><button name='delete' value='{$row['id']}'>Supprimer</button></form></td>";
        }
        echo "</tr>
                </tbody>
              </table><br>";
    }
    ?>
</div>
<br>
<?php if (!isset($_SESSION['login'])) { ?>
    <div class='container-form'>
        <p>Laissez un commentaire ? Connectez-vous sur votre profil -> <a href='connexion.php'>Connexion</a></p>
    </div>
<?php } ?>

<?php if (isset($_SESSION['login'])) { ?>
    <div class="container-form">
        <form action="" method="POST">
            <label for="commentaire">Laissez votre commentaire :</label>
            <br><br>
            <textarea name="commentaire" id="commentaire" cols="30" rows="10"></textarea>
            <br><br>
            <input class='comment' type="submit" name="submit" value="Poster">
            <br><br>
            <p style='color:red;'><?= @$mess_error ?></p>
        </form>
    </div>
<?php } ?>

</body>

</html>