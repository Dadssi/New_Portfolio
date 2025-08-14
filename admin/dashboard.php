<?php
require_once "includes/auth.php";
require_once "includes/config.php";

// Récupération stats
$total_projects = $conn->query("SELECT COUNT(*) AS total FROM projects")->fetch_assoc()['total'];
$total_articles = $conn->query("SELECT COUNT(*) AS total FROM articles")->fetch_assoc()['total'];
$total_comments = $conn->query("SELECT COUNT(*) AS total FROM comments")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        .dashboard { max-width: 800px; margin: auto; }
        .card { background: #fff; padding: 20px; margin: 10px; border-radius: 5px; display: inline-block; width: 30%; text-align: center; }
        .card h3 { margin: 0; }
        a.button { display: block; padding: 10px; margin-top: 10px; background: #333; color: #fff; text-decoration: none; border-radius: 3px; }
        a.button:hover { background: #555; }
        /* ------------------------------------------------- */
        .dash-main-container { 
            display: flex;
            width: 100vw 
            height: 100vh;
            background: #000;
            color: #fff;
        }
        .dash-sidebar { 
            width: 20%;  
            padding: 20px; 
            /* box-shadow: 2px 0 5px rgba(0,0,0,0.5);  */

        }
        .dash-sidebar ul{
            list-style: none;
            padding: 0; 
        }
        .dash-sidebar ul li{ 
            border-bottom: 1px solid #444;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .dash-sidebar ul li a{
            text-decoration: none;
            padding: 0; 
        }
        .dash-content{
            display:flex;
            flex-direction: column;
            width: 80%;
            padding: 20px;

        }
        /* ------------------------------------------------- */
    </style>
</head>
<body>
    <div class="dash-main-container">
        <aside class="dash-sidebar">
            <h2>Menu Admin</h2>
            <ul>
                <li><a href="index.php">Tableau de Bord</a></li>
                <li><a href="projets/index.php">Projets</a></li>
                <li><a href="blog/index.php">Blog</a></li>
                <li><a href="comments/index.php">Commentaires</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </aside>
        <div class="dash-content">
            <div class="welcome">
                <h1>Bienvenue, <?php echo $_SESSION['admin_username']; ?> 👋</h1>
                <p>Voici un aperçu de vos contenus :</p>
            </div>
            <div class="statistics">
                <div class="card">
                    <h3><?php echo $total_projects; ?></h3>
                    <p>Projets Réalisés</p>
                    <a class="button" href="projets/index.php">Gérer</a>
                </div>

                <div class="card">
                    <h3><?php echo $total_articles; ?></h3>
                    <p>Articles de Blog</p>
                    <a class="button" href="blog/index.php">Gérer</a>
                </div>

                <div class="card">
                    <h3><?php echo $total_comments; ?></h3>
                    <p>Commentaires</p>
                    <a class="button" href="comments/index.php">Gérer</a>
                </div>
            </div>
            <div class="projects">
            </div>

        </div>
    </div>












    <div class="dashboard">
        <h1>Bienvenue, <?php echo $_SESSION['admin_username']; ?> 👋</h1>
        <p>Voici un aperçu de vos contenus :</p>

        <div class="card">
            <h3><?php echo $total_projects; ?></h3>
            <p>Projets Réalisés</p>
            <a class="button" href="projets/index.php">Gérer</a>
        </div>

        <div class="card">
            <h3><?php echo $total_articles; ?></h3>
            <p>Articles de Blog</p>
            <a class="button" href="blog/index.php">Gérer</a>
        </div>

        <div class="card">
            <h3><?php echo $total_comments; ?></h3>
            <p>Commentaires</p>
            <a class="button" href="comments/index.php">Gérer</a>
        </div>

        <p><a class="button" href="logout.php">Déconnexion</a></p>
    </div>
</body>
</html>
