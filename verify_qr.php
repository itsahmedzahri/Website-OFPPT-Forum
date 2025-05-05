<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $username = strtolower(trim($_POST['username'] ?? ''));

    // Pour debug
    file_put_contents("debug.txt", $username);

    if (empty($username)) {
        echo json_encode(["success" => false, "message" => "Nom d'utilisateur manquant."]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE LOWER(username) = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode([
            "success" => true,
            "username" => $user['username']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Utilisateur non trouvé."]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur : " . $e->getMessage()]);
}