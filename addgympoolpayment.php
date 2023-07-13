<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
}
$poolsubscription_id=$_GET['id'];
$vat = 10;
$subscriptions = mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE poolsubscription_id='$poolsubscription_id'");
$row =  mysqli_fetch_array($subscriptions);
$poolsubscription_id = $row['poolsubscription_id'];
$firstname = $row['firstname'];
$lastname = $row['lastname'];
$contact = $row['phone'];
$startdate = $row['startdate'];
$enddate = $row['enddate'];
$reduction = $row['reduction'];
$charge = $row['charge'];
$creator = $row['creator'];
$package = $row['package'];
$reserve_id = $row['reserve_id'];
$timestamp = $row['timestamp'];
$getyear = date('Y', $timestamp);
$customername = $firstname . ' ' . $lastname;
$count = 1;
$beforeorders =  mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status=1  AND  poolsubscription_id<'$poolsubscription_id'") or die(mysqli_error($con));
while ($rowb = mysqli_fetch_array($beforeorders)) {
    $timestamp2 = $rowb['timestamp'];
    $getyear2 = date('Y', $timestamp2);
    if ($getyear == $getyear2) {
        $count = $count + 1;
    }
}
if (strlen($count) == 1) {
    $invoice_no = '000' . $count;
}
if (strlen($count) == 2) {
    $invoice_no = '00' . $count;
}
if (strlen($count) == 3) {
    $invoice_no = '0' . $count;
}
if (strlen($count) >= 4) {
    $invoice_no = $count;
}
$getpackage = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
$row1 = mysqli_fetch_array($getpackage);
$poolpackage = $row1['poolpackage'];
$days = $row1['days'] - 1;
$enddate = strtotime("+{$days} days", $startdate);
$reduction = empty($reduction) ? 0: $reduction;
$totalvat = ((($charge - $reduction) * $vat) / 110);

$htva = $charge - $totalvat - $reduction;
$net = $htva + $totalvat;
?>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Gym & Pool Payment | Hotel Manager</title>
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
                  <h2>Add Gym & Pool Payment</h2>
                  <ol class="breadcrumb">
                     <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                     <li>
                        <a href="reservation?id=<?php echo $id; ?>">Laundry</a>
                     </li>
                     <li class="active">
                        <strong>Enter Gym & Pool Amount</strong>
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
                       
                           $totalcharge = $charge ;
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
                                 $addpayments =  mysqli_query($con, "INSERT INTO gympoolpayments(poolsubscription_id,amount,creator,timestamp) 
                                 VALUES('$poolsubscription_id','$bill','" . $_SESSION['emp_id'] . "','$paymentdate'/* ,'1' */)") or die(mysqli_error($con));
                              }
                           }
                           $getpayments = mysqli_query($con, "SELECT SUM(amount) AS totalpaid FROM gympoolpayments WHERE poolsubscription_id='$poolsubscription_id'");
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
                                       <strong>Phone Number</strong>. : <?php echo $contact; ?> <br>
                                    </div>
                                 </div>
                                 <div class="feed-element">
                                    <div class="media-body ">
                                       <strong>Total Bill</strong> : <?php echo number_format($totalbill); ?> <br>
                                    </div>
                                 </div>
                                 <div class="feed-element">
                                    <div class="media-body ">
                                       <strong>Paid Amount</strong> : <?php echo number_format($paidamount ? $paidamount : 0) ; ?> <br>
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
                                 <div class="alert alert-success">Subscription Payment Successfully Added</div>
                            <?php
                                }
                            }
                            ?>
                           <form role="form" method="POST" action="" enctype="multipart/form-data">
                              <div class="form-group">
                                 <label class="font-noraml">Add Subscription Payment</label>
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