<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Restaurant Attendant')){
header('Location:login.php');
   }else{
   $order_id=$_GET['id'];
  $restorders=mysqli_query($con,"UPDATE  creditpayments SET  status=1,timestamp='$timenow'  WHERE order_id='$order_id'");
 }
  header('Location:'.$_SERVER['HTTP_REFERER']);
?>

           