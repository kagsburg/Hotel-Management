<?php
include 'includes/conn.php';
  if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
   }else{
$id=$_GET['id'];
if(isset($_POST['department'])){
   $dept=mysqli_real_escape_string($con,trim( $_POST['department'])); 
  if(empty($dept)){
      echo '<div class="alert alert-danger">Enter Department To Continue</div>';
  }                    
else{
$change=  mysqli_query($con,"UPDATE departments SET department='$dept' WHERE department_id='$id'") or die(mysqli_error($con));
}}
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>