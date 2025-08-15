<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$result = $conn->query("SELECT id, title, image, created_at FROM projects ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="fr"><head>
<meta charset="UTF-8"><title>Projets - Admin</title>
<style>
body{font-family:Arial;padding:20px;background:#f6f6f6}
a.btn{background:#333;color:#fff;padding:8px 12px;text-decoration:none;border-radius:4px}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
img{height:40px}
.actions a{margin-right:6px}
</style></head><body>
<h1>Projets</h1>
<p><a class="btn" href="add.php">+ Ajouter un projet</a> <a class="btn" href="../dashboard.php">⟵ Dashboard</a></p>
<table>
<thead><tr><th>ID</th><th>Image</th><th>Titre</th><th>Créé le</th><th>Actions</th></tr></thead>
<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= (int)$row['id'] ?></td>
  <td><?php if($row['image']): ?><img src="/<?= e($row['image']) ?>" alt=""><?php endif; ?></td>
  <td><?= e($row['title']) ?></td>
  <td><?= e($row['created_at']) ?></td>
  <td class="actions">
    <a href="edit.php?id=<?= (int)$row['id'] ?>">Modifier</a>
    <a href="delete.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('Supprimer ce projet ?')">Supprimer</a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</body></html>
