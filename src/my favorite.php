<?php session_start(); ?>
<?php
require_once ('../config.php');
require_once 'function.php';
function outputSingleGenre($row) {
    $link = '<div><a href="Photo.php?id=' . $row['ImageID'] . '">';
    $link .='<img src="../travel-images/medium/' .$row['PATH'] .'">' ;
    $link .= '</a></div><div>
        <h2>'.$row['Title'].'</h2>
          <!--描述-->
        <p>'.$row['Description'] .'</p>
        <a href="deleteFavor.php?id='.$row['ImageID'].'"><button onclick="alert(\'是否删除？\')">Delete</button></a>  <!--删除按钮-->
        <hr>
      </div>';
    return $link;
}
function outputGenres() {
    try {
        $sql = 'select * from travelimagefavor,travelimage where travelimage.ImageID=travelimagefavor.ImageID AND travelimagefavor.UID='.getUID();
        $result = pdo($sql);
        $link='';
        if($result->rowCount()>0){
        while ($row = $result->fetch()) {
                $link1=outputSingleGenre($row);
                $link.=$link1;

        }  echo $link;}
        else echo '<h2>还没有收藏，赶快去收藏一张吧！</h2>';
        $pdo = null;
    }catch (PDOException $e) {
        die( $e->getMessage() );
    }
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>我的收藏</title>
    <link rel="stylesheet" type="text/css" href="../css/my%20favorite.css">
</head>
<body>
    <!--导航栏-->
    <?php require_once ('header.php');
    Head2();
    ?>
    <!--标题-->
    <h1>My Favorite:</h1>
    <!--主体内容，采用grid布局-->
    <div class="content">
        <!--图片-->
       <?php outputGenres();?>

      <!--页码-->
      <div class="page">
      <!--  <a href="">首页</a>
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
    <div class="bottom">@19302010052@fudan.edu.cn</div>
    <!--返回顶部-->
    <div class="button">
         <a href="#top"><img src="../images/img/top.png" ></a>
    </div>
</body>
</html>