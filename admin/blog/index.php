<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$res = $conn->query("SELECT id, title, image, writer, domain, tags, meta_description, created_at FROM articles ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8"><title>Articles - Admin</title>
    <style>
      body{font-family:Arial;padding:20px;background:#f6f6f6}
      a.btn{background:#333;color:#fff;padding:8px 12px;text-decoration:none;border-radius:4px}
      table{width:100%;border-collapse:collapse;background:#fff}
      th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
      img{height:40px}
    </style>
  </head>
  <body>
    <h1>Articles</h1>
    <p>
      <a class="btn" href="add.php">+ Ajouter un article</a>
      <a class="btn" href="../dashboard.php">⟵ Dashboard</a>
    </p>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Titre</th>
          <th>Mate Description</th>
          <th>Auteur</th>
          <th>Domaine</th>
          <th>Tags</th>
          <th>Créé le</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php while($a = $res->fetch_assoc()): ?>
      <tr>
        <td><?= (int)$a['id'] ?></td>
        <td><?php if($a['image']): ?><img src="/<?= e($a['image']) ?>" alt=""><?php endif; ?></td>
        <td><?= e($a['title']) ?></td>
        <td><?= e($a['meta_description']) ?></td>
        <td><?= e($a['writer']) ?></td>
        <td><?= e($a['domain']) ?></td>
        <td><?= e($a['tags']) ?></td>
        <td><?= e($a['created_at']) ?></td>
        <td>
          <a href="edit.php?id=<?= (int)$a['id'] ?>">Modifier</a> |
          <a href="delete.php?id=<?= (int)$a['id'] ?>" onclick="return confirm('Supprimer cet article ?')">Supprimer</a>
        </td>
      </tr>
<?php endwhile; ?>
</tbody>
</table>
</body></html>
