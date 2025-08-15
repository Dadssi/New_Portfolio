<?php
require_once "../includes/auth.php";
require_once "../includes/config.php";
$id=(int)($_GET['id']??0);
if($id>0){
    $stmt=$conn->prepare("DELETE FROM comments WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}
header("Location: index.php");
exit;
