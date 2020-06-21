
<?php session_start();
require_once('../config.php');
require_once 'function.php';

/*
 Displays a list of genres
*/
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'select * from travelimage where ImageID=:id';

    $id =  $_GET['id'];
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
}
catch (PDOException $e) {
    die( $e->getMessage() );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>图片详情</title>
    <link rel="stylesheet" type="text/css" href="../css/photo.css">
</head>
<body>
   <!--导航栏-->
   <?php require_once ('header.php');
   Head2();
   ?>
   <!--图片名or主题-->
   <h1><?php echo $row['Title']?></h1>
   <!--主体内容-->
   <div class="content">
      <div class="big"><img src="../travel-images/medium/<?php echo $row['PATH']?>"></div>
       <!--照片的详情-->
      <div class="detail">
        <h2><small style="font-size: 15px"> 作者：<?php echo getUserNameByUID($row['UID']);?></small></h2>
        <p>
            Content：<?php echo $row['Content'];?><br><br>
            Country:<?php echo getCountryByCountryCode($row['CountryCodeISO'])?><br><br>
            City:<?php echo getCityByCityCode($row['CityCode'])?> <br><br>
            like number:  <?php echo mt_rand(1,1000)?>. <br>
        </p>
        <button id="like" onclick='<?php enFavor(getUID(),$row['ImageID'])?>'><img src="../images/img/1.jpg">收藏</button>
      </div>
      <div class="article">
         <?php echo $row['Description']?>
      </div>
   </div>
   <!--页脚-->
   <div class="bottom">@19302010052@fudan.edu.cn</div>
</body>
</html>