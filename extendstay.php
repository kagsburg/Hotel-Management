<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
$checkout=$_GET['check'];
?>
 <link href="css/bootstrap.min.css" rel="stylesheet">
<?php
   if(isset($_POST['newcheckout'])){
                            $newcheckout=mysqli_real_escape_string($con,  strtotime( $_POST['newcheckout'])); 
                            if(empty($newcheckout)){
                               $errors[]= 'Select Date to proceed';
                            }
                            if($checkout>$newcheckout){
                                $errors[]= 'Selected Date is before  the Checkout Date';
                            }
                            if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="col-lg-8"><div class="alert alert-danger"><?php echo $error; ?></div></div><br/>
<?php 
}         }else{
           $change=  mysqli_query($con,"UPDATE reservations SET  checkout='$newcheckout' WHERE reservation_id='$id'") or die(mysqli_error($con));
           echo '<div class="col-lg-8"><div class="alert alert-success"><i class="fa fa-check"></i>Guest Stay Successfully Extended</div></div><br/>';
           
                        }}
                                  ?>  
<div class="col-lg-8"><a href="reservation?id=<?php echo $id;?>" class="btn btn-sm btn-info">Go Back</a></div>
     