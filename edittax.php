<?php
include 'includes/conn.php';
  if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
         }else{
         $id=$_GET['id'];
  if(isset($_POST['tax'],$_POST['rate'])){
                                     $tax=  mysqli_real_escape_string($con,trim($_POST['tax']));
                                    $rate=  mysqli_real_escape_string($con,trim($_POST['rate']));
                                 if((empty($tax)||(empty($rate)))){
                                   $errors[]='Enter All Fields To Proceed';
                                }
                                if(is_numeric($rate)==FALSE){
                                $errors[]='Room Charge should be An Integer';
                                }
                               if(!empty($errors)){
                                   foreach ($errors as $error) {
                                       echo '<div class="alert alert-danger">'.$error.'</div>';       
                                   }
                               }
                                else{
              mysqli_query($con,"UPDATE taxes SET tax='$tax',rate='$rate' WHERE tax_id='$id'") or die(mysqli_error($con));
     header('Location:'.$_SERVER['HTTP_REFERER']);
    }
    }
   }
?>