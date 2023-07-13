<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login.php');
} else {
   $id = $_GET['id'];
   $change =  mysqli_query($con, "UPDATE purchaselists SET status='2' WHERE purchaselist_id='$id'") or die(mysqli_error($con));
   header('Location:' . $_SERVER['HTTP_REFERER']);
}
