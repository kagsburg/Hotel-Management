<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
$st=$_GET['st'];
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Guest Invoice Print | Grace Land Hotel</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
                <div class="wrapper wrapper-content p-xl">
               <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-2"><img src="assets/demo/graceland-logo.png" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                       <address>
                                                                           <h3></h3>
                                        <strong>Graceland Hotel</strong><br>
                                        Mbela Misugwi<br>
                                        Mwanza, Tanzania<br>
                                        <strong>P : </strong> 0769657573 , 0767747515<br/>
                                        www.gracelandhotel.com<br/>
                                            <span><strong>TIV:</strong>104591272</span>
                                    </address>
                                 
                                </div>
<?php
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$id'");
$row=  mysqli_fetch_array($reservations);
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
//$id_number=$row['id_number'];
$checkout=$row['checkout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
  $country=$row['country'];
  $creator=$row['creator'];
 $invoice_no=23*$id;
  $nights=  round(($checkout-$checkin)/(3600*24))+1;
              ?>
                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy"><?php echo $invoice_no; ?></h4>
                                    <span>To:</span>
                                    <address>
                                        <strong><?php echo $firstname.' '.$lastname; ?></strong><br>
                                         <strong>P:</strong> <?php echo $phone; ?><br/>
                                         <strong>Country:</strong><?php echo $country; ?><br/>
                                          <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                    </address>
                                     
                                       
                                 
                                </div>
                                
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Room Number</th>
                                        <th>Type</th>
                                        <th>Check in</th>
                                        <th>Nights</th>
                                        <th>Unit Charge</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                                       <?php 
                                            $getnumber=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($getnumber);
                                            $roomnumber=$row1['roomnumber'];
                                            $type_id=$row1['type'];
                       echo $roomnumber; ?>
                                                </strong></div>
                                            </td>
                                        <td>  <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                                            $charge=$row1['charge'];
                       echo $roomtype; 
                       ?></td>
                                        <td><?php echo date('d/M',$checkin); ?></td>
                                        <td><?php  echo $nights;  ?></td>
                                        <td><?php echo number_format($charge);?></td>
                                    </tr>
                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($charge*$nights);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Visiting GraceLand Hotel <strong>
                            </div>
                        </div>

    </div>

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
