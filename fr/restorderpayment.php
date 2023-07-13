<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Restaurant Attendant')){
header('Location:login.php');
   }else{
   $order_id=$_GET['id'];
   if(isset($_POST['mode'])){
       $mode=$_POST['mode'];
  $restorders=mysqli_query($con,"UPDATE  orders SET  status=1,mode='$mode' WHERE order_id='$order_id'");
   }
   }
  header('Location:'.$_SERVER['HTTP_REFERER']);
?>

           