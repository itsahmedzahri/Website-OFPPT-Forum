<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Scanner QR Code</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 50px;
    }
    #scanner-container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
    }
    #video {
      width: 100%;
      height: auto;
      border: 2px solid #333;
    }
    #result {
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h1>Scanner le QR Code</h1>
  <p>Utilisez votre caméra pour scanner un QR Code.</p>

  <div id="scanner-container">
    <video id="video" autoplay></video>
    <canvas id="canvas" style="display:none;"></canvas>
  </div>

  <div id="result">Résultat du scan: Aucun QR code détecté.</div>

  <script>
    // Accéder à la caméra
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const resultElement = document.getElementById('result');

    // Démarre la vidéo
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
      .then(stream => {
        video.srcObject = stream;
        video.setAttribute("playsinline", true); // Nécessaire pour iPhone
        video.play();
        scanQRCode();
      })
      .catch(err => {
        alert("Erreur d'accès à la caméra : " + err.message);
      });

    // Fonction pour scanner le QR code
    function scanQRCode() {
      setInterval(() => {
        // Dessiner le contenu de la vidéo sur le canvas
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Lire l'image du canvas
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, canvas.width, canvas.height);

        // Si un QR code est détecté, afficher le rés
index.php:
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Page de Connexion</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: rgb(48, 142, 179);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(33, 112, 169, 0.1);
      width: 300px;
      margin-bottom: 20px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .login-container input,
    .login-container select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      background-color: rgb(36, 137, 199);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .login-container button:hover {
      background-color:rgb(58, 106, 202);
    }

    #qrcode {
      margin-top: 20px;
    }

    #otherCenter {
      display: none;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2><img src="1.png" alt=""></h2>
<form id="loginForm" method="POST" action="traitement.php">
  <input type="text" id="username" name="username" placeholder="Nom d'utilisateur">
  <input type="password" id="password" name="password" placeholder="Mot de passe">

  <select id="center" name="center" onchange="toggleOtherCenter()">
    <option value="">--Choisir un centre--</option>
    <option value="ISTA Taroudant">ISTA Taroudant</option>
    <option value="CQP Taroudant">CQP Taroudant</option>
    <option value="ISTA Oulad Teima">ISTA Oulad Teima</option>
    <option value="ENSIAS">ENSIAS</option>
    <option value="Autre">Autre</option>
  </select>

  <!-- Champ "Autre" (hors du <select>) -->
  <div id="otherCenter" style="display: none;">
    <input type="text" id="Autre" name="Autre" placeholder="Veuillez spécifier le centre">
  </div>

  <button type="submit">Se connecter</button>
</form>

  </div>

  <div id="qrcode"></div>

  <script>