<?php session_start(); ?>
<?php
function getLoginForm(){
    return "
<form action='' method='post' role='form'>
<div class='login'><!--边框-->
    <div class='logo'></div><!--logo-->
    <div class='form'><!--输入框-->
        <input name='username' type='text' autocomplete='off' placeholder=\"邮箱或用户名\">
    </div>
    <div class='form'>
        <input name='password' type='password' autocomplete='off' placeholder=\"请输入密码\">
    </div>
     <a href='../index.php'><div class='form' ><button >登 录</button></div></a>
    <div >
     <a id=\"signUp\" href=\"register.php\">立即注册</a>
     <a id=\"forget\" href=\" \">忘记密码？</a>
    </div>
  </div>
  <div class=\"bottom\">@19302010052@fudan.edu.cn</div>
</form>";
}


?>
<?php require_once("../config.php");
require_once 'function.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validLogin()) {
        $_SESSION['Username']=$_POST['username'];
    } else {
        echo '<script>alert("login unsuccessful")</script>';
    }

}

function validLogin(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    //very simple (and insecure) check of valid credentials.
    $sql = "SELECT * FROM traveluser WHERE UserName=:user and Pass=:pass";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user',$_POST['username']);
    $statement->bindValue(':pass',hash1($_POST['username'],$_POST['password']));
    $statement->execute();

    if($statement->rowCount()>0){
        return true;
    }
    else return false;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="../css/log.css">
</head>
<body>

<?php if (isset($_SESSION['Username'])){
     header("Location:../index.php" );

} else{
    echo getLoginForm();
} ?>
</body>
</html>
