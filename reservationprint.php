<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reservation | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/reservationprint.php';                     
                                       }else{
          ?>          
                <div class="wrapper wrapper-content p-xl">
          <div class="row">
                 <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
          </div>
                       <h2 class="text-center"><strong>HOTEL RESERVATION</strong></h2>
                      <div class="row">
                <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Guest Details</h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$id'");
$row=  mysqli_fetch_array($reservations);
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$arrivaltime=$row['arrivaltime'];
$arrivingfrom=$row['arrivingfrom'];
$departuretime=$row['departuretime'];
$phone=$row['phone'];
$email=$row['email'];
$adults=$row['adults'];
$kids=$row['kids'];
$widebed=$row['widebed'];
$dob=$row['dob'];
$usdtariff=$row['usdtariff'];
$fax=$row['fax'];
$id_number=$row['id_number'];
$checkout=$row['checkout'];
$actualcheckout=$row['actualcheckout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
  $origin=$row['origin'];
  $creator=$row['creator'];
  $occupation=$row['occupation'];
  $business=$row['business'];
  $reduction=$row['reduction'];

  
              ?>
      <div>
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Guest Name</strong>. : <?php echo $firstname.' '.$lastname; ?> <br>
                                             </div>
                                    </div>
                                      
                                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Origin</strong>. : <?php echo $origin; ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Phone Number</strong>. : <?php echo $phone; ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Occupation</strong>. : <?php echo $occupation; ?> <br>
                                             </div>
                                    </div>
                                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Business</strong>. : <?php echo $business; ?> <br>
                                             </div>
                                    </div>
                                     <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>ID Number</strong>. : <?php echo $id_number; ?> <br>
                                             </div>
                                    </div>
                                        <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Email</strong>. : <?php echo $email; ?> <br>
                                             </div>
                                    </div>
                                      
                                        <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Fax</strong>. : <?php echo $fax; ?> <br>
                                             </div>
                                    </div>
                                      
                                    <?php 
                                                                  if(!empty($email)){ ?>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Email</strong>. : <?php echo $email; ?> <br>
                                             </div>
                                    </div>
                                    <?php } ?>
                                 
                                    
                                    
                                    
                                                                                                 
                                             </div>
                            </div>
                    </div>
                </div>
           
           

            </div>
                <div class="col-lg-6">
                       <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Reservation Details</h5>
                        
                        </div>
                        <div class="ibox-content">
 <div>
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                     <strong>Room Number: </strong>
                                                     <?php 
                                            $getnumber=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($getnumber);
                                            $roomnumber=$row1['roomnumber'];
                                            $type_id=$row1['type'];
                       echo $roomnumber; ?>
                                                     . <br>
                                                                                                                              </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                     <strong>Room Type: </strong>
                                                     <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                       echo $roomtype; ?>
                                                     . <br>
                                                                                                                              </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Adults</strong>. : <?php echo $adults; ?> <br>
                                             </div>
                                    </div>
                                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Kids</strong>. : <?php echo $kids; ?> <br>
                                             </div>
                                    </div>
                                         
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Arrival Date</strong>  : <?php echo date('d/m/Y',$checkin); ?> <br>
                                             </div>
                                    </div>
                                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Arrival Time</strong>  : <?php echo $arrivaltime; ?> <br>
                                             </div>
                                    </div>
                                     
                                    <?php
                                    if($status==2){
                                           $checkedouts=  mysqli_query($con,"SELECT * FROM checkoutdetails WHERE reserve_id='$id'");
                                             $row2=  mysqli_fetch_array($checkedouts);
           $checkoutdetails_id=$row2['checkoutdetails_id'];
           $reserve_id=$row2['reserve_id'];
           $paidamount=$row2['paidamount'];
           $totalbill=$row2['totalbill'];
                                    ?>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Checked Out on</strong>  : <?php echo date('d/m/Y',$actualcheckout); ?> <br>
                                             </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Total Bill</strong>  : <?php echo number_format($totalbill); ?> <br>
                                             </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Paid amount</strong>  : <?php 
                                                                                  $getpayments= mysqli_query($con,"SELECT SUM(amount) as amountpaid FROM payments WHERE reservation_id='$id'") or die(mysqli_error($con));
                                                                           $roww= mysqli_fetch_array($getpayments);
                                                                           $amountpaid=$roww['amountpaid'];
                                                                                  echo number_format($amountpaid); ?> <br>
                                             </div>
                                    </div>
                                    <?php }  else { ?>
                                                                                                   <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Expected Departure Date</strong>  : <?php echo date('d/m/Y',$checkout); ?> <br>
                                             </div>
                                    </div>
                                     <div class="feed-element">
                                                                              <div class="media-body ">
                                    <strong>Expected Departure Time</strong>  : <?php echo $departuretime; ?> <br>
                                             </div>
                                    </div>
                                  
                                    <?php   }if(!empty($reduction)){?>
                                      <div class="feed-element">
                                                 <div class="media-body ">
                                             <strong>Reduction </strong>  : <?php echo $reduction; ?><br>
                                             </div>
                                    </div>
                                    <?php }?>
                                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Status</strong>  : <?php             if($status==2){
                            echo '<span class="text-danger">GUEST OUT</span>';
                        } 
                          else if(($timenow>$checkout)&&($status==1)){
                            echo '<span class="text-danger">PENDING GUEST OUT</span>';
                        } 
                        else if(($timenow<$checkout)&&($status==1)){
                              echo '<span class="text-successr">GUEST IN</span>';
                        }
                          else if(($status==0)){
                              echo '<span class="text-info">PENDING</span>';
                        }
                        else if($status==3){
                              echo '<span class="text-danger">CANCELLED</span>';
                        }
                        ?> <br>
                                             </div>
                                    </div>
                                    
                                    </div>
                                    </div>
                                    </div>
                       </div>
               
            </div>
                <div class="col-lg-8">
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Other Services</h5>
                   
                            <div style="clear: both"></div>
                       </div>
                        <div class="ibox-content">
                            <table class="table table-responsive">
                                <thead>
                   <tr><th>Date</th><th>Service</th><th>Price</th><th>Reduction</th></tr>
                              </thead>
                              <tbody>
                        <?php
                        $getotherservices= mysqli_query($con,"SELECT * FROM otherservices WHERE reservation_id='$id' AND status=1") or die(mysqli_error($con));
                        while ($row3 = mysqli_fetch_array($getotherservices)) { 
                            $otherservice_id=$row3['otherservice_id'];
                            $otherservice=$row3['otherservice'];
                            $reduction=$row3['reduction'];
                            $currency=$row3['currency'];
                            $price=$row3['price'];
                            $timestamp=$row3['timestamp'];
                            ?>
                                  <tr><td><?php echo date('d/m/Y',$timestamp); ?></td><td><?php echo $otherservice;  ?></td>
                                      <td><?php echo $price;  ?></td><td><?php echo $reduction;  ?></td>
                                 </tr> 
                            
                   <?php  
                   }
                        ?>

                              </tbody>
                            </table>
                        </div>
                        </div>
                </div>
            </div>

    </div>
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
