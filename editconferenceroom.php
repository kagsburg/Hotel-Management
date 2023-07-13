<?php
include 'includes/conn.php';
  if((!isset($_SESSION['hotelsys']))){
header('Location:login.php');
         }else{
         $id=$_GET['id'];
           if(isset($_POST['room'],$_POST['people'],$_POST['charge'])){
                                     $room=  mysqli_real_escape_string($con,trim($_POST['room']));
                                     $people=  mysqli_real_escape_string($con,trim($_POST['people']));
                                    $charge=  mysqli_real_escape_string($con,trim($_POST['charge']));
                                 if((empty($room)||(empty($charge)))||(empty($people))){
                                      $errors[]='Enter All Fields To Proceed';
                                }
                                if(is_numeric($charge)==FALSE){
                                 $errors[]='Charge should be An Integer';
                                }
                                    if(is_numeric($people)==FALSE){
                                 $errors[]='People should be An Integer';
                                }
                                if(!empty($errors)){
                                    foreach ($errors as $error) {
                                        echo '<div class="alert alert-danger">'.$error.'</div>';          
                                    }
                                }
                                else{                                                           
              mysqli_query($con,"UPDATE conferencerooms SET room='$room',people='$people',charge='$charge' WHERE conferenceroom_id='$id'") or die(mysqli_error($con));
                       header('Location:'.$_SERVER['HTTP_REFERER']);
    }
    }
   }
?>