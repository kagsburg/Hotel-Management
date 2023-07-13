<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
   }else{
$id=$_GET['id'];
if(isset($_POST['unitprice'])){
$unitprice=$_POST['unitprice'];
$change=  mysqli_query($con,"UPDATE purchaseditems  SET price='$unitprice' WHERE purchaseditem_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
   }
?>