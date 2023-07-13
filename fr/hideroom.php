<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
$published=$_GET['status'];
if($published=='1'){
$change=  mysqli_query($con,"UPDATE rooms  SET status='0' WHERE room_id='$id'") or die(mysql_errno($con));
}
 else {
   $change=  mysqli_query($con,"UPDATE rooms  SET status='1' WHERE room_id='$id'") or die(mysqli_errno($con)); 
}

header('Location:'.$_SERVER['HTTP_REFERER']);
?>