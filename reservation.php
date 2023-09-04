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
    <title>Reservation | Hotel Manager</title>
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
        include 'fr/reservation.php';
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
                        <h2>Hotel Reservation</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li>
                                <a href="reservations">Reservation</a>
                            </li>
                            <li class="active">
                                <strong>View Reservation Details</strong>
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
                                        $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
        $row =  mysqli_fetch_array($reservations);
        $reservation_id = $row['reservation_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $checkin = $row['checkin'];
        $arrivaltime = $row['arrivaltime'];
        $arrivingfrom = $row['arrivingfrom'];
        $departuretime = $row['departuretime'];
        $phone = $row['phone'];
        $email = $row['email'];
        $adults = $row['adults'];
        $kids = $row['kids'];
        $widebed = $row['widebed'];
        $dob = $row['dob'];
        $usdtariff = $row['usdtariff'];
        $currency = $row['currency'];
        $fax = $row['fax'];
        $id_number = $row['id_number'];
        $checkout = $row['checkout'];
        $actualcheckout = $row['actualcheckout'];
        $room_id = $row['room'];
        $email = $row['email'];
        $status = $row['status'];
        $origin = $row['origin'];
        $creator = $row['creator'];
        $occupation = $row['occupation'];
        $business = $row['business'];
        $reduction = $row['reduction'];
        $companyname = $row['companyname'];


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
                                            <?php if ($companyname != ''){
                                                $getcompany = mysqli_query($con, "SELECT * FROM sponsors WHERE sponsor_id='$companyname' and status='1'")or die(mysqli_error($con));
                                                $row = mysqli_fetch_array($getcompany);
                                                $company_name = $row['company_name'];
                                                ?>
                                                <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Sponsor</strong>. : <?php echo $company_name; ?> <br>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Fax</strong>. : <?php echo $fax; ?> <br>
                                                </div>
                                            </div>

                                            <?php
                if (!empty($email)) { ?>
                                                <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Email</strong>. : <?php echo $email; ?> <br>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Added By</strong>. :
                                                    <?php $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
        $row = mysqli_fetch_array($employee);
        $employee_id = $row['employee_id'];
        $fullname = $row['fullname'];
        echo $fullname;  ?> <br>
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
                                    <h5>Reservation Details</h5>
                                </div>
                                <div class="ibox-content">
                                    <div>
                                        <div class="feed-activity-list">
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
                                                    <strong>Room Type: </strong>
                                                    <?php
        $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
        $row1 =  mysqli_fetch_array($roomtypes);
        $roomtype = $row1['roomtype'];
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
                                                    <strong>Currency</strong>. : <?php echo $currency; ?> <br>
                                                </div>
                                            </div>

                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Arrival Date</strong> : <?php echo date('d/m/Y', $checkin); ?> <br>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Arrival Time</strong> : <?php echo $arrivaltime; ?> <br>
                                                </div>
                                            </div>
                                            <?php
                                            if ($status == 2) {
                                                $checkedouts =  mysqli_query($con, "SELECT * FROM checkoutdetails WHERE reserve_id='$id'");
                                                $row2 =  mysqli_fetch_array($checkedouts);
                                                $checkoutdetails_id = $row2['checkoutdetails_id'];
                                                $reserve_id = $row2['reserve_id'];
                                                $paidamount = $row2['paidamount'];
                                                $totalbill = $row2['totalbill'];
                                                ?>
                                                <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Checked Out on</strong> : <?php echo date('d/m/Y', $actualcheckout); ?> <br>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Total Bill</strong> : <?php echo number_format($totalbill); ?> <br>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Paid amount</strong> :
                                                        <?php
                                                            $getpayments = mysqli_query($con, "SELECT SUM(amount) as amountpaid FROM payments WHERE reservation_id='$id'") or die(mysqli_error($con));
                                                $roww = mysqli_fetch_array($getpayments);
                                                $amountpaid = $roww['amountpaid'];
                                                echo number_format($amountpaid); ?> <br>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Expected Departure Date</strong> : <?php echo date('d/m/Y', $checkout); ?> <br>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Expected Departure Time</strong> : <?php echo $departuretime; ?> <br>
                                                    </div>
                                                </div>

                                            <?php   }
                                            if (!empty($reduction)) { ?>
                                                <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Reduction </strong> : <?php echo $reduction; ?><br>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Status</strong> :
                                                    <?php if ($status == 2) {
                                                        echo '<span class="text-danger">GUEST OUT</span>';
                                                    } elseif (($timenow > $checkout) && ($status == 1)) {
                                                        echo '<span class="text-danger">PENDING GUEST OUT</span>';
                                                    } elseif (($timenow <= $checkout) && ($status == 1)) {
                                                        echo '<span class="text-successr">GUEST IN</span>';
                                                    } elseif (($status == 0)) {
                                                        echo '<span class="text-info">PENDING</span>';
                                                    } elseif ($status == 3) {
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
                        <div class="col-lg-12 m-b">
                            <a href="reservationprint?id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Print</a>&nbsp;
                            <?php

                            echo '<a href="editreservation?id=' . $id . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit Info</a>&nbsp;';
        if ($status == 1) {
            echo '<a href="checkoutconfirm?id=' . $id . '" class="btn btn-info btn-sm" onclick="return confirm_delete()"><i class="fa fa-reply"></i> Confirm Checkout</a>&nbsp;';
            echo '<a data-toggle="modal"  href="#modal-form"  class="btn btn-primary btn-sm">Change Checkout Date<i class="fa fa-arrow-right"></i></a>&nbsp;';
        }
        if (($status != 0) && ($status != 3)) {
            echo '<a  href="getbill?id=' . $id . '&&n=' . $firstname . ' ' . $lastname . '"  class="btn btn-success btn-sm">Get Bill <i class="fa fa-eye"></i></a>&nbsp;';
        }
        if ($status == 0) {
            echo '<a href="checkinconfirm?id=' . $reservation_id . '&&st=' . $status . '" class="btn btn-success btn-sm" onclick="return confirm_checkin()"><i class="fa fa-sign-in"></i> Confirm Guest In</a>&nbsp;';
            echo '<a href="cancelbooking?id=' . $id . '" class="btn btn-info btn-sm btn-danger" onclick="return confirm_cancel()"><i class="fa fa-cancel"></i> Cancel booking</a>&nbsp;';
        }
        ?>
                            <a href="proforma?id=<?php echo $id; ?>" class="btn btn-info btn-sm"><i class="fa fa-reply"></i> Proforma</a>
                            <br><br>
                            <a href="addpayment?id=<?php echo $id; ?>" class="btn btn-info btn-sm"><i class="fa fa-money"></i> Add Payment</a>


                            <script type="text/javascript">
                                function confirm_checkin() {
                                    return confirm('You are about To checkin  this guest. Are you sure you want to proceed?');
                                }

                                function confirm_delete() {
                                    return confirm('You are about To checkout  this guest. Are you sure you want to proceed?');
                                }

                                function confirm_cancel() {
                                    return confirm('You are about To checkout  this guest. Are you sure you want to proceed?');
                                }
                            </script>

                        </div>
                        <div class="col-lg-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Other Services</h5>
                                    <a data-toggle="modal" href="#addotherservice" class="btn btn-sm btn-primary pull-right">Add Other Service</a>
                                    <div style="clear: both"></div>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Service</th>
                                                <th>Price</th>
                                                <th>Reduction</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                        $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$id' AND status=1") or die(mysqli_error($con));
        while ($row3 = mysqli_fetch_array($getotherservices)) {
            $otherservice_id = $row3['otherservice_id'];
            $otherservice = $row3['otherservice'];
            $reduction = $row3['reduction'];
            $currency = $row3['currency'];
            $price = $row3['price'];
            $timestamp = $row3['timestamp'];
            ?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                                    <td><?php echo $otherservice;  ?></td>
                                                    <td><?php echo $price;  ?></td>
                                                    <td><?php echo $reduction;  ?></td>
                                                    <td><a href="removeotherservice?id=<?php echo $otherservice_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $otherservice_id; ?>()">Remove</a></td>
                                                </tr>
                                                <script type="text/javascript">
                                                    function confirm_delete<?php echo $otherservice_id; ?>() {
                                                        return confirm('You are about To Remove this Room. Are you sure you want to proceed?');
                                                    }
                                                </script>
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

            </div>
        </div>
        <div id="addotherservice" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" class="form" action='addotherservice?id=<?php echo $id; ?>' name="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label">* Service Name</label>
                                <input type="text" name='servicename' class="form-control" placeholder="Enter Service Name" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">* Service Price</label>
                                <input type="text" name='serviceprice' class="form-control" placeholder="Enter Service Price" required="required">
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label">Currency</label>
                                <select class="form-control" name="currency">
                                    <option value="" selected="selected">Select ...</option>
                                    <option value="TSHS">TSHS</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label class="control-label">Reduction</label>
                                <input type="text" name='reduction' class="form-control" placeholder="Enter Reduction">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-info" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form role="form" method="POST" action="extendstay?id=<?php echo $id; ?>&&check=<?php echo $checkout; ?>" enctype="multipart/form-data">
                                    <div class="form-group" id="data_1">
                                        <label class="font-noraml">Select New checkout Date</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="newcheckout" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Change Date</strong></button>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="modal-form2" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form role="form" method="POST" action="?id=<?php echo $id; ?>" enctype="multipart/form-data">
                                    <div class="form-group" id="data_1">
                                        <label class="font-noraml">Select New checkout Date</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="newcheckout" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Change Date</strong></button>

                                </form>
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