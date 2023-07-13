<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Restaurant Attendant')){
header('Location:login.php');
   }else{
$id=$_GET['id'];
if(isset($_POST['status'])){
    $status=$_POST['status'];
    if(!empty($status)){
$update=  mysqli_query($con,"UPDATE orders SET orderstatus='$status' WHERE order_id='$id'") or die(mysqli_error($con));
}
}
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>