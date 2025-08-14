<?php
session_start();
require_once "includes/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = md5(trim($_POST["password"])); // Chiffrage MD5 (simple pour l’exemple)

    $sql = "SELECT * FROM admin_users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_username"] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Nom d’utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    body { 
        font-family: Arial; 
        background: #f4f4f4; 
    }
    
    .login-box { 
        /* The key properties for the glass effect */
        background: rgba(255, 255, 255, 0.2); /* Semi-transparent white */
        backdrop-filter: blur(10px); /* The blurring effect */
        border: 1px solid rgba(255, 255, 255, 0.3); /* A subtle border */
        border-radius: 15px; /* Softer corners */
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); /* Add a shadow for depth */

        /* Positioning and sizing */
        width: 300px; 
        margin: auto; /* This centers the box horizontally */
        padding: 20px; 
        color: #fff; /* White text for better readability against the dark background */
        text-align: center;
    }

    /* Style the heading inside the box for better contrast */
    .login-box h2 {
        color: #fff;
    }

    /* Style the inputs and button for the new theme */
    input { 
        width: calc(100% - 20px); /* Adjust width for padding */
        padding: 10px; 
        margin: 8px 0; 
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        border-radius: 5px;
    }

    input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    button { 
        background: #333; 
        color: #fff; 
        padding: 10px; 
        border: none; 
        width: 100%; 
        cursor: pointer; 
        border-radius: 5px;
        transition: background 0.3s;
    }

    button:hover { 
        background: #555; 
    }

    .error { 
        color: #ffcccc; /* Lighter red for visibility */
        font-size: 14px; 
    }

    /* Additional styles for the centering and background */
    .intro.bg-image {
        position: relative;
        height: 100vh; /* Make sure the container fills the viewport height */
        display: flex;
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
    }

    /* Remove previous absolute positioning on the login-box if any */
    .intro-content {
        position: static;
    }

        /* body { font-family: Arial; background: #f4f4f4; }
        .login-box { width: 300px; margin: 80px auto; background: #fff; padding: 20px; border-radius: 5px; }
        input { width: 100%; padding: 10px; margin: 8px 0; }
        button { background: #333; color: #fff; padding: 10px; border: none; width: 100%; cursor: pointer; }
        button:hover { background: #555; }
        .error { color: red; font-size: 14px; } */
    </style>
</head>
<body>
     <!--/ Intro Skew Star /-->
  <!-- <div id="home" class="intro route bg-image" style="background-image: url(../img/intro-bg.jpg)">
    <div class="overlay-itro"></div>
    <div class="intro-content display-table">
      <div class="table-cell">
        <div class="container">
        
          <h1 class="intro-title mb-4"></h1>
          <p class="intro-subtitle"><span class="text-slider-items">Full stack Web Developer, Graphic Designer, Digital Marketer ,Content Creator</span><strong class="text-slider"></strong></p>
        </div>
      </div>
    </div>
  </div> -->
  <!--/ Intro Skew End /-->

  <!-- ------------------------------------------------- -->
   <div id="home" class="intro route bg-image" style="background-image: url(../img/intro-bg.jpg)">
    <div class="overlay-itro"></div>
    <div class="intro-content display-table">
        <div class="table-cell">
            <div class="container">
                <h1 class="intro-title mb-4"></h1>
                <p class="intro-subtitle"><span class="text-slider-items">Full stack Web Developer, Graphic Designer, Digital Marketer ,Content Creator</span><strong class="text-slider"></strong></p>
            </div>

            <div class="login-box">
                <h2>Connexion Admin</h2>
                <?php if($error) echo "<p class='error'>$error</p>"; ?>
                <form method="POST">
                    <input type="text" name="username" placeholder="Nom d’utilisateur" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit">Se connecter</button>
                </form>
            </div>

        </div>
    </div>
</div>
  <!-- ------------------------------------------------- -->
    
</body>
</html>
