<?php
require_once '../config.php';
require_once 'function.php';
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql1='select * from traveluser order by UID';
$result=$pdo->query($sql1);
while ($row=$result->fetch()){
    $sql=' UPDATE traveluser set Pass="'.hash1($row['UserName'],$row['Pass']).'" where UID='.$row['UID'];
    $pdo->query($sql);
}
$pdo=null;
?>