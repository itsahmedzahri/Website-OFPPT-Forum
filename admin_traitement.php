<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");

// Récupérer les données du formulaire
$username = $_POST['Username'] ?? '';
$password = $_POST['Password'] ?? '';

// Vérifier que les champs sont remplis
if (empty($username) || empty($password)) {
    header("Location: index.php?error=empty");
    exit;
}

// Vérifier si l'utilisateur existe dans la table admin
$stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
    if ($password === $user['password']) {
        header("Location: scan_qr.php");
        exit;
    } else {
        header("Location: index.php?error=wrong_password");
        exit;
    }
} else {
    header("Location: index.php?error=invalid_admin");
    exit;
}