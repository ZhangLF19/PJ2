<?php
function Head1()
{
    echo '   <div class="menu">
       <ul name="top">
           <li ><a href="index.php">Home</a></li>
           <li><a href="src/Browse.php">Browse</a></li>
           <li ><a href="src/search.php">Search</a></li>';

    if (isset($_SESSION['Username'])) {
        echo '<div class="dropdown">
               <a href="" class="dropbtn"><img src="images/img/2.jpg">        My Account</a>
               <!--下拉菜单-->
               <div class="dropdown-content">
                   <a href="src/upload.php"><img src="images/img/upLoad.jpg"> upload</a>
                   <a href="src/myphoto.php"><img src="images/img/myPhotos.jpg"> my photo</a>
                   <a href="src/my%20favorite.php" id="myfavourite"><img src="images/img/1.jpg"> my favourite</a>
                   <a href="src/logout.php"><img src="images/img/3.jpg"> logout</a>
               </div>
         </div>';
    } else {
        echo ' <div class="dropdown">
                         <a href="src/log.php" class="dropbtn"> LogIn</a>
                        </div>';
    }

    echo '</ul>
   </div>';
}//导航栏

function Head2()
{
    echo '   <div class="menu">
       <ul name="top">
           <li ><a href="../index.php">Home</a></li>
           <li><a href="Browse.php">Browse</a></li>
           <li ><a href="search.php">Search</a></li>';

    if (isset($_SESSION['Username'])) {
        echo '<div class="dropdown">
               <a href="" class="dropbtn"><img src="../images/img/2.jpg">        My Account</a>
               <!--下拉菜单-->
               <div class="dropdown-content">
                   <a href="upload.php"><img src="../images/img/upLoad.jpg"> upload</a>
                   <a href="myphoto.php"><img src="../images/img/myPhotos.jpg"> my photo</a>
                   <a href="my%20favorite.php" id="myfavourite"><img src="../images/img/1.jpg"> my favourite</a>
                   <a href="logout.php"><img src="../images/img/3.jpg"> logout</a>
               </div>
         </div>';
    } else {
        echo ' <div class="dropdown">
                         <a href="log.php" class="dropbtn"> LogIn</a>
                        </div>';
    }

    echo '</ul>
   </div>';
}//导航栏
?>
