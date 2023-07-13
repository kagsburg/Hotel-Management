<?php
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

    <title>Confirm Hall Checkout | Hotel Manager</title>

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
        include 'fr/hallcheckout.php';
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
                                <a href="hallbookings">Reservation</a>
                            </li>
                            <li class="active">
                                <strong>Enter Actual Checkout date</strong>
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
                                    $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE hallreservation_id='$id'");
                                    $row =  mysqli_fetch_array($reservations);
                                    $hallreservation_id1 = $row['hallreservation_id'];
                                    $fullname1 = $row['fullname'];
                                    $checkin1 = $row['checkin'];
                                    $phone1 = $row['phone'];
                                    $checkout1 = $row['checkout'];
                                    $status1 = $row['status'];
                                    $people1 = $row['people'];
                                    $purpose1 = $row['purpose'];
                                    $description1 = $row['description'];
                                    $country1 = $row['country'];
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
                                                    <strong>Expected Check Out</strong> : <?php echo date('d/m/Y', $checkout1); ?> <br>
                                                </div>
                                            </div>

                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>People</strong> : <?php echo $people1; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Purpose</strong> : <?php
                                                                                $purposes = mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose1'");
                                                                                $row3 = mysqli_fetch_array($purposes);
                                                                                $hallpurpose_id = $row3['hallpurpose_id'];
                                                                                $hallpurpose = $row3['hallpurpose'];
                                                                                $charge = $row3['charge'];
                                                                                echo  $hallpurpose; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Description</strong> : <?php echo $description1; ?> <br>
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
                                    <h5>Add Checkout Details</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['amount'], $_POST['actualcheckout'])) {
                                        $actualcheckout =  mysqli_real_escape_string($con, strtotime(str_replace('/', '-', $_POST['actualcheckout'])));
                                        $amount =  mysqli_real_escape_string($con, trim($_POST['amount']));
                                        if (empty($actualcheckout)) {
                                            $errors[] = 'Select Date to Proceed';
                                        }
                                        if (!empty($amount)) {
                                            if (is_numeric($amount) == FALSE) {
                                                $errors[] = 'Amount should be an integer';
                                            }
                                        }
                                        if ($actualcheckout > $timenow) {
                                            $errors[] = 'Actual Checkout Date Cant be later than Current Date';
                                        }
                                        if ($actualcheckout < $checkin1) {
                                            $errors[] = 'Actual Checkout Date Cant be before Checkin Date';
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                    ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php
                                            }
                                        } else {
                                            $update =  mysqli_query($con, "UPDATE hallreservations SET status='3',checkout='$actualcheckout',creator='" . $_SESSION['emp_id'] . "' WHERE hallreservation_id='$id'");
                                            if (!empty($amount)) {
                                                $addpayment =  mysqli_query($con, "INSERT INTO hallpayments(hallbooking_id,amount,mode,creator,timestamp) VALUES('$id','$amount','$mode','" . $_SESSION['emp_id'] . "',UNIX_TIMESTAMP())") or die(mysqli_error($con));
                                            }
                                            ?>
                                            <div class="alert alert-success">Hall checkout Successfully Updated <a href="<?php echo 'hallinvoice?id=' . $id; ?>">Click Here</a> to View Invoice</div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                                        <div class="form-group" id="data_1">
                                            <label class="font-noraml">Select Actual Checkout Date</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="actualcheckout" autocomplete="off" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-8 control-label"> Add Payment if Guest is unreserved</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name='amount' placeholder="Enter Amount in figures">
                                                <div class="hr-line-dashed"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label class="control-label">Payment Method</label>
                                            <div class="">
                                                <select class="form-control" name='mode'>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Visa">Visa</option>
                                                    <option value="Cheque">Cheque</option>
                                                </select>
                                                <div class="hr-line-dashed"></div>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Confirm checkout</strong></button>

                                    </form>
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