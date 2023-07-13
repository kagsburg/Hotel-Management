<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login');
   }else{
$id=$_GET['id'];
if(isset($_POST['returndate'])){
    $returndate=strtotime($_POST['returndate']);
$change=  mysqli_query($con,"UPDATE leaves SET returndate='$returndate' WHERE  leave_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
   }
?>