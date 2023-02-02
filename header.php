<?php if (!isset($_SESSION['login'])) { ?>
    <header>

        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="inscription.php">S'enregistrer</a></li>
                <li><a href="commentaires.php">Livre d'or</a></li>
            </ul>
        </nav>
    </header>

<?php } else { ?>

    <header>

        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <!--  <li><a href="connexion.php">Login</a></li>
             <li><a href="inscription.php">S'enregistrer</a></li> -->
                <li><a href="commentaires.php">Livre d'or</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Deconnexion</a></li>


            </ul>
        </nav>
    </header>
<?php } ?>