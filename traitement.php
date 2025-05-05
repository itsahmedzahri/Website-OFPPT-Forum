<?php
$pdo = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$center   = trim($_POST['center'] ?? '');
$autre    = trim($_POST['Autre'] ?? '');

// Center handling
if ($center === 'Autre' && !empty($autre)) {
    $center = $autre;
}

// Check for empty fields
if (empty($username) || empty($password) || empty($center) || empty($_FILES['photo']['tmp_name'])) {
    header("Location: index.php?error=empty");
    exit;
}

// Username exists?
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetchColumn()) {
    header("Location: index.php?error=username_exists");
    exit;
}

// Handle image
$photoData = file_get_contents($_FILES['photo']['tmp_name']);

// Insert into DB
$stmt = $pdo->prepare("INSERT INTO users (username, password, center, photo) VALUES (?, ?, ?, ?)");
$stmt->execute([$username, $password, $center, $photoData]);

// Redirect to invitation
header("Location: invitation.php?username=" . urlencode($username));
exit;
?>
