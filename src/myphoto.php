<?php session_start();
require_once('../config.php');
require_once 'function.php';
function outputGenres() {

    try {
        $sql='select * from travelimage where UID='.getUID();
        $result=pdo($sql);
        $link='';
        if($result->rowCount()>0){
        while ($row = $result->fetch()) {

                $link1=outputSingleGenre($row);
                $link.=$link1;


        }  echo $link;}
        else echo '<h2>还没有上传过，快去上传一张吧！<a href="upload.php">GO!</a></h2>';
        $pdo = null;
    }catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
/*
 Displays a single genre
*/
function outputSingleGenre($row) {
    $img = '<img src="../travel-images/medium/' .$row['PATH'] .'">';
    $img = constructGenreLink($row, $img);
    return $img;
}
/*
  Constructs a link given the genre id and a label (which could
  be a name or even an image tag
*/
function constructGenreLink($row, $label) {
    $link = '<div><a href="Photo.php?id=' .$row['ImageID'] . '">';
    $link .= $label;
    $link .= '</a></div>';
    $link.=' <div>
           <h2>'.$row['Title'].'</h2>
           <!--描述-->
           <p>'.$row['Description'].'</p><a href="Modif.php?id='.$row['ImageID'].'"><button>Modify</button></a>
           <a href="delete.php?id='.$row['ImageID'].'"><button onclick="alert(\'Be sure to delete your photo!\')">Delete</button></a>
           <hr>
       </div>';
    return $link;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>我的照片</title>
    <link rel="stylesheet" type="text/css" href="../css/my%20photo.css">
</head>
<body>
   <!--导航栏-->
   <?php require_once ('header.php');
   Head2();
   ?>
   <!--标题-->
   <h1>My Photograph</h1>
   <!--主体内容，grid布局-->
   <div class="content">
       <!--图片-->
      <?php outputGenres();?>
       <!--页码-->
       <div class="page">
         <!--    <a href="">首页</a>
             <a href="">上一页</a>
             <a href="">1</a>
             <a href="">2</a>
             <a href="">3</a>
             <a href="">4</a>
             <a href="">5</a>
             <a href="">下一页</a>
             <a href="">末页</a>-->
       </div>
   </div>
   <!--页脚-->
   <div class="bottom">@19302010052@fudan.edu.cn</div>  <!--邮箱-->
   <!--回到顶部-->
   <div class="button">
       <a href="#top"><img src="../images/img/top.png" ></a>
   </div>
</body>
</html>