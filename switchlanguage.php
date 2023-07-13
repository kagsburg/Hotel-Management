<?php 
include 'includes/conn.php';
  $lan=$_GET['lan'];
unset($_SESSION["lan"]);
$_SESSION['lan']=$lan;
header('Location:'.$_SERVER['HTTP_REFERER']);
 ?>