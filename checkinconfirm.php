<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
$update=  mysqli_query($con,"UPDATE reservations SET status='1',creator='".$_SESSION['emp_id']."' WHERE reservation_id='$id'");
header('Location:'.$_SERVER['HTTP_REFERER']);
?>