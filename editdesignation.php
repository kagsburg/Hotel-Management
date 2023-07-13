<?php
include 'includes/conn.php';
  if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
   }else{
$id=$_GET['id'];
if(isset($_POST['designation'])){
   $designation=mysqli_real_escape_string($con,trim( $_POST['designation'])); 
   $salary=mysqli_real_escape_string($con,trim( $_POST['salary'])); 
  if(empty($designation)){
      echo '<div class="alert alert-danger">Enter Designation To Continue</div>';
  }                    
else{
$change=  mysqli_query($con,"UPDATE designations SET designation='$designation',salary='$salary' WHERE designation_id='$id'") or die(mysqli_error($con));
}}
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>