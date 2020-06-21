<?php
header("Content-Type:text/html;charset=utf-8");
?>
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>修改</title>
    <link rel="stylesheet" type="text/css" href="../css/upload.css">
</head>
<body>
<!--导航栏-->
<?php require_once ('header.php');
Head2();
?>
<?php
require_once ("../config.php");
require_once 'function.php';
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
$sql = "select * from travelimage where ImageID=".$_GET['id'];
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($result);

?>
<!--标题-->
<h2>我的照片</h2>

<!--grid布局-->
<div align="center">
  <?php echo' <form action="update.php?id='.$row['ImageID'].'" method="post" enctype="multipart/form-data">'?>
        <div class="content">
            <div class="picture" id="imgPreview">
                <?php echo '<img src="../travel-images/medium/'.$row['PATH'].'"> '?>
            </div>
            <div>
                <h3>Title :</h3>
                <input type="text" name="title">  <!--输入照片的标题-->
            </div>
            <div>
                <h3>Theme :</h3>
                <select class="filter" id="filterByContent" name="theme">
                    <option value="" disabled selected hidden>选择主题</option>
                    <option value="scenery">Scenery</option>
                    <option value="city">City</option>
                    <option value="people">People</option>
                    <option value="animal">Animal</option>
                    <option value="building">Building</option>
                    <option value="wonder">Wonder</option>
                    <option value="other">Other</option>
                </select>  <!--输入照片主题-->
            </div>
            <div>
                <h3>Country :</h3>
                <select class="filter" id="filterByCountry" name="country" onchange="changeSelect()">
                    <option value="" disabled selected hidden>选择国家</option>
                    <?php
                    $sql = "select CountryName from geocountries order by CountryName";
                    $result = mysqli_query($connection,$sql);
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<option value='". $row["CountryName"] ."'>" . $row["CountryName"] ."</option>";
                    }
                    ?>
                </select> <!--照片中国家-->
            </div>
            <div>
                <h3>City :</h3>
                <select class="filter" id="filterByCity" name="city">
                    <option value="" disabled selected hidden>选择城市</option>
                    <?php
                    $sql = "select geocities.AsciiName,geocountries.CountryName,count(*) as count from geocities,geocountries,travelimage
                    where geocities.CountryCodeISO = geocountries.ISO and travelimage.CityCode = geocities.GeoNameID group by geocities.GeoNameID order by count desc";
                    $result = mysqli_query($connection,$sql);
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<option value='" . $row["AsciiName"] . "' name='" . $row["CountryName"] . "'>" . $row["AsciiName"] . "</option>";
                    }
                    if (!is_null($result) & !is_bool($result)){
                        mysqli_free_result($result);
                    }
                    ?>
                </select> <!--照片城市-->
            </div>
        </div>
        <!--描述输入框-->
        <div class="des">
            <h3>Description :</h3>
            <input type="text" name="description">
        </div>
        <!--两个按钮-->
    <br>
        <div class="update">
            <div>
                <!--确认上传--> <input type="submit" name="sub" value="修改">
            </div>
        </div>
    </form>
</div>




