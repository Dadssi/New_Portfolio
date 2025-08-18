<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$err="";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name  = trim($_POST['name'] ?? "");
    $role = trim($_POST['role'] ?? "");
    $content = trim($_POST['content'] ?? "");
    $picture = upload_image($_FILES['picture'] ?? [], "testimonials");

    if($name==="" || $content===""){
        $err = "Nom et contenu requis.";
    } else {
        $stmt = $conn->prepare("INSERT INTO testimonials (name, role, content, picture) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $role, $content, $picture);
        
        if($stmt->execute()){
            header("Location: index.php");
            exit;
        } else {
            $err = "Erreur enregistrement.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Add Testimonials</title>
    <style>
      body{
        font-family:Arial;
        padding:20px
      }
      input,textarea{
        width:100%;
        padding:10px;
        margin:8px 0
      }
    </style>
  </head>
  <body>
    <h1>Add Testimonial</h1>
    <?php if($err) echo "<p style='color:red'>".e($err)."</p>"; ?>
    <form method="post" enctype="multipart/form-data">
      <label for="name">Name</label>
      <input type="text" name="name" required>
      <label for="role">Role</label>
      <input type="text" name="role">
      <label for="picture">Picture</label>
      <input type="file" name="picture" accept="image/*">
      <label for="content">Content</label>
      <textarea id="content" name="content" required>
        ...
      </textarea>
      <button type="submit">Add</button>
      <a href="index.php">Annuler</a>
    </form>
  </body>
</html>
