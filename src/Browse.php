<?php
session_start();
require_once 'header.php';
?>
    <!DOCTYPE html>
    <html lang="ch">
    <head>
        <meta charset="UTF-8">
        <title>浏览</title>
        <link rel="stylesheet" type="text/css" href="../css/browse.css">
        <link rel="stylesheet" type="text/css" href="../css/navigation.css">
    </head>
    <body>
    <?php Head2();?>
    <!--边栏包含标题搜索,热门筛选(同为hotFilter类)-->
    <aside class="hotFilterSection">
        <!--标题检索类,包含输入框与搜索按钮-->
        <div class="hotFilter" id="searchByTitle">
            <p>标题检索</p>
            <form name="searchByTitle" action="Browse.php?page=1" method="post">
                <label for="searchInput"><input class="hotFilter" name="title" id="searchInput" type="text" placeholder="仅支持英文标题" pattern="[a-zA-Z ]+"></label>
                <input type="submit" id="searchBtn" value="">
            </form>
        </div>
        <!--热门筛选类,用列表列出多个含超链接的p元素-->
        <div class="hotFilter" id="hotContent">
            <p>Hot Content</p>
            <ul class="hotContents">
                <li><a href="Browse.php?hotContent=scenery&page=1">Scenery</a></li>
                <li><a href="Browse.php?hotContent=city&page=1">City</a></li>
                <li><a href="Browse.php?hotContent=people&page=1">People</a></li>
                <li><a href="Browse.php?hotContent=animal&page=1">Animal</a></li>
                <li><a href="Browse.php?hotContent=building&page=1">Building</a></li>
                <li><a href="Browse.php?hotContent=wonder&page=1">Wonder</a></li>
            </ul>
        </div>
        <div class="hotFilter" id="hotCountry">
            <ul class="hotCountries">
                <p>Hot Country</p>
                <?php
                require_once ("../config.php");
                $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
                $sql = "select geocountries.CountryName,count(*) as count from travelimage,geocountries where geocountries.ISO = travelimage.CountryCodeISO 
                   group by geocountries.CountryName order by count desc limit 4";
                $result = mysqli_query($connection,$sql);
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<li><a href='Browse.php?hotCountry=" . $row["CountryName"]  ."&page=1'>" . $row["CountryName"] . "</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class="hotFilter" id="hotCity">
            <ul class="hotCities">
                <p>Hot City</p>
                <?php
                require_once ("../config.php");
                $sql = "select geocities.AsciiName,count(*) as count from travelimage,geocities where geocities.GeoNameID = travelimage.CityCode
                group by geocities.AsciiName order by count desc limit 4";
                $result = mysqli_query($connection,$sql);
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<li><a href='Browse.php?hotCity=" . $row["AsciiName"]  ."&page=1'>" . $row["AsciiName"] . "</a></li>";
                }
                ?>
            </ul>
        </div>
    </aside>
    <!--section包含筛选选项与筛选结果-->
    <section class="filterSection">
        <p>查看结果</p>
        <!--选择筛选方式的div,与move()绑定onchange,实现由第一个选择值的改变确定第二个选择的展示-->
        <div class="filters">
            <form name="combinedFilter" action="Browse.php?page=1" method="post">
                <select class="filter" id="filterByContent" name="content">
                    <option value="" disabled selected hidden>选择主题</option>
                    <option value="scenery">Scenery</option>
                    <option value="city">City</option>
                    <option value="people">People</option>
                    <option value="animal">Animal</option>
                    <option value="building">Building</option>
                    <option value="wonder">Wonder</option>
                    <option value="other">Other</option>
                </select>
                <select class="filter" id="filterByCountry" name="country" onchange="changeSelect()">
                    <option value="" disabled selected hidden>选择国家</option>
                    <?php
                    $sql = "select CountryName from geocountries order by CountryName";
                    $result = mysqli_query($connection,$sql);
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<option value='". $row["CountryName"] ."'>" . $row["CountryName"] ."</option>";
                    }
                    ?>
                </select>
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
                </select>
                <input type="submit" id="filterBtn" value="筛选">
            </form>
        </div>
        <!--展示筛选结果，有一堆含图片的超链接-->
        <div class="picture">
            <?php
            checkFilter();
            ?>
        </div>
    </section>
    <div class="button">
        <a href=""><img src="../images/img/refresh.png" onclick="alert('已刷新')"></a>
        <a href="#top"><img src="../images/img/top.png" ></a>
    </div>
    <script src="../JS/filterLink.js"></script>

    </body>
    <footer>@19302010052@fudan.edu.cn
    </footer>
    </html>
