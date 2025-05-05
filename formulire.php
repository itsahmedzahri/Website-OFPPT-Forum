<?php
// Connexion
$pdo = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");

$error = '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$center = $_POST['center'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($username) || empty($password) || empty($center)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Vérifier si le nom d'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $userExists = $stmt->fetchColumn();

        if ($userExists) {
            $error = "Erreur : Ce nom d'utilisateur est déjà utilisé.";
        } else {
            // Insertion
            $stmt = $pdo->prepare("INSERT INTO users (username, password, center) VALUES (?, ?, ?)");
            $stmt->execute([$username, $password, $center]);

            // Rediriger vers bienvenue avec les données
            header("Location: bienvenue.php?username=" . urlencode($username) . "&password=" . urlencode($password) . "&center=" . urlencode($center));
            exit;
        }
    }
}
?>

<!-- Affichage du formulaire -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post">
    <label>Nom d'utilisateur : <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <label>Centre : <input type="text" name="center" value="<?php echo htmlspecialchars($center); ?>" required></label><br>
    <button type="submit">S'inscrire</button>
</form>

</body>
</html>
