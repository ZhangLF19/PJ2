<?php require_once 'function.php';
session_start();

$sql = 'DELETE FROM travelimagefavor WHERE `UID` = ' .getUID(). ' and `ImageID` = ' . $_GET['id'];
 pdo($sql);
echo'删除成功';
echo '<meta http-equiv="refresh" content="1;url=my%20favorite.php">';
?>