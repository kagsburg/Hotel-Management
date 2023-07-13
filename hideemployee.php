<?php
include 'includes/conn.php';
    if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
   }else{
$id=$_GET['id'];
  $change=  mysqli_query($con,"UPDATE employees  SET status='0' WHERE employee_id='$id'") or die(mysqli_errno($con)); 
  $change=  mysqli_query($con,"UPDATE users SET status='0' WHERE employee='$id'") or die(mysqli_errno($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>