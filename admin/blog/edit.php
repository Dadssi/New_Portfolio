<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$id=(int)($_GET['id']??0);
$art=$conn->query("SELECT * FROM articles WHERE id=$id")->fetch_assoc();
if(!$art) die("Article introuvable.");

$err="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title  = trim($_POST['title'] ?? "");
    $content= trim($_POST['content'] ?? "");
    $domain = trim($_POST['domain'] ?? "");
    $tags   = trim($_POST['tags'] ?? "");
    $newImg = upload_image($_FILES['image'] ?? [], "articles");
    $img    = $art['image'];

    if($newImg){ delete_image($img); $img = $newImg; }

    if($title===""||$content===""){ $err="Titre et contenu requis."; }
    else{
        $stmt=$conn->prepare("UPDATE articles SET title=?, content=?, image=?, domain=?, tags=? WHERE id=?");
        $stmt->bind_param("sssssi", $title, $content, $img, $domain, $tags, $id);
        if($stmt->execute()){ header("Location: index.php"); exit; }
        else $err="Erreur mise à jour.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <script src="https://cdn.tiny.cloud/1/j1pxkrpsabc6gh3n0iqnwm6r8i1ji52k5abaa4pfzvix6ik1/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <title>Modifier un article</title>
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
      img{
        max-height:70px;
        display:block;
        margin:8px 0
      }
    </style>
  </head>
  <body>
    <h1>Modifier l’article #<?= (int)$art['id'] ?></h1>
    <?php if($err) echo "<p style='color:red'>".e($err)."</p>"; ?>
    <form method="post" enctype="multipart/form-data">
      <label>Titre</label>
      <input type="text" name="title" value="<?= e($art['title']) ?>" required>
      <label>Domaine</label>
      <input type="text" name="domain" value="<?= e($art['domain']) ?>">
      <label>Tags</label>
      <input type="text" name="tags" value="<?= e($art['tags']) ?>">
      <label>Image actuelle</label>
      <?php if($art['image']): ?><img src="/<?= e($art['image']) ?>" alt=""><?php endif; ?>
      <label>Nouvelle image (facultatif)</label>
      <input type="file" name="image" accept="image/*">
      <label>Contenu</label>
      <script>
        tinymce.init({
          selector: 'textarea',
          plugins: [
            // Core editing features
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
            // Your account includes a free trial of TinyMCE premium features
            // Try the most popular premium features until Aug 30, 2025:
            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
          ],
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          tinycomments_mode: 'embedded',
          tinycomments_author: 'Author name',
          mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
          ],
          ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
          uploadcare_public_key: '5c4e8e7a4dcd5f4c725a',
        });
      </script>
      <textarea name="content" rows="10" required><?= e($art['content']) ?></textarea>
      <button type="submit">Mettre à jour</button>
      <a href="index.php">Annuler</a>
    </form>
  </body>
</html>
