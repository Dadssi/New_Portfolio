<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../../includes/header.php';


// ========================================
$article_id = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = $_GET['id'];
}

if ($article_id) {
    $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
  }

// ========================================


?>

  <div class="sous-nav">      
  </div>
  <div class="sb-container">
    <!-- Content -->
    <div class="content">
      
      <img src="../../<?php echo $article['image']; ?>" alt="Image article" class="cover">
      <h1><?php echo $article['title']; ?></h1>
      <p class="meta">Publié par <strong>Mohamed Abdelhak Dadssi</strong> | <?php echo $article['created_at']; ?> | Catégorie : <?php echo $article['domain']; ?></p>

      <div class="article-content">
        <?php echo $article['content']; ?>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <h3>Derniers articles</h3>
      <ul>
        <li>Emerisign et formulaire</li>
        <li>Concours pratiques</li>
        <li>Écoles et instituts</li>
      </ul>

      <h3>Catégories</h3>
      <ul>
        <li>Orientation études</li>
        <li>Concours</li>
        <li>Formation digitale</li>
      </ul>

      <!-- <h3>Suivez-nous</h3>
      <div class="sb-socials">
        <a href="#">🐦</a>
        <a href="#">📸</a>
        <a href="#">🟧</a>
      </div> -->

      <div class="sb-testimonial">
        “Les conseils et astuces partagés ici m'ont réellement aidé à mieux m’orienter dans mes choix académiques.”<br><br>— Atmed
      </div>
    </div>
  </div>

</body>
<?php 
require_once __DIR__ . '/../../includes/footer.php';
?>
</html>

