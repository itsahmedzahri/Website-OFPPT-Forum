<?php
$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';
$center = $_GET['center'] ?? '';

if (empty($username) || empty($password) || empty($center)) {
  echo "<h1>Accès non autorisé</h1>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bienvenue</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    body {
      background-color: rgb(63, 190, 192);
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 100px;
    }
    #qrcode {
      margin-top: 40px;
      margin-left: 750px;
    }
    .download-btn {
      margin-top: 20px;
      padding: 10px 20px;
      background-color:rgb(0, 0, 0);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .download-btn:hover {
      background-color:rgb(0, 0, 0);
    }
  </style>
</head>
<body>
  <h1>Bienvenue, <?= htmlspecialchars($username) ?> !</h1>
  <p>Centre : <?= htmlspecialchars($center) ?></p>
  <div id="qrcode"></div>

  <button class="download-btn" id="downloadBtn">Télécharger le QR Code</button>

  <script>
    const qrData = "Utilisateur=<?= $username ?>;Centre=<?= $center ?>";
    
    // Générer le QR Code
    const qrCode = new QRCode(document.getElementById('qrcode'), {
      text: "verify.php?user=<?= urlencode($username) ?>&center=<?= urlencode($center) ?>",
      width: 200,
      height: 200
    });

    // Fonction pour télécharger le QR Code
    document.getElementById("downloadBtn").addEventListener("click", function() {
      const canvas = document.querySelector("#qrcode canvas");
      if (canvas) {
        const dataURL = canvas.toDataURL("image/png"); // Récupère l'URL de l'image en format PNG
        const link = document.createElement("a");
        link.href = dataURL;
        link.download = "QRCode.png"; // Nom du fichier à télécharger
        link.click(); // Lance le téléchargement
      } else {
        alert("QR Code non disponible.");
      }
    });
  </script>
</body>
</html>