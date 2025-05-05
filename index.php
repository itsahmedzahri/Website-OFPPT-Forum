<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Page de Connexion</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('bg.png'); /* Path to your image */
      background-size: cover; /* Ensure the image covers the entire screen */
      background-position: center; /* Center the image */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh; /* Full viewport height */
    }

    .login-container {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(33, 112, 169, 0.1);
      width: 300px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .login-container input,
    .login-container select,
    .login-container button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .login-container button {
      background-color: rgb(36, 137, 199);
      color: white;
      border: none;
      cursor: pointer;
    }

    .login-container button:hover {
      background-color: rgb(58, 106, 202);
    }

    #qrcode {
      margin-top: 20px;
    }

    #otherCenter {
      display: none;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .social-icons a {
      margin: 0 10px;
      font-size: 30px;
      color: #333;
      text-decoration: none;
    }

    .social-icons a:hover {
      color: #007BFF;
    }

    /* Style for the circular switch button with QR icon */
    #switchButton {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 60px;
      height: 60px;
      background-color: rgb(36, 137, 199);
      color: white;
      border: none;
      border-radius: 50%;
      font-size: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
    }

    #switchButton:hover {
      background-color: rgb(58, 106, 202);
    }

  </style>
  <script>
    function toggleOtherCenter() {
      var centerSelect = document.getElementById('center');
      var otherCenter = document.getElementById('otherCenter');
      if (centerSelect.value === 'Autre') {
        otherCenter.style.display = 'block';
      } else {
        otherCenter.style.display = 'none';
      }
    }

    // Function to switch between user and admin login forms
    function toggleLoginForm() {
      var userForm = document.getElementById('userLoginForm');
      var adminForm = document.getElementById('adminLoginForm');
      var switchButton = document.getElementById('switchButton');

      if (userForm.style.display === 'none') {
        userForm.style.display = 'block';
        adminForm.style.display = 'none';
        switchButton.innerHTML = '<i class="fas fa-qrcode"></i>'; // Show QR icon
      } else {
        userForm.style.display = 'none';
        adminForm.style.display = 'block';
        switchButton.innerHTML = ''; // Show text when switched to Admin
      }
    }
    window.onload = function () {
  const params = new URLSearchParams(window.location.search);
  const error = params.get('error');

  const adminForm = document.getElementById('adminLoginForm');
  const userForm = document.getElementById('userLoginForm');
  const adminErrorMsg = document.getElementById('adminError');
  const userErrorMsg = document.getElementById('userError');
  const switchButton = document.getElementById('switchButton');

  if (error === 'wrong_password' || error === 'invalid_admin' || error === 'empty') {
    adminForm.style.display = 'block';
    userForm.style.display = 'none';
    switchButton.innerHTML = '';

    let message = '';
    if (error === 'empty') message = "Veuillez remplir tous les champs.";
    else if (error === 'wrong_password') message = "Mot de passe incorrect.";
    else if (error === 'invalid_admin') message = "Nom d'utilisateur introuvable.";

    adminErrorMsg.textContent = message;
    adminErrorMsg.style.display = 'block';
  }

  if (error === 'username_exists') {
    userForm.style.display = 'block';
    adminForm.style.display = 'none';
    switchButton.innerHTML = '<i class="fas fa-qrcode"></i>';

    userErrorMsg.textContent = "Ce nom d'utilisateur est déjà utilisé.";
    userErrorMsg.style.display = 'block';
  }
};
  </script>
</head>
<body>

  <div class="login-container">
    <h2><img src="logo.png" alt="" style="width: 40%; height: auto;"></h2>
    
    <!-- User Login Form -->
    <div id="userLoginForm">
    <form id="loginForm" method="POST" action="traitement.php" enctype="multipart/form-data">
        <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" id="password" name="password" placeholder="Mot de passe" required>

        <select id="center" name="center" onchange="toggleOtherCenter()">
          <option value="">--Choisir un centre--</option>
          <option value="ISTA Taroudant">ISTA Taroudant</option>
          <option value="CQP Taroudant">CQP Taroudant</option>
          <option value="ISTA Oulad Teima">ISTA Oulad Teima</option>
          <option value="ENSIAS">ENSIAS</option>
          <option value="Autre">Autre</option>
        </select>

        <div id="otherCenter" style="display: none;">
          <input type="text" id="Autre" name="Autre" placeholder="Veuillez spécifier le centre">
        </div>

        <label for="photo">Télécharger une photo :</label>
        <input type="file" name="photo" id="photo" accept="image/*" required>

        <button type="submit">Se connecter</button>
      </form>

      <p id="userError" style="color: red; display: none;"></p>

    </div>

    <!-- Admin Login Form -->
    <div id="adminLoginForm" style="display: none;">
      <form id="adminForm" method="POST" action="admin_traitement.php">
        <input type="text" id="Username" name="Username" placeholder="Username" required>
        <input type="password" id="Password" name="Password" placeholder="Password" required>
        <button type="submit">Login as Admin</button>
      </form>
      <p id="adminError" style="color: red; display: none;"></p>
    </div>
  </div>

  <!-- Circular Switch Button with QR Icon -->
  <button id="switchButton" onclick="toggleLoginForm()">
    <i class="fas fa-qrcode"></i>
  </button>

  <div id="qrcode"></div>

  <div class="social-icons">
    <a href="https://www.linkedin.com/company/ffpe-taroudannt/" target="_blank" class="fab fa-linkedin"></a>
    <a href="https://www.instagram.com/ffpe.taroudant?igsh=MTQ5NzB3N2FwOHJtcQ%3D%3D" target="_blank" class="fab fa-instagram"></a>
    <a href="https://www.youtube.com/@forumtaroudant2025" target="_blank" class="fab fa-youtube"></a>
    <a href="https://web.facebook.com/people/Forum-de-la-Formation-Professionnelle-et-de-lEmploi-Taroudannt/61574881191165/" target="_blank" class="fab fa-facebook"></a>
  </div>

</body>
</html>