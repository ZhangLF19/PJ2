<?php
session_start();
unset($_SESSION['Username']);
//header("Location: ".$_SERVER['HTTP_REFERER']);
echo '<meta http-equiv="refresh" content="0;url=log.php">';

?>
