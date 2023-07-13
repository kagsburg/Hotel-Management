<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
}
$laundry_id=$_GET['id'];
$laundorder=mysqli_query($con,"SELECT * FROM laundry WHERE  laundry_id='$laundry_id'");
$row=  mysqli_fetch_array($laundorder);
$laundry_id=$row['laundry_id'];
$phone=$row['phone'];
$clothes=$row['clothes'];
$package =$row['package_id'];
$reserve_id = $row['reserve_id'];
$reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
if (mysqli_num_rows($reservation) > 0) {
    $row2 =  mysqli_fetch_array($reservation);
    $firstname = $row2['firstname'];
    $lastname = $row2['lastname'];  
    $currency = $row2['currency'];
}
$vat= 10;
$getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package'");
$row3 = mysqli_fetch_array($getpackage);
$charge= $row3['charge'];
$laundrypackage = $row3['laundrypackage'];
$totalcharge = $clothes * $charge;

$totalvat = (($totalcharge * $vat) / 110);
$htva = $totalcharge - $totalvat;
?>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Laundry Bill Payment | Hotel Manager</title>
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
   <!-- Data Tables -->
   <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
   <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
   <link href="css/animate.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">
</head>
<body>
   <?php
   if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
      include 'fr/addbillpayment.php';
   } else {
   ?>
      <div id="wrapper">
         <?php
         include 'nav.php';
         ?>
         <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
               <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                  <div class="navbar-header">
                     <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                  </div>               
               </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
               <div class="col-lg-10">
                  <h2>Add Laundry Bill Payment</h2>
                  <ol class="breadcrumb">
                     <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                     <li>
                        <a href="reservation?id=<?php echo $id; ?>">Laundry</a>
                     </li>
                     <li class="active">
                        <strong>Enter Laundry bill Amount</strong>
                     </li>
                  </ol>
               </div>
               <div class="col-lg-2">
               </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                           <h5>Guest Details</h5>
                        </div>
                        <div class="ibox-content">
                           <?php                         
                           $currencyrate = 1;
                           if (!empty($currency) && $currency !== "USD") {
                              $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status='1'");
                              $curow = mysqli_fetch_array($getcurrencies);
                              $currencyrate = $curow["rate"];
                           }
                           function getForexConvertedAmount($currencyrate, $amount)
                           {
                              return intval($amount) * floatval($currencyrate);
                           }
                       
                           $dollarCharge =  $row3['charge'];
                           $charge = getForexConvertedAmount($currencyrate, $dollarCharge);
                           $totalcharge = $dollarCharge * $clothes;
                           $totalcharge = getForexConvertedAmount($currencyrate, $totalcharge);
                                           
                           $totalbill = $totalcharge;

                           if (isset($_POST['bill'], $_POST['paymentdate'])) {
                              $bill = mysqli_real_escape_string($con, trim($_POST['bill']));
                              $mode = mysqli_real_escape_string($con, trim($_POST['mode']));
                              $paymentdate =  mysqli_real_escape_string($con, strtotime(str_replace('/', '-', $_POST['paymentdate'])));
                              if ($paymentdate > $timenow) {
                                 $errors[] = 'Payment Date Cant be later than current date';
                              }
                              if (is_numeric($bill) == FALSE) {
                                 $errors[] = 'Bill Amount must be in figures';
                              }
                              if (empty($errors)) {
                                 $addpayments =  mysqli_query($con, "INSERT INTO laundrypayments(laundry_id,amount,mode,creator,timestamp/* ,status */) VALUES('$laundry_id','$bill','$mode','" . $_SESSION['emp_id'] . "','$paymentdate'/* ,'1' */)") or die(mysqli_error($con));
                              }
                           }
                           $getpayments = mysqli_query($con, "SELECT SUM(amount) AS totalpaid FROM laundrypayments WHERE laundry_id='$laundry_id'");
                           $payrow = mysqli_fetch_array($getpayments);
                           $paidamount = $payrow['totalpaid'];
                           ?>
                           <div>
                              <div class="feed-activity-list">
                                 <div class="feed-element">
                                    <div class="media-body ">
                                       <strong>Guest Name</strong>. : <?php echo $firstname . ' ' . $lastname; ?> <br>
                                    </div>
                                 </div>

                                 <div class="feed-element">
                                    <div class="media-body ">
                                       <strong>Phone Number</strong>. : <?php echo $phone; ?> <br>
                                    </div>
                                 </div>
                                 <div class="feed-element">
                                    <div class="media-body ">
                                       <strong>Total Bill</strong> : <?php echo number_format($totalbill); ?> <br>
                                    </div>
                                 </div>
                                 <div class="feed-element">
                                    <div class="media-body ">
                                       <strong>Paid Amount</strong> : <?php echo number_format($paidamount); ?> <br>
                                    </div>
                                 </div>

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                           <h5>Add Details</h5>
                           <label class="label label-danger pull-right" style="font-size: 14px">Balance :<?php echo number_format($totalbill - $paidamount); ?></label>
                        </div>
                        <div class="ibox-content">
                           <?php
                           if (isset($_POST['bill'], $_POST['paymentdate'])) {
                              if (!empty($errors)) {
                                 foreach ($errors as $error) {
                           ?>
                             <div class="alert alert-danger"><?php echo $error; ?></div>
                                 <?php
                                  }
                                     } else {
                                 ?>
                                 <div class="alert alert-success">Bill Payment Successfully Added</div>
                            <?php
                                }
                            }
                            ?>
                           <form role="form" method="POST" action="" enctype="multipart/form-data">
                              <div class="form-group">
                                 <label class="font-noraml">Add Bill Payment</label>
                                 <input type="text" name="bill" class="form-control">
                              </div>
                              <div class="form-group">
                                 <label>Payment Mode</label>
                                 <select name="mode" class="form-control mode">
                                    <option value="" selected="selected">Select Mode</option>
                                    <option value="Bonus">Bonus</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit">Credit</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Visa Card">Visa Card</option>
                                    <option value="Lumicash">Lumicash</option>
                                    <option value="Ecocash">Ecocash</option>
                                 </select>
                              </div>
                              <div class="form-group" id="data_1">
                                 <label class="font-noraml">Select Payment Date</label>
                                 <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="paymentdate" class="form-control" required="required" autocomplete="off">
                                 </div>
                              </div>
                              <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Add Payment</strong></button>
                           </form>
                           <div style="clear:both"></div>
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
   <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
   <!-- Custom and plugin javascript -->
   <script src="js/inspinia.js"></script>
   <script src="js/plugins/pace/pace.min.js"></script>
   <!-- Page-Level Scripts -->
   <script>
      $(document).ready(function() {
         $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: "dd/mm/yyyy",
         });

         $('.mode').on('change', function() {
            var getselect = $(this).val();
            if (['Credit', 'Cheque', 'Visa Card', 'Lumicash', 'Ecocash'].includes($getselect)) {
               $('.forcredit').show();
            } else {
               $('.forcredit').hide();
            }
         });
      });
   </script>
</body>
</html>