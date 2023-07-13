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
    <title>Confirmed Laundry Invoices | Hotel Manager</title>
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
        include 'fr/laundrywork.php';
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
                        <h2>Hotel Confirmed Laundry Invoices between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="laundrywork">Laundry </a>
                            </li>
                            <li class="active">
                                <strong>View Confirmed Invoices</strong>
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
                                    <h5>All Confirmed Laundry Invoices <small>Sort, search</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $totallaundry = 0;
                                    // $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status IN (0,1) AND timestamp>='$start' AND timestamp<='$end' ORDER BY laundry_id DESC");
                                    $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='3' AND timestamp>='$start' AND timestamp<='$end' ORDER BY laundry_id DESC");
                                    if (mysqli_num_rows($laundry) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Client</th>
                                                    <th>Phone</th>
                                                    <th>Resident</th>
                                                    <th>Clothes</th>
                                                    <th>Unit Charge</th>
                                                    <th>Added on</th>
                                                    <th>Status</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($laundry)) {
                                                    $laundry_id = $row['laundry_id'];
                                                    $reserve_id = $row['reserve_id'];
                                                    $clothes = $row['clothes'];
                                                    $package_id = $row['package_id'];
                                                    $charge = $row['charge'];
                                                    $customername = $row['customername'];
                                                    $phone = $row['phone'];
                                                    $timestamp = $row['timestamp'];
                                                    $status = $row['status'];
                                                    $creator = $row['creator'];
                                                    $getyear = date('Y', $timestamp);
                                                    $count = 1;
                                                    $beforeorders =  mysqli_query($con, "SELECT * FROM laundry WHERE status IN (0,1) AND  laundry_id<'$laundry_id'") or die(mysqli_error($con));
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
                                                    $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                                    if (mysqli_num_rows($reservation) > 0) {

                                                        $row2 =  mysqli_fetch_array($reservation);
                                                        $firstname = $row2['firstname'];
                                                        $lastname = $row2['lastname'];
                                                        $room_id = $row2['room'];
                                                        $phone = $row2['phone'];
                                                        $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                        $row1 =  mysqli_fetch_array($roomtypes);
                                                        $roomnumber = $row1['roomnumber'];
                                                        $customername = $firstname . ' ' . $lastname . ' (' . $roomnumber . ')';
                                                    }
                                                    $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                                                    $row3 = mysqli_fetch_array($getpackage);
                                                    $laundrypackage = $row3['laundrypackage'];

                                                ?>

                                                    <tr class="gradeA">
                                                        <td><?php echo $invoice_no; ?></td>
                                                        <td><?php echo $customername; ?></td>
                                                        <td> <?php echo $phone; ?> </td>
                                                        <td> <?php if ($reserve_id > 0) {
                                                                    echo 'Yes';
                                                                } else {
                                                                    echo 'No';
                                                                } ?> </td>

                                                        <td><?php echo $clothes; ?></td>
                                                        <td><?php echo $laundrypackage ?></td>
                                                        <td>
                                                            <div class="text-info"><?php echo date('d/m/Y', $timestamp); ?></div>
                                                        </td>
                                                        <td><?php if ($status == 1) {
                                                                echo '<span class="text-success">Finished</span>';
                                                            }
                                                            if ($status == 0) {
                                                                echo '<span class="text-warning">Pending</span>';
                                                            }
                                                            ?></td>
                                                        <!-- <td>
                                                           <?php 
                                                            if ($status == 1) { ?>
                                                                <a href="laundryinvoice_print?id=<?php echo $laundry_id; ?>" class="btn btn-xs btn-info" target="_blank">View</a>
                                                            <?php } ?>  
                                                            <a href="editlaundry?id=<?php echo $laundry_id; ?>" class="btn btn-xs btn-info">Edit</a>
                                                            <?php   if ($_SESSION['sysrole'] == 'manager') { ?>
                                                            <a href="confirmlaundry?id=<?php echo $laundry_id; ?>" class="btn btn-xs btn-info" 
                                                            onclick="return confirm_reservation<?php echo $laundry_id; ?>()">Confirm</a>
                                                            <?php } ?>
                                                                <a href="removelaundry?id=<?php echo $laundry_id;?>" 
                                                            class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $laundry_id; ?>()">
                                                            <i class="fa fa-delete"></i>Cancel</a>
                                                        <script type="text/javascript">
                                                            function confirm_delete<?php echo $laundry_id; ?>() {
                                                            return confirm('You are about To Remove this Request. Are you sure you want to proceed?');
                                                            }
                                                            function confirm_reservation<?php echo $laundry_id; ?>() {
                                                            return confirm('You are about To Confirm this Request. Are you sure you want to proceed?');
                                                            }
                                                        </script>                                                           
                                                        </td> -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert  alert-danger">Oops!! No New Reservations Made Yet</div>
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