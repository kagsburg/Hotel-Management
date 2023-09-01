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

    <title>Guests Out Pending | Hotel Manager</title>

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
        include 'fr/pendingouts.php';
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
                        <h2>Hotel Guest Outs Pending </h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

                            <li>
                                <a>Reservations</a>
                            </li>
                            <li class="active">
                                <strong>View guests Out Pending</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-group fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Hotel Guest Outs Pending</span>
                                        <h2 class="font-bold"><?php
                                                                $date = strtotime(date('Y-m-d'));
                                                                $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE checkout<'$date' AND status='1' ORDER BY reservation_id DESC");
                                                                echo mysqli_num_rows($reservations);
                                                                ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>All Guests <small>Sort, search</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php

                                    if (mysqli_num_rows($reservations) > 0) {

                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Guest</th>
                                                    <th>Room Number</th>
                                                    <th>Check In</th>
                                                    <th>Check Out</th>
                                                    <th>Status</th>
                                                    <th>Added By</th>
                                                    <th>Action</th>
                                                    <!--<th>Action</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($reservations)) {
                                                    $reservation_id = $row['reservation_id'];
                                                    $firstname = $row['firstname'];
                                                    $lastname = $row['lastname'];
                                                    $checkin = $row['checkin'];
                                                    $phone = $row['phone'];
                                                    $checkout = $row['checkout'];
                                                    $room_id = $row['room'];
                                                    $email = $row['email'];
                                                    $status = $row['status'];

                                                    $creator = $row['creator'];

                                                ?>

                                                    <tr class="gradeA">
                                                        <td><?php echo $firstname . ' ' . $lastname; ?></td>

                                                        <td class="center">
                                                            <?php
                                                            $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                            $row1 =  mysqli_fetch_array($roomtypes);
                                                            $roomtype = $row1['roomnumber'];
                                                            echo $roomtype; ?>
                                                        </td>
                                                        <td><?php echo date('d/m/Y', $checkin); ?></td>
                                                        <td><?php echo date('d/m/Y', $checkout); ?></td>
                                                        <td><?php
                                                            if (($timenow > $checkout) && ($status == 2)) {
                                                                echo '<div class="text-danger">guest out</div>';
                                                            } else if (($timenow > $checkout) && ($status == 1)) {
                                                                echo '<div class="text-danger">Pending guest out</div>';
                                                            } else if ($timenow < $checkout) {
                                                                echo '<div class="text-danger">guest in</div>';
                                                            }
                                                            ?></td>
                                                        <td>
                                                            <div class="tooltip-demo">

                                                                <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile" data-toggle="tooltip" data-placement="bottom" title="">
                                                                    <?php
                                                                    $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                                    $row = mysqli_fetch_array($employee);
                                                                    $employee_id = $row['employee_id'];
                                                                    $fullname = $row['fullname'];
                                                                    echo $fullname;  ?></a>
                                                            </div>
                                                        </td>
                                                        <td><a href="reservation?id=<?php echo $reservation_id; ?>" class="btn btn-xs btn-info">Details</a>

                                                        </td>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert  alert-danger">Oops!! No Guests out Yet</div>
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