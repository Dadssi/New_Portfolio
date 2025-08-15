<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$id = (int)($_GET['id'] ?? 0);
$proj = $conn->query("SELECT * FROM projects WHERE id=$id")->fetch_assoc();
if(!$proj){ die("Projet introuvable."); }

$err = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title = trim($_POST['title'] ?? "");
    $description = trim($_POST['description'] ?? "");
    $newImg = upload_image($_FILES['image'] ?? []);
    $imgPath = $proj['image'];

    if ($newImg) {
        delete_image($imgPath);
        $imgPath = $newImg;
    }

    if($title===""||$description===""){ $err="Titre et description requis."; }
    else {
        $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $description, $imgPath, $id);
        if($stmt->execute()){ header("Location: index.php"); exit; }
        else $err="Erreur mise à jour.";
    }
}
?>
<!DOCTYPE html><html lang="fr"><head>
<meta charset="UTF-8"><title>Modifier un projet</title>
<style>body{font-family:Arial;padding:20px}input,textarea{width:100%;padding:10px;margin:8px 0}img{max-height:70px;display:block;margin:8px 0}</style>
</head><body>
<h1>Modifier le projet #<?= (int)$proj['id'] ?></h1>
<?php if($err) echo "<p style='color:red'>".e($err)."</p>"; ?>
<form method="post" enctype="multipart/form-data">
  <label>Titre</label>
  <input type="text" name="title" value="<?= e($proj['title']) ?>" required>
  <label>Description</label>
  <textarea name="description" rows="6" required><?= e($proj['description']) ?></textarea>
  <label>Image actuelle</label>
  <?php if($proj['image']): ?><img src="/<?= e($proj['image']) ?>" alt=""><?php endif; ?>
  <label>Nouvelle image (facultatif)</label>
  <input type="file" name="image" accept="image/*">
  <button type="submit">Mettre à jour</button>
  <a href="index.php">Annuler</a>
</form>
</body></html>
