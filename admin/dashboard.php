<?php
require_once "includes/auth.php";
require_once "includes/config.php";

// Récupération stats
$total_projects = $conn->query("SELECT COUNT(*) AS total FROM projects")->fetch_assoc()['total'];
$total_articles = $conn->query("SELECT COUNT(*) AS total FROM articles")->fetch_assoc()['total'];
$total_comments = $conn->query("SELECT COUNT(*) AS total FROM comments")->fetch_assoc()['total'];
$total_testimonials = $conn->query("SELECT COUNT(*) AS total FROM testimonials")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Admin</title>
    <link rel="stylesheet" href="../css/dashboard-style.css">
</head>
<body>
    <div class="dash-main-container">
        <aside class="dash-sidebar">
            <h2>Menu Admin</h2>
            <ul>
                <li><a href="index.php">Tableau de Bord</a></li>
                <li><a href="projects/index.php">Projets</a></li>
                <li><a href="blog/index.php">Blog</a></li>
                <li><a href="comments/index.php">Commentaires</a></li>
                <li><a href="testimonials/index.php">Testimonials</a></li>
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
                    <a class="button" href="projects/index.php">Gérer</a>
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

                <div class="card">
                    <h3><?php echo $total_testimonials; ?></h3>
                    <p>Testimonials</p>
                    <a class="button" href="testimonials/index.php">Gérer</a>
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
