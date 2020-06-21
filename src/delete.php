<?php
session_start();
require_once '../config.php';
require_once 'function.php';
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql='delete from travelimage where ImageID=:id AND UID='.getUID();
    $id =  $_GET['id'];
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    echo'删除成功';

    echo '<meta http-equiv="refresh" content="1;url=myPhoto.php">';
}catch (PDOException $e) {
    die( $e->getMessage() );

}
?>