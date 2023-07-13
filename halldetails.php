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

    <title>Hall Reservaton Details| Hotel Manager</title>

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
        include 'fr/halldetails.php';
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
                        <h2>Personal Details</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li>
                                <a href="hallbookings">Reservation</a>
                            </li>
                            <li class="active">
                                <strong>Reservation Details</strong>
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
                                    $people = $row['people'];
                                    $room_id1 = $row['room_id'];
                                    $charge1 = $row['charge'];
                                    $discount1 = $row['discount'];
                                    $reason1 = $row['reason'];
                                    $description1 = $row['description'];
                                    $country1 = $row['country'];
                                    $creator1 = $row['creator'];
                                    $ocreator1 = $row['ocreator'];
                                    $days = ($checkout1 - $checkin1) / (3600 * 24) + 1;
                                    $purposes = mysqli_query($con, "SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id1'");
                                    $rowc = mysqli_fetch_array($purposes);
                                    $room = $rowc['room'];
                                    //                                                     $charge=$row3['charge']; 

                                    $hallincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalhallincome FROM hallpayments WHERE hallbooking_id='$id'");
                                    $row4 =  mysqli_fetch_array($hallincome);
                                    $totalhallincome = $row4['totalhallincome'];
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

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Hall Buffets</h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $buffets = mysqli_query($con, "SELECT * FROM reservationbuffets WHERE hallbooking_id='$id'") or die(mysqli_error($con));
                                    if (mysqli_num_rows($buffets) > 0) { ?>
                                        <div>
                                            <div class="table-responsive m-t">
                                                <table class="table invoice-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>                                                            
                                                            <th>Qty</th>
                                                            <th>Days</th>
                                                             <th>Total People</th>
                                                            <!-- <th>Sub Total</th> -->

                                                        </tr>
                                                    </thead>
                                                    <tr>
                                                        <?php
                                                        while ($row1 = mysqli_fetch_array($buffets)) {
                                                            $hallbuffet_id = $row1['hallbuffet_id'];
                                                            $price = $row1['price'];
                                                            $days = $row1['days'];
                                                            $qty = $row1['quantity'];
                                                            $otheritems = $row1['otheritems'];
                                                            $getbuffet = mysqli_query($con, "SELECT * FROM hallbuffets WHERE hallbuffet_id='$hallbuffet_id'");
                                                            $row2 = mysqli_fetch_array($getbuffet);
                                                            $buffetname = $row2['buffet'];
                                                            $split = !empty($otheritems) ? explode(',', $otheritems) : [];
                                                            $itemsarray = array();
                                                            foreach ($split as $item_id) {
                                                                $fooditems = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$item_id'");
                                                                $row2 =  mysqli_fetch_array($fooditems);
                                                                $menuitem = $row2['menuitem'];
                                                                array_push($itemsarray, $menuitem);
                                                            }
                                                            $itemslist = implode(', ', $itemsarray);
                                                        ?>
                                                            <td><?php echo $buffetname;  ?></td>                                                            
                                                            <td><?php echo $qty;  ?></td>
                                                            <td><?php echo $days; ?></td>
                                                            <td><?php echo $qty* $days; ?></td>
                                                            <?php /*<td>
                                                                <?php if (!empty($price)) {
                                                                    echo number_format($price);
                                                                } ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $buffetcharge = $days * $people * $price;
                                                                // $buffettotal = $buffettotal + $buffetcharge;
                                                                echo number_format($buffetcharge); ?>
                                                            </td>*/ ?>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                </table>
                                            </div><!-- /table-responsive -->
                                        </div>
                                    <?php
                                    } ?>

                                </div>
                            </div>
                            <?php
                            if ($status1 == 1) { ?>
                                <a href="hallcheckin?id=<?php echo $id; ?>" class="btn btn-sm btn-info" onclick="return confirm_in<?php echo $id; ?>()">Confirm Checkin</a>
                                <a href="cancelhallbooking?id=<?php echo $id; ?>" class="btn btn-sm btn-danger" onclick="return confirm_delete<?php echo $id; ?>()">Cancel Booking</a>
                                <!--<a href="edithallreservation?id=<?php echo $id; ?>" class="btn btn-sm btn-primary">Edit</a>-->
                            <?php } else if ($status1 == 2) { ?>
                                <a href="hallcheckout?id=<?php echo $id; ?>" class="btn btn-sm btn-danger">Checkout</a>
                                <!--<a href="edithallreservation?id=<?php echo $id; ?>" class="btn btn-sm btn-primary">Edit</a>-->
                            <?php } ?>
                            <a href="hallinvoice?id=<?php echo $id; ?>" class="btn btn-sm btn-success">Invoice</a>
                            <a href="hallproforma?id=<?php echo $id; ?>" class="btn btn-sm btn-primary">Proforma</a>
                            <br><br>
                            <a href="edithalldelivery?id=<?php echo $id; ?>" class="btn btn-sm btn-primary">Delivery Note</a>
                            <script type="text/javascript">
                                function confirm_in<?php echo $id; ?>() {
                                    return confirm('You are about To Confirm A check in. Do you want to proceed?');
                                }

                                function confirm_delete<?php echo $id; ?>() {
                                    return confirm('You are about To Remove this Booking. Are you sure you want to proceed?');
                                }
                            </script>
                        </div>
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Reservation Details</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="feed-activity-list">


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
                                                <strong>Description</strong> : <?php echo $description1; ?> <br>
                                            </div>
                                        </div>

                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Status</strong> :
                                                <?php
                                                if ($status1 == 3) {
                                                    echo '<span class="text-danger">GUEST OUT</span>';
                                                } else if ($status1 == 2) {
                                                    echo '<span class="text-success">GUEST IN</span>';
                                                } else if ($status1 == 1) {
                                                    echo '<span class="text-info">BOOKED</span>';
                                                } else if ($status1 == 4) {
                                                    echo '<span class="text-danger">CANCELLED</span>';
                                                }
                                                ?> <br>
                                            </div>
                                        </div>

                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Added By</strong> :
                                                <?php 
                                                $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$ocreator1'");
                                                $row = mysqli_fetch_array($employee);
                                                $employee_id = $row['employee_id'];
                                                $fullname = $row['fullname'];
                                                echo $fullname; ?><br>
                                            </div>
                                        </div>
                                        
                                        <?php if ($status1 == 2 || $status1 == 3) { ?>
                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <?php                                               
                                                if ($status1 == 2) { ?>
                                                    <strong>Checked in By</strong> :
                                                <?php } else if ($status1 == 3) { ?>
                                                    <strong>Checked out By</strong> :
                                                <?php }
                                                $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator1'");
                                                $row = mysqli_fetch_array($employee);
                                                $employee_id = $row['employee_id'];
                                                $fullname = $row['fullname'];
                                                echo $fullname; ?><br>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Amount Paid</strong> : <?php echo  number_format($totalhallincome); ?> <br>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Discount</strong> : <?php echo  $discount1; ?> <br>
                                            </div>
                                        </div>

                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Description</strong> : <?php echo $description1; ?> <br>
                                            </div>
                                        </div>


                                    </div>

                                    <div style="clear:both"></div>
                                </div>
                            </div>

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Other Services</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $getservices = mysqli_query($con, "SELECT * FROM hallservices WHERE hallreservation_id='$id'");
                                    if (mysqli_num_rows($getservices) > 0) {
                                    ?>
                                        <div>
                                            <div class="table-responsive m-t">
                                                <table class="table invoice-table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Service Name</th>
                                                            <th>Qty</th>
                                                            <th>Days</th>
                                                            <!-- <th>Unit Charge</th>
                                                    <th>Sub Total</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = mysqli_fetch_array($getservices)) {
                                                            $service = $row['service'];
                                                            $quantity = $row['quantity'];
                                                            $price = $row['price'];
                                                            $days = $row['days'];
                                                            $getservice = mysqli_query($con, "SELECT * FROM conferenceotherservices WHERE  conferenceotherservice_id='$service'");
                                                            $roww = mysqli_fetch_array($getservice);
                                                            $servicename = stripslashes($roww['service']);
                                                            $servicecharge = $price * $days * $quantity;
                                                            // $totalservices = $servicecharge + $totalservices;
                                                        ?>
                                                            <tr>
                                                                <td><strong><?php echo $servicename;  ?></strong> </td>
                                                                <td><?php echo $quantity;  ?></td>
                                                                <td><?php echo $days; ?></td>
                                                                <?php /*<td><?php echo number_format($price); ?></td>
                                                        <td><?php echo number_format($servicecharge); ?></td> */ ?>
                                                            </tr>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div style="clear:both"></div>
                                </div>
                            </div>

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Other Services 2</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $getservices2 = mysqli_query($con, "SELECT * FROM hallservices2 WHERE hallreservation_id='$id'");
                                    if (mysqli_num_rows($getservices2) > 0) {
                                    ?>
                                        <div>
                                            <div class="table-responsive m-t">
                                                <table class="table invoice-table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Service</th>
                                                            <th>Price</th>

                                                            <!-- <th>Unit Charge</th>
                                                    <th>Sub Total</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = mysqli_fetch_array($getservices2)) {
                                                            $service = $row['service'];
                                                            $price = $row['price'];
                                                            // $totalservices = $servicecharge + $totalservices;
                                                        ?>
                                                            <tr>
                                                                <td><strong><?php echo $service;  ?></strong> </td>
                                                                <td><?php echo number_format($price);  ?></td>
                                                                <?php /*<td><?php echo number_format($price); ?></td>
                                                        <td><?php echo number_format($servicecharge); ?></td> */ ?>
                                                            </tr>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php } ?>
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