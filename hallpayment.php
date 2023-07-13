<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$hallreservation_id = $_GET['id'];
$reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE hallreservation_id='$hallreservation_id'");
    $row =  mysqli_fetch_array($reservations);
    $hallreservation_id1 = $row['hallreservation_id'];
    $fullname1 = $row['fullname'];
    $checkin1 = $row['checkin'];
    $phone1 = $row['phone'];
    $checkout1 = $row['checkout'];
    $status1 = $row['status'];
    $people1 = $row['people'];
    $vat= $row['vat'];

    $charge = $row['charge'];     
    $days = ($checkout1 - $checkin1) / (3600 * 24) + 1;
    $vatamount = ($days * $charge * $vat) / 100;
    $roomtotal = ($charge * $days) + $vatamount;  

    $description1 = $row['description'];
    $country1 = $row['country'];
    $hallincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalhallincome FROM hallpayments WHERE hallbooking_id='$hallreservation_id'");
    $row4 =  mysqli_fetch_array($hallincome);
    $totalhallincome = $row4['totalhallincome'];

    $buffettotal = 0;
    $buffets = mysqli_query($con, "SELECT * FROM reservationbuffets WHERE hallbooking_id='$hallreservation_id'");
    if (mysqli_num_rows($buffets) > 0) {
        while ($row1 = mysqli_fetch_array($buffets)) {
            $hallbuffet_id = $row1['hallbuffet_id'];
            $price = $row1['price'];
            $days = $row1['days'];
            $buffetcharge = $days * $people1 * $price;
            $buffettotal = $buffettotal + $buffetcharge;
        }
    }
    $totalservices = 0;
    $getservices = mysqli_query($con, "SELECT * FROM hallservices WHERE hallreservation_id='$hallreservation_id'");
    if (mysqli_num_rows($getservices) > 0) {
        while ($row5 = mysqli_fetch_array($getservices)) {
            $service = $row5['service'];
            $quantity = $row5['quantity'];
            $price = $row5['price'];
            $days = $row5['days'];
            $servicecharge = $price * $days * $quantity;
            $totalservices = $servicecharge + $totalservices;
        }
    }

    $totalservices2 = 0;
    $getservices2 = mysqli_query($con, "SELECT * FROM hallservices2 WHERE hallreservation_id='$hallreservation_id'");
    if (mysqli_num_rows($getservices2) > 0) {
        while ($row6 = mysqli_fetch_array($getservices2)) {
            $service = $row6['service'];
            $price = $row6['price'];
            $totalservices2 += $price;
        }
    }

    $totalcharge = $roomtotal + $buffettotal + $totalservices + $totalservices2;
    $balance = $totalcharge - $totalhallincome;
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hall Payment | Hotel Manager</title>
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
        include 'fr/hallpayment.php';
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
                        <h2>Checking Out Hall Guests</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="halluncleared.php">Hall Payment</a>
                            </li>
                            <li class="active">
                                <strong>Enter Payment</strong>
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
                                            $addpayments =  mysqli_query($con, "INSERT INTO hallpayments(hallbooking_id,amount,creator,timestamp) 
                                            VALUES('$hallreservation_id1','$bill','" . $_SESSION['emp_id'] . "','$paymentdate'/* ,'1' */)") or die(mysqli_error($con));
                                        }
                                    }
                                    
                                    ?>
                                    <div>
                                        <div class="feed-activity-list">
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Full Name</strong>. : <?php echo $fullname1; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Country</strong>. : <?php echo $country1; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Phone Number</strong>. : <?php echo $phone1; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Check In</strong> : <?php echo date('d/m/Y', $checkin1); ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Check Out</strong> : <?php echo date('d/m/Y', $checkout1); ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>People</strong> : <?php echo $people1; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Description</strong> : <?php echo $description1; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                <strong>Total Bill</strong> : <?php echo number_format($totalcharge); ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Paid Amount</strong> : <?php echo $totalhallincome; ?> <br>
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
                           <label class="label label-danger pull-right" style="font-size: 14px">Balance :<?php echo number_format($totalbill - $totalhallincome); ?></label>
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
                        <!-- <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                            <h5>Add Details</h5>
                           <label class="label label-danger pull-right" style="font-size: 14px">Balance :<?php echo number_format($totalbill - $paidamount); ?></label>
                        </div>
                        <div class="ibox-content">
                           <?php
                        //    if (isset($_POST['bill'], $_POST['paymentdate'])) {
                        //       if (!empty($errors)) {
                        //          foreach ($errors as $error) {
                           ?>
                             <div class="alert alert-danger"><?php echo $error; ?></div>
                                 <?php
                                //   }
                                //      } else {
                                 ?>
                                 <div class="alert alert-success">Subscription Payment Successfully Added</div>
                            <?php
                            //     }
                            // }
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
                           </form>    <h5>Add Checkout Details</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    // if (isset($_POST['amount'], $_POST['paymentdate'])) {
                                    //     $paymentdate =  mysqli_real_escape_string($con, strtotime(str_replace('/', '-', $_POST['paymentdate'])));
                                    //     $amount =  mysqli_real_escape_string($con, trim($_POST['amount']));
                                    //     if (empty($paymentdate)) {
                                    //         $errors[] = 'Select Date to Proceed';
                                    //     }
                                    //     if (!empty($amount)) {
                                    //         if (is_numeric($amount) == FALSE) {
                                    //             $errors[] = 'Amount should be an integer';
                                    //         }
                                    //     }
                                    //     if (!empty($errors)) {
                                    //         foreach ($errors as $error) {
                                    ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php
                                        //     }
                                        // } else {
                                        //     $addpayment =  mysqli_query($con, "INSERT INTO hallpayments(hallbooking_id,amount,creator,timestamp) VALUES('$id','$amount','" . $_SESSION['emp_id'] . "',UNIX_TIMESTAMP())");

                                            ?>
                                            <div class="alert alert-success">Hall Bill Payment Successfully Updated <a href="<?php echo 'hallinvoice?id=' . $id; ?>" target="_blank">Click Here</a> to View Invoice</div>
                                    <?php
                                    //     }
                                    // }
                                    ?>
                                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                                        <div class="form-group" id="data_1">
                                            <label class="font-noraml">Select Payment Date</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="paymentdate" autocomplete="off" class="form-control" placeholder="Select payment Date" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-8 control-label"> Add Payment</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name='amount' placeholder="Enter Amount in figures" required="required">
                                                <div class="hr-line-dashed"></div>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Add Payment</strong></button>
                                    </form> -->
                                    <div style="clear:both"></div>
                                </div>
                            </div>
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
        });
    </script>
</body>
</html>