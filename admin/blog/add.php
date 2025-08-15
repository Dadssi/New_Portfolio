<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$err="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title  = trim($_POST['title'] ?? "");
    $content= trim($_POST['content'] ?? "");
    $writer = "Mohamed Abdelhak Dadssi"; // constant
    $domain = trim($_POST['domain'] ?? "");
    $tags   = trim($_POST['tags'] ?? "");
    $img    = upload_image($_FILES['image'] ?? [], "articles");

    if($title==="" || $content===""){ $err="Titre et contenu requis."; }
    else {
        $stmt=$conn->prepare("INSERT INTO articles (title, content, image, writer, domain, tags) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $title, $content, $img, $writer, $domain, $tags);
        if($stmt->execute()){ header("Location: index.php"); exit; }
        else $err="Erreur enregistrement.";
    }
}
?>
<!DOCTYPE html><html lang="fr"><head>
<meta charset="UTF-8"><title>Ajouter un article</title>
<style>body{font-family:Arial;padding:20px}input,textarea{width:100%;padding:10px;margin:8px 0}</style>
</head><body>
<h1>Ajouter un article</h1>
<?php if($err) echo "<p style='color:red'>".e($err)."</p>"; ?>
<form method="post" enctype="multipart/form-data">
  <label>Titre</label>
  <input type="text" name="title" required>
  <label>Domaine</label>
  <input type="text" name="domain" placeholder="Ex: Éducation, Tech, Design">
  <label>Tags (séparés par des virgules)</label>
  <input type="text" name="tags" placeholder="orientation, concours, écoles">
  <label>Image</label>
  <input type="file" name="image" accept="image/*">
  <label>Contenu</label>
  <textarea name="content" rows="10" required></textarea>
  <button type="submit">Publier</button>
  <a href="index.php">Annuler</a>
</form>
</body></html>
