<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

// Jointure pour afficher le titre de l'article
$sql = "SELECT c.id, c.article_id, c.name, c.comment, c.created_at, a.title
        FROM comments c
        JOIN articles a ON a.id = c.article_id
        ORDER BY c.id DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html><html lang="fr"><head>
<meta charset="UTF-8"><title>Commentaires - Admin</title>
<style>
body{font-family:Arial;padding:20px;background:#f6f6f6}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{padding:10px;border-bottom:1px solid #eee;text-align:left;vertical-align:top}
a.btn{background:#333;color:#fff;padding:8px 12px;text-decoration:none;border-radius:4px}
small{color:#666}
</style></head><body>
<h1>Commentaires</h1>
<p><a class="btn" href="../dashboard.php">⟵ Dashboard</a></p>
<table>
<thead><tr><th>ID</th><th>Article</th><th>Auteur</th><th>Commentaire</th><th>Date</th><th>Actions</th></tr></thead>
<tbody>
<?php while($c=$res->fetch_assoc()): ?>
<tr>
  <td><?= (int)$c['id'] ?></td>
  <td><?= e($c['title']) ?> <br><small>#<?= (int)$c['article_id'] ?></small></td>
  <td><?= e($c['name']) ?></td>
  <td><?= nl2br(e($c['comment'])) ?></td>
  <td><?= e($c['created_at']) ?></td>
  <td><a href="delete.php?id=<?= (int)$c['id'] ?>" onclick="return confirm('Supprimer ce commentaire ?')">Supprimer</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</body></html>
