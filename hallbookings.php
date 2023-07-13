<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hall Reservations | Hotel Manager</title>

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
        include 'fr/hallbookings.php';
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
                        <h2>Hall Bookings</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>


                            <li class="active">
                                <strong>View Hall Bookings</strong>
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
                                    <h5>All Hall Bookings <small>Sort, search</small></h5>
                                    <a href="hallreservecsv" target="_blank" class="btn btn-sm  btn-primary pull-right">Export to Excel</a> <a href="hallreserveprint" target="_blank" class="btn btn-sm btn-warning pull-right"> Print PDF</a>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE status IN (1,2)  ORDER BY hallreservation_id DESC");
                                    if (mysqli_num_rows($reservations) > 0) {

                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Guest</th>
                                                    <th>phone</th>
                                                    <th>People</th>
                                                    <th>Dates</th>
                                                    <th>Room</th>
                                                    <th>Created By</th>
                                                    <th>Status</th>
                                                    <th>Payment Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($reservations)) {
                                                    $hallreservation_id = $row['hallreservation_id'];
                                                    $fullname = $row['fullname'];
                                                    $checkin = $row['checkin'];
                                                    $phone = $row['phone'];
                                                    $checkout = $row['checkout'];
                                                    $people = $row['people'];
                                                    $status = $row['status'];
                                                    $payment_status = $row['payment_status'];
                                                    $room_id = $row['room_id'];

                                                    $description = $row['description'];
                                                    $country = $row['country'];
                                                    $creator = $row['ocreator'];
                                                    $timestamp = $row['timestamp'];
                                                    $getyear = date('Y', $timestamp);
                                                    $count = 1;
                                                    $beforeorders =  mysqli_query($con, "SELECT * FROM hallreservations WHERE status=1  AND hallreservation_id<'$hallreservation_id'") or die(mysqli_error($con));
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

                                                ?>

                                                    <tr class="gradeA">
                                                        <td><?php echo str_pad($hallreservation_id, 6, "0", STR_PAD_LEFT); ?></td>
                                                        <td><?php echo $fullname; ?></td>
                                                        <td><?php echo $phone; ?></td>
                                                        <td><?php
                                                            echo $people;
                                                            ?></td>
                                                        <td><?php echo date('d/m/Y', $checkin) . ' to ' . date('d/m/Y', $checkout); ?></td>
                                                        <td>
                                                            <?php
                                                            $purposes = mysqli_query($con, "SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id'");
                                                            $rowc = mysqli_fetch_array($purposes);
                                                            $room = $rowc['room'];
                                                            echo $room; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                            $row = mysqli_fetch_array($employee);
                                                            $employee_id = $row['employee_id'];
                                                            $fullname = $row['fullname'];
                                                            echo $fullname; ?>
                                                        </td>
                                                        <td><?php
                                                            if ($status == 1) {
                                                                echo 'BOOKED';
                                                            } else if ($status == 2) {
                                                                echo 'CHECKED IN';
                                                            }
                                                            ?></td>
                                                        <td><?php echo $payment_status; ?></td>
                                                        <td>
                                                            <a href="edithallreservation?id=<?php echo $hallreservation_id; ?>" class="btn btn-xs btn-info">Edit</a>
                                                            <a href="halldetails?id=<?php echo $hallreservation_id; ?>" class="btn btn-xs btn-success">Details</a>
                                                            <!-- <a href="hallconfirmpayment?id=<?php echo $hallreservation_id ?>" class="btn btn-xs btn-success">Confirm Payment</a> -->
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert alert-danger"> No Hall Reservations Added Yet</div>
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


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:48 GMT -->

</html>