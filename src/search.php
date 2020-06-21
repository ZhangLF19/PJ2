<?php
require_once '../config.php';
function f()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `travelimage` WHERE Title OR Description LIKE '%".$_POST['title'].$_POST['description']."%'";
        $result = $pdo->query($sql);
        $link='';
        while ($row = $result->fetch()) {
            $link1 = outputSingleGenre($row);
            $link .= $link1;
        }
        echo $link;
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());

    }
}

function outputSingleGenre($row)
{
    $img = '<img src="../travel-images/medium/' . $row['PATH'] . '">';
    $img = constructGenreLink($row, $img);
    return $img;
}

/*
  Constructs a link given the genre id and a label (which could
  be a name or even an image tag
*/
function constructGenreLink($row, $label)
{
    $link = '<div><a href="Photo.php?id=' . $row['ImageID'] . '">';
    $link .= $label;
    $link .= '</a></div><div>
             <h2>'.$row['Title'].'</h2>
             <p>'. $row['Description'] .'</p>

             <hr>
         </div>';
    return $link;
}

?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="../css/search.css">
</head>
<body>
  <!--导航栏-->
  <?php require_once ('header.php');require_once '../config.php';
     Head2();
  ?>


  <!--搜索部分-->
  <div class="search">
      <form method="post" action="search.php">
         <h2>Search</h2>
         <input type="radio" name="searchlimit" checked="checked">Search by title <br><br>
         <input type="text"  name="title"><br><br>
         <input type="radio" name="searchlimit">Search by description <br><br>
         <textarea  name="description" cols="160" rows="10"></textarea><br><br>
         <button onclick="alert('搜索完成。')">Filter</button>
      </form>
  </div>
  <!--结果部分-->

  <div class="result">
         <h2>搜索结果</h2>
         <div class="content">
             <!--图片-->
         <?php if(isset($_POST['title'])){
              f();}
         ?>
       </div>
      <!--页码-->
         <div class="page">

     </div>
 </div>
  <!--页脚-->
  <div class="bottom">@19302010052@fudan.edu.cn</div>
  <!--回到顶部-->
  <div class="button">
      <a href="search.php"><img src="../images/img/refresh.png" ></a>
     <a href="#top"><img src="../images/img/top.png" ></a>
  </div>
</body>
</html>

