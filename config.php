<?php

echo "<br>";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=livreor", "root", "");
    // Configurez l'option d'erreur pour déclencher des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie en utilisant PDO";
} catch (PDOException $e) {
    die("La connexion a échoué: " . $e->getMessage());
}