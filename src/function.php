<?php
require_once('../config.php');

function pdo($sql)
{
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $pdo->query($sql);
    $pdo = null;
    return $result;
}//连接数据库
function getUID(){
        $sql= 'SELECT * FROM `traveluser` WHERE UserName= '.'"'.$_SESSION['Username'].'"';
        $result =pdo($sql);
        $row=$result->fetch();
        return $row['UID'];
}


function enFavor($UID, $imageId)
{
    if(!isFavor($UID,$imageId)){
    $sql = "INSERT INTO `travelimagefavor` (`UID`, `ImageID`)
    VALUES ('" . $UID . "', '" . $imageId . "')";
     pdo($sql);
     return "<script>alert('收藏成功')</script>";
    }
    else {
        $sql="delete from travelimagefavor where UID=".$UID." AND ImageID=".$imageId;
        pdo($sql);
    }
}
function isFavor($UID, $imageId)
{
    $sql = 'SELECT * FROM `travelimagefavor` WHERE UID=' . $UID . ' AND ImageID=' . $imageId;
    $result = pdo($sql);
    if ($result->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function getUserNameByUID($UID)
{
    $sql = 'SELECT * FROM `traveluser` WHERE UID=' . $UID;
    $result = pdo($sql);
    return $result->fetch()['UserName'];
}


function getCityCodeByCity($city)
{
    if ($city != null) {
        $sql = 'SELECT * FROM `geocities` WHERE AsciiName=' .'"'. $city.'"';
        $result = pdo($sql);
        $geo = $result->fetch();
        $cityCode = $geo['GeoNameID'];
    } else {
        $cityCode = 'unknown-CityCode';
    }
    return $cityCode;
}

function getCountryCodeByCountry($country)
{
    if ($country != null) {
        $sql = 'SELECT * FROM `geocountries` WHERE CountryName="' . $country . '"';
        $result = pdo($sql);
        $countryCode = $result->fetch()['ISO'];
    } else {
        $countryCode = 'unknown-CountryCode';
    }
    return $countryCode;
}

//Browser

function getCountryByCountryCode($countryCode)
{
    if ($countryCode == null) {
        $country = 'UNKNOWN';
    } elseif ($countryCode != 'NULL') {
        $sql = 'SELECT * FROM `geocountries` WHERE ISO="' . $countryCode . '"';
        $result = pdo($sql);
        $country = $result->fetch()['CountryName'];
    } else {
        $country = 'NULL';
    }
    return $country;
}//根据ISO得到国家名
function getCityByCityCode($cityCode)
{
    if ($cityCode == null) {
        $city = 'UNKNOWN';
    } elseif ($cityCode != "NULL") {
        $sql = 'SELECT * FROM `geocities` WHERE GeoNameID=' . $cityCode;
        $result = pdo($sql);
        $geo = $result->fetch();
        $city = $geo['AsciiName'];
    } else {
        $city = 'NULL';
    }
    return $city;
}//根据code得城市
function hash1($user,$pass){
    $hash=sha1($user,$pass);
    for ($i=0;$i<10;$i++){
        $hash=sha1($hash);
    }
    return $hash;
}

