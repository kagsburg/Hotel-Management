<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
      }else{
$id=$_GET['id'];
if(isset($_POST['item'],$_POST['quantity'])){
        $item=$_POST['item'];
        $quantity=$_POST['quantity'];
         mysqli_query($con,"UPDATE menuitemproducts SET stockitem_id='$item',quantity='$quantity' WHERE menuitemproduct_id='$id'") or die(mysqli_error($con));
  }
   }
    header('Location:'.$_SERVER['HTTP_REFERER']);
?>