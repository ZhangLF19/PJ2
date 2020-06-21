<?php
require_once '../config.php';
require_once 'function.php';
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
$sql='UPDATE travelimage SET Title="'.$_POST['title'].'",Description="'.$_POST['description'].'",CityCode="'.getCityCodeByCity($_POST['city']).
    '",CountryCodeISO="'.getCountryCodeByCountry($_POST['country']).'",Content="'.$_POST['theme'].'" where ImageID= "'.$_GET['id'].'"';
     mysqli_query($connection,$sql);

echo "修改成功";
echo '<meta http-equiv="refresh" content="3;url=myphoto.php">';

?>
