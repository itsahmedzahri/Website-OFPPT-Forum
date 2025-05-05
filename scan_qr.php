<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>QR Code Scanner</title>
  <script src="https://unpkg.com/html5-qrcode"></script>
  <style>
    body {
      background-color: #000;
      margin: 0;
      padding: 0;
      color: white;
      font-family: sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }

    #reader {
      width: 500px;
      max-width: 100%;
    }

    .message {
      margin-top: 20px;
      font-size: 18px;
      color: lime;
    }
  </style>
</head>
<body>

<h2>Scanner un QR Code</h2>
<div id="reader"></div>
<div class="message" id="message"></div>

<script>
  function onScanSuccess(decodedText, decodedResult) {
  const cleanText = decodeURIComponent(decodedText).replace(/\+/g, ' ');
  console.log("Texte QR décodé:", cleanText);

  document.getElementById('message').textContent = "QR détecté : " + cleanText;

  const match = cleanText.match(/Nom\s*:\s*(.*?)\s*[-–]\s*Centre\s*:/i);

  if (!match || !match[1]) {
    console.error("Échec d'extraction du nom. Texte:", cleanText);
    alert("❌ Nom d'utilisateur non trouvé dans le QR.");
    return;
  }

  const username = match[1].trim();
  console.log("Nom extrait :", username);

  fetch("verify_qr.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "username=" + encodeURIComponent(username)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert("✅ Bienvenue, " + data.username);
    } else {
      alert("❌ Code invalide.");
    }
  })
  .catch(error => {
    alert("❌ Erreur de vérification.");
    console.error(error);
  });

  scanner.clear().then(() => {
    console.log("Scanner arrêté.");
  });
}



  const scanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: { width: 250, height: 250 },
    rememberLastUsedCamera: true,
    aspectRatio: 1.333
  });

  scanner.render(onScanSuccess);
</script>

</body>
</html>
