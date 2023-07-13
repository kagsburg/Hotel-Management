<?php
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Bar attendant')){
header('Location:login.php');
   }else{
$id=$_GET['id'];
$change=  mysqli_query($con,"UPDATE barorders   SET status='0' WHERE barorder_id='$id'") or die(mysqli_errno($con));

header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>