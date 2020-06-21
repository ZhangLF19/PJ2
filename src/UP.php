<?php
session_start();
require_once '../config.php';
require_once 'function.php'?>
<?php

    header("Content-Type:text/html;charset=utf-8");
   if($_POST['title']==''||$_POST['theme']==''||$_POST['country']==''||$_POST['city']==''){
       echo "请填写完整的土拍你信息"; echo '<br>';
       echo '<meta http-equiv="refresh" content="2;url=upload.php">';
   }

    elseif($_FILES['pic']['error']>0){
              echo $_FILES['pic']['error'];
              echo "上传文件错误！";
              echo '<meta http-equiv="refresh" content="3;url=index.php">';  //自动跳转回index文件
     }else{
          //开始获取上传文件的信息
          $file=$_FILES['pic'];
          //var_dump($file);打印文件里的全部信息
          //name:上传文件名
          //type:上传文件的类型
          //tmp_name:上传成功后的临时文件
           //size:上传文件的大小
         //error:上传文件的错误信息
         $uploaddir="../travel-images/medium/";  //选择要上传的文件存放目录
         //$uploadfile=$uploaddir.basename($file['name']);//获得上传文件的名称
         //解析文件的名字
         $fileinfo=pathinfo($file['name']);
         //      echo $fileinfo['extension'];  获取文件的类型
          do{
              $newfile=date("YmdHis").rand(1000,9999).".".$fileinfo['extension'];//更改文件的名字，获取一个新的名字
          }while(file_exists($uploaddir.$newfile));

           //上传文件的类型限制
           if (!(($file['type'] == "image/gif")||($file['type'] == "image/jpeg")||($file['type'] == "image/jpg")||($file['type'] == "image/png"))){
             die("文件类型错误！");
               echo '<meta http-equiv="refresh" content="3;url=upload.php">';
           }
             //上传文件的大小限制
             /*  if($file['size'] > 2*1024*1024){
               die("上传文件超过2MB！");
               echo '<meta http-equiv="refresh" content="3;url=upload.php">';
               }*/
              //开始上传文件
               if (is_uploaded_file($file['tmp_name'])) {
                     if (move_uploaded_file($file['tmp_name'], $uploaddir.$newfile)) {

                         try {$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                             $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                             $sql = 'select * from travelimage Order By ImageID';
                             $result = $pdo->query($sql);
                             while ($row = $result->fetch()){$i=$row['ImageID']+1;}
                             $title=$_POST['title'];
                             $theme=$_POST['theme'];
                             $city=getCityCodeByCity($_POST['city']);
                             $country=getCountryCodeByCountry($_POST['country']);
                             $description=$_POST['description'];
                             $UID=getUID();
                             $sql = "insert into travelimage(ImageID,Title,CityCode,CountryCodeISO,Description,UID,PATH,Content) values('$i','$title','$city','$country','$description','$UID','$newfile','$theme')";
                             $result = $pdo->query($sql);
                             $pdo = null;
                         }catch (PDOException $e) {
                             die( $e->getMessage() );

                         }

                             echo "上传成功！";
                             echo '<meta http-equiv="refresh" content="1;url=upload.php">';
                             //自动跳转回index文件
                    } else {
                   echo "上传失败，请稍等！";
                   echo '<meta http-equiv="refresh" content="3;url=upload.php">';  //自动跳转回index文件
}
}

}


?>
