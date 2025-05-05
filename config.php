<?php
// Activer le rapport d'erreurs MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Paramètres de connexion
$host = 'localhost';       // Adresse du serveur
$user = 'root';            // Nom d'utilisateur MySQL
$password = '';            // Mot de passe MySQL
$dbname = 'forum';         // Nom de la base de données

try {
    // Connexion à la base de données
    $conn = new mysqli($host, $user, $password, $dbname);

    // Définir l'encodage des caractères en UTF-8
    $conn->set_charset("utf8");

} catch (Exception $e) {
    // En cas d'erreur, arrêter le script avec un message clair
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>