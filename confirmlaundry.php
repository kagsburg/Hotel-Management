<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login');
   }else{
$id=$_GET['id'];
// get reserve id if exist
$check=  mysqli_query ($con,"SELECT * FROM laundry WHERE laundry_id='$id'") ;
$checkrow=  mysqli_fetch_array($check);
$timestamp=$checkrow['timestamp'];
if ($checkrow['reserve_id']!=0){
    $reserve_id=$checkrow['reserve_id'];
    $change=  mysqli_query($con,"UPDATE laundry  SET status='3' WHERE reserve_id='$reserve_id' and timestamp='$timestamp'") or die(mysqli_errno($con));
   //  redirect to invoice
   header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
}
// if no reservation
//  update status based on customer name
$customer=$checkrow['customername'];
$change=  mysqli_query($con,"UPDATE laundry  SET status='3' WHERE customername='$customer' and timestamp='$timestamp'") or die(mysqli_errno($con));
// $change=  mysqli_query($con,"UPDATE laundry SET status='3' WHERE  laundry_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>