<?php
$pdo = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");

$username = $_GET['username'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}

$photoBase64 = base64_encode($user['photo']);
$photoSrc = "data:image/jpeg;base64," . $photoBase64;
$qrData = urlencode("Nom: {$user['username']} - Centre: {$user['center']}");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eee;
        }

        .invitation-wrapper {
    position: relative;
    width: 800px;
    height: 450px;
    margin: 20px auto;
    border: 1px solid #ccc;
}

.template-img {
    width: 100%;
    height: auto;
    display: block;
}

/* Example positions — adjust based on your image */
.username {
    position: absolute;
    top: 330px;
    left: 530px;
    font-size: 18px;
    font-weight: bold;
    color: #ffffff;
    font-family: 'League Spartan', sans-serif;
    text-transform: uppercase;
}

.center {
    position: absolute;
    top: 360px;
    left: 520px;
    font-size: px;
    color: #ffffff;
    font-family: 'League Spartan', sans-serif;
    text-transform: uppercase;
}

.photo {
    position: absolute;
    top: 57.5px;
    left: 491px;
    width: 263px;
    height: 263px;
    
    border-radius: 100%;
}

.qrcode {
    position: absolute;
    top: 302px;
    left: 261px;
    width: 51px;
    height: 51px;
}
.qrcode canvas {
  border-radius: 10px;
}




        #downloadInvitation {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #0099cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #downloadInvitation:hover {
            background-color: #0077aa;
        }
    </style>
</head>
<body>

        <div class="invitation-wrapper" id="invitationCard">
            <img src="invitation_template.png" class="template-img" alt="Template">
            
            <!-- Positioned Elements -->
            <div class="username"><?= htmlspecialchars($user['username']) ?></div>
            <div class="center">Center : <?= htmlspecialchars($user['center']) ?></div>
            <img class="photo" src="<?= $photoSrc ?>" alt="Photo de l'utilisateur">
            <div id="qrcode" class="qrcode"></div>
        </div>


    <button id="downloadInvitation">Télécharger l'invitation</button>

    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "<?= $qrData ?>",
            width: 134,
            height: 134
        });

        document.getElementById("downloadInvitation").addEventListener("click", function () {
            const invitation = document.getElementById("invitationCard");

            html2canvas(invitation).then(canvas => {
                const link = document.createElement("a");
                link.download = "invitation.png";
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        });
    </script>

</body>
</html>
