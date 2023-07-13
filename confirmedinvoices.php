<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login.php'); 
}  
function getForexConvertedAmount($currencyrate, $amount)
{
   return intval($amount) * floatval($currencyrate);
}
$start = strtotime($_GET['st'] . ' ' . $_GET['stt']);
$end = strtotime($_GET['en'] . ' ' . $_GET['ent']);
?>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Confirmed Invoices | Hotel Manager</title>
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
   <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
   <link href="css/animate.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">
</head>
<body>
   <?php
   if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
      include 'fr/pendingouts.php';
   } else {
   ?>
      <div id="wrapper">
         <?php include 'nav.php'; ?>
         <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
               <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                  <div class="navbar-header">
                     <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                  </div>
                  <ul class="nav navbar-top-links navbar-right">
                     <li>
                        <a href="logout">
                           <i class="fa fa-sign-out"></i> Log out
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
               <div class="col-lg-10">
                  <h2>Confirmed invoices between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                  <ol class="breadcrumb">
                     <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                     <li>
                        <a>Confirmed</a>
                     </li>
                     <li class="active">
                        <strong>View confirmed invoices</strong>
                     </li>
                  </ol>
               </div>
               <div class="col-lg-2">
               </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div class="col-lg-12">
                  <div class="d-flex">
                  <a href="reservationinvoicesprint?st=<?php echo $start; ?>&en=<?php echo $end; ?>" target="_blank" class="btn btn-success mr-3">Print PDF</a>&nbsp;&nbsp;
                  <a href="reservationinvoicesexcel?st=<?php echo $start; ?>&en=<?php echo $end; ?>" class="btn btn-primary mb-2" target="_blank">Export to Excel</a>
                            </div>
                            <br>
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                           <h5>All Invoices <small>Sort, search</small></h5>                           
                        </div>
                        <div class="ibox-content">
                           <?php
                           // $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status IN (0,1,2) ORDER BY reservation_id DESC");
                           $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status='3'  ORDER BY reservation_id DESC");
                           if (mysqli_num_rows($reservations) > 0) {
                           ?>
                              <table class="table table-striped table-bordered table-hover dataTables-example">
                                 <thead>
                                    <tr>
                                       <th>Guest</th>
                                       <th>Room Number</th>
                                       <th>Check In</th>
                                       <th>Check Out</th>
                                       <th>Status</th>
                                       <th>Total Bill</th>
                                       <th>Amount Paid</th>
                                       <!-- <th>Action</th> -->
                                       <!--<th>Action</th>-->
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    while ($row =  mysqli_fetch_array($reservations)) {
                                       $reservation_id = $row['reservation_id'];
                                       $id = $reservation_id;
                                       $firstname = $row['firstname'];
                                       $lastname = $row['lastname'];
                                       $checkin = $row['checkin'];
                                       $phone = $row['phone'];
                                       $adults = $row['adults'];
                                       $checkout = $row['checkout'];
                                       $actualcheckout = $row['actualcheckout'];
                                       $room_id = $row['room'];
                                       $email = $row['email'];
                                       $status = $row['status'];
                                       $reduction = $row['reduction'];
                                       $currency = $row['currency'];
                                       $currencyrate = 1;
                                       if (!empty($currency) && $currency !== "USD") {
                                          $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status='1'");
                                          $curow = mysqli_fetch_array($getcurrencies);
                                          $currencyrate = $curow["rate"];
                                       }
                                       $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                       $row1 =  mysqli_fetch_array($getnumber);
                                       $roomnumber = $row1['roomnumber'];
                                       $type_id = $row1['type'];
                                       $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                       $row1 =  mysqli_fetch_array($roomtypes);
                                       $roomtype = $row1['roomtype'];
                                       $dollarCharge =  $row1['charge'];
                                       $sharecharge = $row1["sharecharge"];
                                       $dollarCharge = ($adults > 1 && isset($sharecharge)) ? $sharecharge : $dollarCharge;
                                       //$charge = getForexConvertedAmount($currencyrate, $dollarCharge);
                                       if ($status == 2) {
                                          $nights = round(($actualcheckout - $checkin) / (3600 * 24));
                                       } else {
                                          $nights =  round(($checkout - $checkin) / (3600 * 24));
                                       }
                                       $totalcharge = $dollarCharge * $nights;
                                       if (!empty($reduction))
                                          $totalcharge -= ($reduction * $nights);
                                       $totalcharge = getForexConvertedAmount($currencyrate, $totalcharge);                                       
                                       $totalotherservices = 0;
                                       $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$id' AND status=1")
                                       or die(mysqli_error($con));
                                       if (mysqli_num_rows($getotherservices) > 0) {
                                          while ($row3 = mysqli_fetch_array($getotherservices)) {
                                             $otherservice_id = $row3['otherservice_id'];
                                             $otherservice = $row3['otherservice'];
                                             $currency = $row3['currency'];
                                             if ($currency == 'USD') {
                                                $rate = $usdtariff;
                                             } else {
                                                $rate = 1;
                                             }
                                             $reduction = $row3['reduction'] * $rate;
                                             $price = $row3['price'] * $rate;
                                             $timestamp = $row3['timestamp'];
                                             $subtotal = $price - $reduction;
                                             $totalotherservices = $totalotherservices + $subtotal;
                                          }
                                       }
                                       $restbill = 0;
                                       $restorder = mysqli_query($con, "SELECT * FROM orders WHERE guest='$id' AND status IN(1,2)");
                                       if (mysqli_num_rows($restorder) > 0) {
                                          while ($row =  mysqli_fetch_array($restorder)) {
                                             $order_id = $row['order_id'];
                                             $guest = $row['guest'];
                                             $timestamp = $row['timestamp'];
                                             $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                                             $row =  mysqli_fetch_array($totalcharges);
                                             $totalrestcosts = getForexConvertedAmount($currencyrate, $row['totalcosts']);
                                             $restbill = $totalrestcosts + $restbill;
                                          }
                                       }
                                       $totallaundry = 0;
                                       $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' ORDER BY timestamp");
                                       if (mysqli_num_rows($laundry)) {
                                          while ($row =  mysqli_fetch_array($laundry)) {
                                             $laundry_id = $row['laundry_id'];
                                             $reserve_id = $row['reserve_id'];
                                             $clothes = $row['clothes'];
                                             $package_id = $row['package_id'];
                                             $timestamp = $row['timestamp'];
                                             $status = $row['status'];
                                             $creator = $row['creator'];
                                             $invoice_no = 23 * $id;
                                             $charge = getForexConvertedAmount($currencyrate, $row['charge']);
                                             $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                             $row2 =  mysqli_fetch_array($reservation);
                                             $firstname = $row2['firstname'];
                                             $lastname = $row2['lastname'];
                                             $room_id = $row2['room'];
                                             $phone = $row2['phone'];
                                             $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                                             $row3 = mysqli_fetch_array($getpackage);
                                             $laundrypackage = $row3['laundrypackage'];
                                             $totallaundry = $totallaundry + $charge;
                                          }
                                       }
                                       $totalbill = $totallaundry + $restbill + $totalcharge + $totalotherservices;
                                       if ($status != 2) {
                                          $getpayments = mysqli_query($con, "SELECT SUM(amount) AS totalpaid FROM payments WHERE reservation_id='$id'");
                                          $payrow = mysqli_fetch_array($getpayments);
                                          $totalpaid = $payrow['totalpaid'];
                                       } else {
                                          $getpayments = mysqli_query($con, "SELECT * FROM checkoutdetails WHERE reserve_id='$id'");
                                          $payrow = mysqli_fetch_array($getpayments);
                                          $totalpaid = $payrow['paidamount'];
                                       }
                                    ?>
                                       <tr class="gradeA">
                                          <td><?php echo $firstname . ' ' . $lastname; ?></td>
                                          <td class="center">
                                             <?php
                                             $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                             $row1 =  mysqli_fetch_array($roomtypes);
                                             $roomtype = $row1['roomnumber'];
                                             echo $roomtype; ?>
                                          </td>
                                          <td><?php echo date('d/m/Y', $checkin); ?></td>
                                          <td><?php echo date('d/m/Y', $checkout); ?></td>
                                          <td>
                                          <?php
                                                if (($timenow > $checkout) && ($status == 2)) {
                                                   echo '<div class="text-danger">guest out</div>';
                                                } else if (($timenow > $checkout) && ($status == 1)) {
                                                   echo '<div class="text-danger">Pending guest out</div>';
                                                } else if ($timenow < $checkout) {
                                                   echo '<div class="text-danger">guest in</div>';
                                                }
                                                ?>
                                          </td>
                                          <td><?php echo number_format($totalbill); ?></td>
                                          <td><?php echo number_format($totalpaid); ?></td>
                                          <!-- <td> -->
                                             <!-- <a href="proforma?id=<?php echo $reservation_id; ?>" class="btn btn-xs btn-info">View</a>
                                             <a href="editreservation?id=<?php echo $reservation_id; ?>" class="btn btn-xs btn-info">Edit</a> -->
                                             <!-- <?php   if ($_SESSION['sysrole'] == 'manager') { ?> -->
                                             <!-- <a href="confirmreservation?id=<?php echo $reservation_id; ?>" class="btn btn-xs btn-info" 
                                             onclick="return confirm_reservation<?php echo $reservation_id; ?>()">Confirm</a>
                                             <?php } ?>
                                             <a href="removereservationinvoice?id=<?php echo $reservation_id;?>" 
                                             class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $reservation_id; ?>()">
                                             <i class="fa fa-delete"></i>Cancel</a>
                                             <script type="text/javascript">
                                             function confirm_delete<?php echo $reservation_id; ?>() {
                                             return confirm('You are about To Remove this Request. Are you sure you want to proceed?');
                                             }
                                             function confirm_reservation<?php echo $reservation_id; ?>() {
                                             return confirm('You are about To Confirm this Request. Are you sure you want to proceed?');
                                             }
                                             </script>  -->
                                          <!-- </td> -->
                                       </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           <?php } else { ?>
                              <div class="alert  alert-danger">Oops!! No Confirmed invoices Yet</div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   <?php } ?>
   <!-- Mainly scripts -->
   <script src="js/jquery-1.10.2.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
   <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
   <!-- Data Tables -->
   <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
   <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
   <!-- Custom and plugin javascript -->
   <script src="js/inspinia.js"></script>
   <script src="js/plugins/pace/pace.min.js"></script>
   <!-- Page-Level Scripts -->
   <script>
      $(document).ready(function() {
         $('.dataTables-example').dataTable();
         /* Init DataTables */
         var oTable = $('#editable').dataTable();
         /* Apply the jEditable handlers to the table */
         oTable.$('td').editable('http://webapplayers.com/example_ajax.php', {
            "callback": function(sValue, y) {
               var aPos = oTable.fnGetPosition(this);
               oTable.fnUpdate(sValue, aPos[0], aPos[1]);
            },
            "submitdata": function(value, settings) {
               return {
                  "row_id": this.parentNode.getAttribute('id'),
                  "column": oTable.fnGetPosition(this)[2]
               };
            },
            "width": "90%"
         });
      });

      function fnClickAddRow() {
         $('#editable').dataTable().fnAddData([
            "Custom row",
            "New row",
            "New row",
            "New row",
            "New row"
         ]);
      }
   </script>
</body>
</html>