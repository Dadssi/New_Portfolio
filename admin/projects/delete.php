<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$id = (int)($_GET['id'] ?? 0);
$proj = $conn->query("SELECT image FROM projects WHERE id=$id")->fetch_assoc();
if($proj){
    delete_image($proj['image'] ?? null);
    $conn->query("DELETE FROM projects WHERE id=$id");
}
header("Location: index.php");
exit;
