<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$msg = ""; $err = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? "");
    $description = trim($_POST['description'] ?? "");
    $imgPath = upload_image($_FILES['image'] ?? []);

    if ($title === "" || $description === "") {
        $err = "Titre et description sont requis.";
    } else {
        $stmt = $conn->prepare("INSERT INTO projects (title, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $imgPath);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else $err = "Erreur enregistrement.";
    }
}
?>
<!DOCTYPE html><html lang="fr"><head>
<meta charset="UTF-8"><title>Ajouter un projet</title>
<style>body{font-family:Arial;padding:20px}input,textarea{width:100%;padding:10px;margin:8px 0}</style>
</head><body>
<h1>Ajouter un projet</h1>
<?php if($err) echo "<p style='color:red'>".e($err)."</p>"; ?>
<form method="post" enctype="multipart/form-data">
  <label>Titre</label>
  <input type="text" name="title" required>
  <label>Description</label>
  <textarea name="description" rows="6" required></textarea>
  <label>Image (jpg/png/gif/webp, max 5MB)</label>
  <input type="file" name="image" accept="image/*">
  <button type="submit">Enregistrer</button>
  <a href="index.php">Annuler</a>
</form>
</body></html>
