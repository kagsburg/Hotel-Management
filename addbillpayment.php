<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$id = $_GET['id'];
//header('Location:'.$_SERVER['HTTP_REFERER']);
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bill Payment | Hotel Manager</title>
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
                        <ul class="nav navbar-top-links navbar-right">
                            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                            <li><a href="switchlanguage?lan=en">English</a> </li>
                        </ul>
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Add Bill Payment</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="reservation?id=<?php echo $id; ?>">Reservation</a>
                            </li>
                            <li class="active">
                                <strong>Enter bill Amount</strong>
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
                                $checkedouts =  mysqli_query($con, "SELECT * FROM checkoutdetails WHERE checkoutdetails_id='$id'");
        $row2 =  mysqli_fetch_array($checkedouts);
        $checkoutdetails_id = $row2['checkoutdetails_id'];
        $reserve_id = $row2['reserve_id'];
        $paidamount = $row2['paidamount'];
        $totalbill = $row2['totalbill'];
        $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
        $row =  mysqli_fetch_array($reservations);
        $reservation_id = $row['reservation_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $checkin = $row['checkin'];
        $phone = $row['phone'];
        //$id_number=$row['id_number'];
        $checkout = $row['checkout'];
        $actualcheckout = $row['actualcheckout'];
        $room_id = $row['room'];
        $email = $row['email'];
        $status = $row['status'];
        $creator = $row['creator'];
        // $paidby = $row['paidby'];
        // $nationality = $row['nationality'];
        //  $orgcontact=$row['orgcontact'];
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
                                                    <strong>Checked Out On</strong> : <?php echo date('d/m/Y', $actualcheckout); ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Room Number: </strong>
                                                    <?php
                        $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
        $row1 =  mysqli_fetch_array($getnumber);
        $roomnumber = $row1['roomnumber'];
        $type_id = $row1['type'];
        echo $roomnumber; ?>
                                                    . <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Total Bill</strong> : TSHS <?php echo number_format($totalbill); ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Paid Amount</strong> : TSHS <?php echo number_format($paidamount); ?> <br>
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
                                    <label class="label label-danger pull-right" style="font-size: 14px">Balance : TSHS
                                    <?php echo number_format($totalbill - $paidamount); ?></label>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['bill'], $_POST['paymentdate'])) {
                                        $bill = mysqli_real_escape_string($con, trim($_POST['bill']));
                                        $paymentdate =  mysqli_real_escape_string($con, strtotime($_POST['paymentdate']));
                                        $mode =  mysqli_real_escape_string($con, strtotime($_POST['mode']));
                                        if ($paymentdate > $timenow) {
                                            $errors[] = 'Payment Date Cant be later than current date';
                                        }
                                        if (is_numeric($bill) == false) {
                                            $errors[] = 'Bill Amount must be in figures';
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                                ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php
                                            }
                                        } else {
                                            $adddetails =  mysqli_query($con, "UPDATE checkoutdetails SET paidamount=paidamount+'$bill' WHERE checkoutdetails_id='$id'");
                                            // $addpayments =  mysqli_query($con, "INSERT INTO checkoutpayments(checkout_id,amount,timestamp) VALUES('$id','$bill','$paymentdate')");
                                            $addpayments =  mysqli_query($con, "INSERT INTO payments(reservation_id,amount,mode,timestamp,status) VALUES('$id','$bill','$mode','$paymentdate','1')")
                                            or die(mysqli_error($con));

                                            ?>
                                            <div class="alert alert-success">Bill Payment Successfully Updated</div>
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
                                    <option value="bank">Bank</option>
                                    <option value="mobile money">Mobile Money</option>
                                 </select>
                              </div>
                                        <div class="form-group" id="data_1">
                                            <label class="font-noraml">Select Payment Date</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="paymentdate" 
                                                class="form-control" required="required">
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
        });
    </script>
</body>
</html>