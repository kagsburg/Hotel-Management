<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
      }else{
$id=$_GET['id'];
if(isset($_POST['item'],$_POST['quantity'])){
      $item=$_POST['item'];
          $quantity=$_POST['quantity'];
$change=  mysqli_query($con,"UPDATE hallbuffetitems SET item_id='$item',quantity='$quantity' WHERE hallbuffetitem_id='$id'") or die(mysqli_error($con));
}
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>