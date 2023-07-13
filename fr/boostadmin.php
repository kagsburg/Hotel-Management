<?php
include 'includes/conn.php';
session_start();
    if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
 header('Location:login.php');
}
$id=$_GET['id'];
$level=$_GET['level'];
if($level=='0'){
$change=  mysqli_query($con,"UPDATE users SET level='1' WHERE user_id='$id'") or die(mysqli_errno($con));
}
 else {
   $change=  mysqli_query($con,"UPDATE users  SET level='0' WHERE user_id='$id'") or die(mysqli_errno($con)); 
}
header('Location:'.$_SERVER['HTTP_REFERER']);
?>