<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
$start = strtotime($_GET['st'] . ' ' . $_GET['stt']);
$end = strtotime($_GET['en'] . ' ' . $_GET['ent']);
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym and Pool Invoices | Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/poolsubscriptions.php';
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
                        <h2>Gym and Pool Invoices between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li class="active">
                                <strong>View Invoices</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>All Gym & Pool Subscriptions <small>Sort, search</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $subscriptions = mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status='1' AND timestamp>='$start' AND timestamp<='$end' ORDER BY poolsubscription_id DESC");
                                    if (mysqli_num_rows($subscriptions) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer</th>
                                                    <th>Phone</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Package</th>
                                                    <th>Charge</th>
                                                    <th>Added By</th>
                                                    <th>Resident</th>
                                                    <th>Reduction</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($subscriptions)) {
                                                    $poolsubscription_id = $row['poolsubscription_id'];
                                                    $firstname = $row['firstname'];
                                                    $lastname = $row['lastname'];
                                                    $phone = $row['phone'];
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
                                                    if (isset($reserve_id) && $reserve_id > 0) {
                                                        $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                                        if (mysqli_num_rows($reservation) > 0) {
                                                            $row2 =  mysqli_fetch_array($reservation);
                                                            $firstname = $row2['firstname'];
                                                            $lastname = $row2['lastname'];
                                                            $room_id = $row2['room'];
                                                            $contact = $row2['phone'];
                                                            $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                            $row1 =  mysqli_fetch_array($roomtypes);
                                                            $roomnumber = $row1['roomnumber'];
                                                            $customername = $firstname . ' ' . $lastname . ' (' . $roomnumber . ')';
                                                        }
                                                    }
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

                                                ?>
                                                    <tr class="gradeA">
                                                        <td><?php echo $invoice_no; ?></td>
                                                        <td><?php echo $customername; ?></td>
                                                        <td><?php echo $phone; ?></td>
                                                        <td><?php echo date('d/m/Y', $startdate); ?></td>
                                                        <td><?php echo date('d/m/Y', $enddate); ?></td>
                                                        <td><?php echo $poolpackage; ?></td>
                                                        <td><?php echo $charge; ?></td>
                                                        <td><?php
                                                            $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                            $row = mysqli_fetch_array($employee);
                                                            $employee_id = $row['employee_id'];
                                                            $fullname = $row['fullname'];
                                                            echo $fullname;  ?></td>

                                                        <td> <?php if ($reserve_id > 0) {
                                                                    echo 'Yes';
                                                                } else {
                                                                    echo 'No';
                                                                } ?> </td>

                                                        <td><?php echo $reduction; ?></td>
                                                        <td>
                                                            <?php
                                                            $now = time();
                                                            if ($now < $startdate)
                                                                echo "Pending";
                                                            else if ($now > strtotime("+1 day", $enddate))
                                                                echo "Expired";
                                                            else
                                                                echo "Valid";
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="poolsubscriptionprint?id=<?php echo $poolsubscription_id; ?>" class="btn btn-xs btn-primary">View</a>
                                                            <a href="addgympoolpayment?id=<?php echo $poolsubscription_id; ?>" class="btn btn-xs btn-info">Edit</a>
                                                            <?php   if ($_SESSION['sysrole'] == 'manager') { ?>
                                                            <a href="confirmpoolsubscription?id=<?php echo $poolsubscription_id; ?>" class="btn btn-xs btn-info" 
                                                            onclick="return confirm_reservation<?php echo $poolsubscription_id; ?>()">Confirm</a>
                                                            <?php } ?>
                                                            <a href="removepoolsubscription?id=<?php echo $poolsubscription_id;?>" 
                                                            class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $poolsubscription_id; ?>()">
                                                            <i class="fa fa-delete"></i>Cancel</a>
                                                            <script type="text/javascript">
                                                                function confirm_delete<?php echo $poolsubscription_id; ?>() {
                                                                return confirm('You are about To Remove this Request. Are you sure you want to proceed?');
                                                                }
                                                                function confirm_reservation<?php echo $poolsubscription_id; ?>() {
                                                                return confirm('You are about To Confirm this Request. Are you sure you want to proceed?');
                                                                }
                                                            </script> 
                                                            </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert alert-danger"> No Subscriptions Added Yet</div>
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