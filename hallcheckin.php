<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
$id = $_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Confirm Hall Checkin | Hotel Manager</title>

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
        include 'fr/hallcheckin.php';
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
                        <h2>Checking in Hall Guest</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li>
                                <a href="hallbookings">Reservation</a>
                            </li>
                            <li class="active">
                                <strong>Checkin Confirm</strong>
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
                                    <h5>Reservation Details</h5>

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
                                    $room_id1 = $row['room_id'];
                                    $charge1 = $row['charge'];
                                    $discount1 = $row['discount'];
                                    $reason1 = $row['reason'];
                                    $description1 = $row['description'];
                                    $country1 = $row['country'];
                                    $creator1 = $row['creator'];
                                    $days = ($checkout1 - $checkin1) / (3600 * 24) + 1;
                                    $purposes = mysqli_query($con, "SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id1'");
                                    $rowc = mysqli_fetch_array($purposes);
                                    $room = $rowc['room'];
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
                                                    <strong>Room</strong> : <?php
                                                                            $purposes = mysqli_query($con, "SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id1'");
                                                                            $rowc = mysqli_fetch_array($purposes);
                                                                            $room = $rowc['room'];
                                                                            echo  $room; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Rate / Day</strong> : <?php echo $charge1; ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Reason</strong>. : <?php echo $reason1; ?> <br>
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Add Check In Details</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['amount'], $_POST['actualcheckin'])) {
                                        $actualcheckin =  mysqli_real_escape_string($con, strtotime(str_replace('/', '-', $_POST['actualcheckin'])));
                                        $amount =  mysqli_real_escape_string($con, trim($_POST['amount']));
                                        $confirmmode =  mysqli_real_escape_string($con, trim($_POST['confirmmode']));
                                        if (empty($actualcheckin)) {
                                            $errors[] = 'Select Date to Proceed';
                                        }
                                        if (!empty($amount)) {
                                            if (is_numeric($amount) == FALSE) {
                                                $errors[] = 'Amount should be an integer';
                                            }
                                        }
                                        if ($actualcheckin > $timenow) {
                                            $errors[] = 'Actual Checkin Date Cant be later than Current Date';
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                    ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php
                                            }
                                        } else {
                                            $update = mysqli_query($con, "UPDATE hallreservations SET status='2',checkin='$actualcheckin',confirmmode='$confirmmode',creator='" . $_SESSION['emp_id'] . "' WHERE hallreservation_id='$id'");
                                            if (!empty($amount)) {
                                                $addpayment =  mysqli_query($con, "INSERT INTO hallpayments(hallbooking_id,amount,creator,timestamp)  VALUES('$id','$amount','" . $_SESSION['emp_id'] . "',UNIX_TIMESTAMP())");
                                            }
                                            ?>
                                            <div class="alert alert-success">Hall checkin Successfully Updated <a target="_blank" href="<?php echo 'hallinvoice_print?id=' . $id; ?>">Click Here</a> to View Invoice</div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                                        <div class="form-group" id="data_1">
                                            <label class="font-noraml">Select Actual Checkin Date</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="actualcheckin" class="form-control" required="required" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="control-label"> Any Advance Payment if guest not reserved</label>
                                            <input type="text" class="form-control" name='amount' placeholder="Enter Amount in figures">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Method Of Confirmation</label>
                                            <select class="form-control" name='confirmmode'>
                                                <option value="Cash">Cash</option>
                                                <option value="E-mail">E-mail</option>
                                                <option value="Purchase Order">Purchase Order</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Confirm checkin</strong></button>

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