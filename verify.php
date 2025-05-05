<?php
$pdo = new PDO("mysql:host=localhost;dbname=forum", "root", "");

$user = $_GET['user'] ?? '';
$center = $_GET['center'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND center = ?");
$stmt->execute([$user, $center]);

if ($stmt->rowCount() > 0) {
  // Utilisateur trouvé : page de validation verte
  echo '<body style="background-color: #c8f7c5; font-family: Arial; text-align: center; padding-top: 100px;">
          <h1>✅ Vérification réussie !</h1>
        </body>';
} else {
  // Utilisateur introuvable : page d’erreur rouge
  echo '<body style="background-color: #f8d7da; font-family: Arial; text-align: center; padding-top: 100px;">
          <h1>❌ Vérification échouée !</h1>
        </body>';
}
?>