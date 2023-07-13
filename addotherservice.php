<?php
include 'includes/conn.php';
  if((!isset($_SESSION['hotelsys']))){
header('Location:login.php');
         }else{
         $id=$_GET['id'];
  if(isset($_POST['submit'])){
                                     $otherservice=  mysqli_real_escape_string($con,trim($_POST['servicename']));
                                    $reduction=  mysqli_real_escape_string($con,trim($_POST['reduction']));
                                    $currency=  mysqli_real_escape_string($con,trim($_POST['currency']));
                                    $price=  mysqli_real_escape_string($con,trim($_POST['serviceprice']));
                                 if((empty($otherservice)||(empty($price)))){
                                   $errors[]='Enter All Fields To Proceed';
                                }
                             
                               if(!empty($errors)){
                                   foreach ($errors as $error) {
                                       echo '<div class="alert alert-danger">'.$error.'</div>';       
                                   }
                               }
                                else{
              mysqli_query($con,"INSERT INTO otherservices(reservation_id,otherservice,reduction,currency,price,timestamp,status) VALUES('$id','$otherservice','$reduction','$currency','$price','$timenow',1)") or die(mysqli_error($con));
     header('Location:'.$_SERVER['HTTP_REFERER']);
    }
    }
   }
?>