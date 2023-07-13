<?php
include 'includes/conn.php';
session_start();
    if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
 header('Location:login.php');
}
$id=$_GET['id'];
$activate=$_GET['status'];
if($activate=='1'){
$change=  mysqli_query($con,"UPDATE users SET status='0' WHERE user_id='$id'") or die(mysqli_errno($con));
}
 else {
   $change=  mysqli_query($con,"UPDATE users  SET status='1' WHERE user_id='$id'") or die(mysqli_errno($con)); 
}
header('Location:'.$_SERVER['HTTP_REFERER']);
?>