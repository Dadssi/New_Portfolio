<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
require_once "../includes/functions.php";

$id=(int)($_GET['id']??0);
$art=$conn->query("SELECT image FROM articles WHERE id=$id")->fetch_assoc();
if($art){
    delete_image($art['image'] ?? null);
    $conn->query("DELETE FROM articles WHERE id=$id");
}
header("Location: index.php");
exit;
