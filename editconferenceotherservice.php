<?php
include 'includes/conn.php';
  if((!isset($_SESSION['hotelsys']))){
header('Location:login.php');
         }else{
         $id=$_GET['id'];
            if(isset($_POST['service'],$_POST['charge'])){
                                     $service=  mysqli_real_escape_string($con,trim($_POST['service']));
                                    $charge=  mysqli_real_escape_string($con,trim($_POST['charge']));
                               
                                 if((empty($service)||(empty($charge)))){
                                  $errors[]='Enter All Fields To Proceed';
                                }
                                if(is_numeric($charge)==FALSE){
                                 $errors[]='Charge should be An Integer';
                                }
                              
                                if(!empty($errors)){
                                    foreach ($errors as $error) {
                                        echo '<div class="alert alert-danger">'.$error.'</div>';          
                                    }
                                }
                                else{                                                          
              mysqli_query($con,"UPDATE conferenceotherservices SET service='$service',charge='$charge'  WHERE conferenceotherservice_id='$id'") or die(mysqli_error($con)); 
              header('Location:'.$_SERVER['HTTP_REFERER']);
    }
    }
   }
?>