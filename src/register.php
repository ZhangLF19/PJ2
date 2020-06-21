

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>SIGN UP</title>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
</head>
<body>
<form action="" method="post">
<div class="login"><!--边框-->
    <div class="logo"></div><!--logo-->
    <div class="form"><!--输入框-->
        <small >请输入用户名</small>
        <input name="username" type="text" autocomplete="off" placeholder="用户名">
    </div>
    <div class="form">
        <small >请输入邮箱</small>
        <input name="useremail" type="text" autocomplete="off" placeholder="邮箱">

    </div>
    <div class="form">
        <small>请输入密码</small>
        <input name="password" type="password" autocomplete="off" placeholder="密码">
    </div>
    <div class="form">
        <small>请再次输入密码</small>
        <input name="password1" type="password" autocomplete="off" placeholder="密码">
    </div>
    <div class="form">
        <small>
            输入答案<br>
            <input type="text" placeholder="7*9=" pattern="^63$" required>
        </small>

    </div>
    <div class="form"><a><input type="submit" value="立即注册" name="subr"></a></div>
</div>
<div class="bottom">@19302010052@fudan.edu.cn</div><!--页脚-->
</form>
</body><script src="test.js"></script>
</html>

<?php
require_once 'function.php';
require_once ('../config.php');
//建立连接
$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,'newtravel');
if($conn){
    //数据库连接成功
    $select = mysqli_select_db($conn,"newtravel");		//选择数据库
    if(isset($_POST["subr"])){
            $user = $_POST["username"];
            $pass = $_POST["password"];
            $re_pass = $_POST["password1"];
         $checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";  //定义正则表达式
          $weakPass='/((^[0-9]{6,})|(^[a-z]{6,})|(^[A-Z]{6,}))$/';
         if(isset($_POST['useremail']) && $_POST['useremail']!="") {            //判断文本框中是否有值
             $email = $_POST['useremail'];                                    //将传过来的值赋给变量$mail
             if (!preg_match($checkmail, $email)) {                        //用正则表达式函数进行判断
                 echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "邮箱错误！" . "\"" . ")" . ";" . "</script>";
                 echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.php"."\""."</script>";
                 exit;
             }
         }
         if(preg_match($weakPass, $pass)){ echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "弱密码！" . "\"" . ")" . ";" . "</script>";
             echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.php"."\""."</script>";
             exit;}

        if($user == ""||$pass == ""){
            //用户名or密码为空
            echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."用户名或密码不能为空！"."\"".")".";"."</script>";
            echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.php"."\""."</script>";
            exit;
        }


        if($pass == $re_pass){
                //两次密码输入一致
                mysqli_set_charset($conn,'utf8');	//设置编码

                //sql语句
                $sql_select = "select UserName from traveluser where UserName = '$user'";
                //sql语句执行
                $result = mysqli_query($conn,$sql_select);
                //判断用户名是否已存在
                $num = mysqli_num_rows($result);

                if($num){
                    //用户名已存在
                    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."用户名已存在！"."\"".")".";"."</script>";
                    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.php"."\""."</script>";
                    exit;
                }else{
                    //用户名不存在
                    $hash=hash1($user,$pass);
                    $sql_insert = "insert into traveluser(Email,UserName,Pass) values('$email','$user','$hash')";
                    //插入数据
                    $ret = mysqli_query($conn,$sql_insert);
                    $row = mysqli_fetch_array($ret);
                    //跳转注册成功页面
                   echo "<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."注册成功，即将跳转至登录界面！"."\"".")".";"."</script>";
                   echo "<script type="."\""."text/javascript"."\"".">"."window.location="."\""."log.php"."\""."</script>";
                }
            }else{
                //两次密码输入不一致
                echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."两次密码输入不一致！"."\"".")".";"."</script>";
                echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.php"."\""."</script>";
                exit;
            }
        }
        //关闭数据库
        mysqli_close($conn);
    }else{
        //连接错误处理
        die('Could not connect:');
    }


?>