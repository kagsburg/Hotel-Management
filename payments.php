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

    <title>Payments | Hotel Manager</title>

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
        include 'fr/payments.php';
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
                        <h2>Payments</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

                            <li>
                                <a>Rooms</a>
                            </li>
                            <li class="active">
                                <strong>View Rooms</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <?php
                        $rooms = mysqli_query($con, "SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
                        ?>
                        <div class="col-lg-4">
                            <div class="widget style1 lazur-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-building-o fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>All Rooms </span>
                                        <h2 class="font-bold"><?php echo mysqli_num_rows($rooms); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-folder fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Occupied Rooms</span>
                                        <?php
                                        $occupied =  mysqli_query($con, "SELECT * FROM reservations WHERE  status='1'");
                                        ?>
                                        <h2 class="font-bold">
                                            <?php echo mysqli_num_rows($occupied); ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 yellow-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-folder-open fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Available Rooms</span>
                                        <h2 class="font-bold"><?php
                                                                $available =  mysqli_num_rows($rooms) - mysqli_num_rows($occupied);

                                                                echo $available;
                                                                ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>All Rooms <small>Sort, search</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php

                                    if (mysqli_num_rows($rooms) > 0) {

                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Room Number</th>
                                                    <th>Room Type</th>
                                                    <th>Items</th>
                                                    <th>Availability</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($rooms)) {
                                                    $roomnumber = $row['roomnumber'];
                                                    $room_id = $row['room_id'];
                                                    $type = $row['type'];
                                                    $status = $row['status'];
                                                    $creator = $row['creator'];
                                                    $check =  mysqli_query($con, "SELECT * FROM reservations WHERE  status='1' AND room='$room_id'");
                                                    if (mysqli_num_rows($check) > 0) {
                                                        $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                                                        $row1 =  mysqli_fetch_array($roomtypes);
                                                        $roomtype = $row1['roomtype'];
                                                        //                                            if($room_id==$room2){
                                                ?>

                                                        <tr class="gradeA">
                                                            <td><?php echo $room_id; ?></td>
                                                            <td><?php echo $roomnumber; ?></td>
                                                            <td class="center">
                                                                <?php
                                                                $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                                                                $row1 =  mysqli_fetch_array($roomtypes);
                                                                $roomtype = $row1['roomtype'];
                                                                echo $roomtype; ?>
                                                            </td>
                                                            <td>
                                                                <ul>
                                                                    <?php
                                                                    $getitems = mysqli_query($con, "SELECT * FROM roomitems WHERE room_id='$room_id'") or die(mysqli_error($con));
                                                                    while ($row1 = mysqli_fetch_array($getitems)) {
                                                                        $item_id = $row1['item_id'];
                                                                        $getitem = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1 AND stockitem_id='$item_id'");
                                                                        $row2 =  mysqli_fetch_array($getitem);
                                                                        $stockitem = $row2['stock_item'];
                                                                        echo '<li>' . $stockitem . '</li>';
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $check =  mysqli_query($con, "SELECT * FROM reservations WHERE  room='$room_id' AND status='1'");
                                                                $row2 = mysqli_fetch_array($check);
                                                                $reserveid = $row2['reservation_id'];
                                                                if (mysqli_num_rows($check) > 0) {
                                                                    echo '<div class="text-danger">Occupied</div>';
                                                                } else {
                                                                    $check2 =  mysqli_query($con, "SELECT * FROM reservations WHERE  room='$room_id' AND status='0' AND checkin>='$timenow' ORDER BY checkin");

                                                                    if (mysqli_num_rows($check2) > 0) {
                                                                        $row3 = mysqli_fetch_array($check2);
                                                                        $checkin = date("d/m/Y", $row3['checkin']);
                                                                        $checkout = date("d/m/Y", $row3['checkout']);
                                                                        echo '<div class="text-primary">Available till ' . $checkin . '</div>';
                                                                    } else {
                                                                        echo '<div class="text-success">Available</div>';
                                                                    }
                                                                }
                                                                ?>
                                                            </td>

                                                            <td class="center">
                                                                <?php
                                                                if (($creator == $_SESSION['hotelsys']) || ($_SESSION['hotelsyslevel'] == 1)) {
                                                                ?>
                                                                    <a href="editroom.php?id=<?php echo $room_id; ?>" class="btn btn-info btn-xs">Edit Room <i class="fa fa-edit"></i></a>
                                                                    <a href="hideroom.php?id=<?php echo $room_id . '&&status=' . $status; ?>" class="btn btn-danger btn-xs" onclick="return confirm_delete<?php echo $room_id; ?>()">Remove <i class="fa fa-arrow-down"></i></a>
                                                                    <?php if (mysqli_num_rows($check) > 0) { ?>
                                                                    <a href="reservation?id=<?php echo $reserveid; ?>" class="btn btn-primary btn-xs">Details</a>
                                                                    <?php } ?>
                                                                    <script type="text/javascript">
                                                                        function confirm_delete<?php echo $room_id; ?>() {
                                                                            return confirm('You are about To Remove this Room. Are you sure you want to proceed?');
                                                                        }
                                                                    </script>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
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