<?php
function checkFilter(){
    if (isset($_POST["title"]) && ($title = trim($_POST["title"])) !== ""){
        $vagueTitle = "%$title%";
        $sql = "select travelimage.PATH,travelimage.ImageID from travelimage where Title like '$vagueTitle' limit 60";
        getResult($sql);
    }
    elseif (isset($_POST["content"]) || isset($_POST["country"]) || isset($_POST["city"])){
        $condition = "where ";
        if (isset($_POST["content"]) && $content = $_POST["content"]){
            $condition .= "travelimage.Content = '$content' and ";
        }
        if (isset($_POST["country"]) && $country = $_POST["country"]){
            $condition .= "geocountries.CountryName = '$country' and ";
        }
        if (isset($_POST["city"]) && $city = $_POST["city"]){
            $condition .= "geocities.AsciiName = '$city' and ";
        }
        $sql = "select travelimage.ImageID,travelimage.PATH from travelimage,geocountries,geocities " . $condition . "travelimage.CountryCodeISO = geocountries.ISO "
            . "and travelimage.CityCode = geocities.GeoNameID ";
        getResult($sql);
    }
    elseif (isset($_GET["hotContent"]) && $hotContent = $_GET["hotContent"]){
        $sql = "select ImageID,PATH from travelimage where travelimage.Content = '$hotContent'";
        getResult($sql);
    }
    elseif (isset($_GET["hotCountry"]) && $hotCountry = $_GET["hotCountry"]){
        $sql = "select travelimage.ImageID,travelimage.PATH from travelimage,geocountries where geocountries.CountryName = '$hotCountry' and travelimage.CountryCodeISO = geocountries.ISO";
        getResult($sql);
    }
    elseif (isset($_GET["hotCity"])){
        $hotCity = $_GET["hotCity"];
        $sql = "select travelimage.ImageID,travelimage.PATH from travelimage,geocities where geocities.AsciiName = '$hotCity' and travelimage.CityCode = geocities.GeoNameID ";
        getResult($sql);
    }
    elseif (isset($_SESSION["imgCount"]) && isset($_GET["page"]) && $page = $_GET["page"]){
        $imgArray = array();$imgCount = $_SESSION["imgCount"];
        for ($a = 0;$a < $imgCount;$a++){
            $imgArray[] = $_SESSION["imgArray[$a]"];
        }
        draw($imgArray);
    }
    else{
        $sql = "select * from travelimage order by RAND() limit 12";
        getResult($sql);
    }
}
function getResult($sql){
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $result = mysqli_query($connection,$sql);
    if ($result !== null) {
        $imgArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $imgArray[] = "<a href='Photo.php?id=" . $row["ImageID"] . "'><img src='../travel-images/medium/" . $row["PATH"] . "' class=' resultImage' alt='图片已丢失'></a>";
        }
        $_SESSION["imgCount"] = count($imgArray);
        for ($a = 0;$a < count($imgArray);$a++){
            $_SESSION["imgArray[$a]"]=$imgArray[$a];
        }
        draw($imgArray);
    }
    if (!is_null($result) & !is_bool($result)){
        mysqli_free_result($result);
    }
    mysqli_close($connection);
}
function draw($imgArray){
    $pages = min(ceil(count($imgArray) / 12), 5);
    echo "<div class='resultSection'>";
    if ($imgArray == null){
        echo "<strong>没有符合条件的图片</strong>";
    }
    elseif (isset($_GET["page"]) && $page = $_GET["page"]){
        for ($i = 0;$i < min(12,count($imgArray) - 12 * ($page - 1));$i++){
            echo $imgArray[12 * ($page - 1) + $i];
        }
        $previous = $page + $pages;
        echo "<div class='pageFooter'>" . "<a href='Browse.php?page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous))
            . "'>《</a>" . "&nbsp;&nbsp;&nbsp;";
        for ($p = 1;$p <= $pages;$p++){
            if($p == $page)
                echo "<span class='currentPageFooter'>$p</span>&nbsp;&nbsp;&nbsp;";
            else
                echo "<a href='Browse.php?page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
        }
        $next = $page + 1;
        echo "<a href='Browse.php?page=" . ($next % ($pages + 1) + floor($next / ($pages + 1))) . "'>》</a>";
    }
}
?>