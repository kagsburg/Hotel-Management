<?php
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Store Attendant')){
header('Location:login.php');
   }else{
$id=$_GET['id'];
$change=  mysqli_query($con,"UPDATE itemlosses SET status='0' WHERE itemloss_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>