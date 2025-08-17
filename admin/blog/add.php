<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$err="";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title  = trim($_POST['title'] ?? "");
    $content= trim($_POST['content'] ?? "");
    $writer = "Mohamed Abdelhak Dadssi"; // constant
    $domain = trim($_POST['domain'] ?? "");
    $tags   = trim($_POST['tags'] ?? "");
    $img    = upload_image($_FILES['image'] ?? [], "articles");
    $meta   = trim($_POST['meta-description'] ?? "");

    if($title==="" || $content==="" || $meta==="" || $domain===""){
        $err = "Titre, contenu, meta description et domaine requis.";
    } else {
        $stmt = $conn->prepare("INSERT INTO articles (title, content, image, writer, domain, tags, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $title, $content, $img, $writer, $domain, $tags, $meta);
        
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
    <!-- TinyMCE CDN -->
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/j1pxkrpsabc6gh3n0iqnwm6r8i1ji52k5abaa4pfzvix6ik1/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <title>Ajouter un article</title>
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
    <h1>Ajouter un article</h1>
    <?php if($err) echo "<p style='color:red'>".e($err)."</p>"; ?>
    <form method="post" enctype="multipart/form-data">
      <label>Titre</label>
      <input type="text" name="title" required>
      <label>Meta Description</label>
      <input type="text" name="meta-description" required>
      <label>Domaine</label>
      <input type="text" name="domain" placeholder="Ex: Éducation, Tech, Design">
      <label>Tags (séparés par des virgules)</label>
      <input type="text" name="tags" placeholder="orientation, concours, écoles">
      <label>Image</label>
      <input type="file" name="image" accept="image/*">
      <label for="content">Contenu</label>
      <!-- <textarea name="content" id="content"><?php echo htmlspecialchars($content ?? ''); ?></textarea> -->
      <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
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
      <textarea id="content" name="content" required>
        ...
      </textarea>
      <button type="submit">Publier</button>
      <a href="index.php">Annuler</a>
    </form>
  </body>
</html>
