<?php
session_start();
require_once('config.php');
function outputGenres() {
    $i=mt_rand(1,40);
    try {$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'select * from travelimage Order By ImageID';
        $result = $pdo->query($sql);
        $link='';
        while ($row = $result->fetch()) {
            if($row['ImageID']>$i){if($row['ImageID']<($i+6)){
                $link1=outputSingleGenre($row);
                $link.=$link1;
                }}

        }  echo $link;
        $pdo = null;
    }catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
/*
 Displays a single genre
*/
function outputSingleGenre($row) {
    $img = '<img src="travel-images/medium/' .$row['PATH'] .'">';
    $img = constructGenreLink($row['ImageID'], $img);
   return $img;
}
/*
  Constructs a link given the genre id and a label (which could
  be a name or even an image tag
*/
function constructGenreLink($id, $label) {
    $link = '<a href="src/Photo.php?id=' . $id . '">';
    $link .= $label;
    $link .= '</a>';
    return $link;
}


?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="./css/home.css">
    </head>
 <body>
   <!--导航栏-->
<?php require_once ('src/header.php');
Head1();
?>
   <!---->
    <div>
        <div id="bd">
            <div class="container">
                <div class="wrap" style="left: -1200px;">
                    <?php outputGenres(); ?>
                </div>
                <div class="buttons" >
                    <span class="on" onclick="skip(0)">1</span>
                    <span onclick="skip(1)">2</span>
                    <span onclick="skip(2)">3</span>
                    <span onclick="skip(3)">4</span>
                    <span onclick="skip(4)">5</span>
                </div>
                <a href="javascript:" class="arrow arrow_left" id="prev" onclick="prev()"><</a>
                <a href="javascript:" class="arrow arrow_right" id="next" onclick="nextPhoto()">></a>
            </div>
            <br>
        </div>
        <script src="JS/index.js"></script>
    </div>
   <!--主体内容，采用grid布局-->
    <div class="content">
<?php
try {$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'select * from travelimage Order By ImageID';
        $result = $pdo->query($sql);
        $i = mt_rand(1, 50);
        while ($row = $result->fetch()) {
            if($row['ImageID']>$i){
                if($row['ImageID']<($i+10)){
                $link=outputSingleGenre($row);
                echo '<div>';
                echo $link;
                echo "<br>";
                echo'<a>'.$row['Title'].'</a>';
                echo '</div>';
            }
}
        }
        $pdo = null;
    }catch (PDOException $e) {
        die( $e->getMessage() );
    }

?>

    </div>

   <!--回到顶部，刷新按钮-->
    <div class="button">
        <a href="index.php"><img src="./images/img/refresh.png" onclick="alert('已刷新')"></a>
        <a href="#top"><img src="./images/img/top.png" ></a>
    </div>
   <footer><div>
       <a href=" "> 使用条款</a><br>
       <a href=" "> 隐私保护</a><br>
       <a href=" "> 联系我们</a><br>
       <a href=" "> 关于</a>
   </div>
       <aside class="bottom">
           <img src="./images/img/二维码.jpg">
       </aside>

   </footer>
  </body>


