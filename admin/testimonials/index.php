<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$res = $conn->query("SELECT id, name, role, content, picture, created_at FROM testimonials ORDER BY id DESC");
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
        <h1>Testimonials</h1>
        <p>
            <a class="btn" href="add.php">+ Add Testimonial</a>
            <a class="btn" href="../dashboard.php">⟵ Dashboard</a>
        </p>
        <table>
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Content</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($a = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php if($a['picture']): ?><img src="/<?= e($a['picture']) ?>" alt=""><?php endif; ?></td>
                    <td><?= (int)$a['id'] ?></td>
                    <td><?= e($a['name']) ?></td>
                    <td><?= e($a['role']) ?></td>
                    <td><?= e($a['content']) ?></td>
                    <td><?= e($a['created_at']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= (int)$a['id'] ?>">Modify</a> |
                        <a href="delete.php?id=<?= (int)$a['id'] ?>" onclick="return confirm('Supprimer cet article ?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </body>
</html>
