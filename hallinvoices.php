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
    <title>Hall Invoices | Hotel Manager</title>
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
        include 'fr/halluncleared.php';
    } else {
    ?>
        <div id="wrapper">
            <?php include 'nav.php'; ?>
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                                <i class="fa fa-bars"></i> </a>
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
                        <h2>Hall Invoices between <?php echo date('d/m/Y H:i', $start); ?> and 
                        <?php echo date('d/m/Y H:i', $end); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li class="active">
                                <strong>Hall Invoices </strong>
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
                                    <h5>Hall Invoices <small>Sort, search</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE 
                                    status IN (1,2,3) AND timestamp>='$start' AND timestamp<='$end' ORDER BY hallreservation_id DESC");
                                    ?>
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Guest</th>
                                                <th>People</th>
                                                <th>Dates</th>
                                                <th>Total Charge</th>
                                                <th>Amount Paid</th>                                                
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
                                                $status = $row['status'];
                                                $people = $row['people'];
                                                $status = $row['status'];
                                                $description = $row['description'];
                                                $country = $row['country'];
                                                $creator = $row['creator'];
                                                $charge = $row['charge'];

                                                $vat = $row['vat'];
                                                $days = ($checkout - $checkin) / (3600 * 24) + 1;
                                                $vatamount = ($days * $charge * $vat) / 100;
                                                $roomtotal = ($charge * $days) + $vatamount;
                                                // $purposes = mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
                                                // $row3 = mysqli_fetch_array($purposes);
                                                // $hallpurpose_id = $row3['hallpurpose_id'];
                                                // $hallpurpose = $row3['hallpurpose'];
                                                // $totalcharge = $charge * $days;
                                                $hallincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalhallincome FROM hallpayments WHERE hallbooking_id='$hallreservation_id'");
                                                $row4 =  mysqli_fetch_array($hallincome);
                                                $totalhallincome = $row4['totalhallincome'];

                                                $buffettotal = 0;
                                                $buffets = mysqli_query($con, "SELECT * FROM reservationbuffets WHERE hallbooking_id='$hallreservation_id'");
                                                if (mysqli_num_rows($buffets) > 0) {
                                                    while ($row1 = mysqli_fetch_array($buffets)) {
                                                        $hallbuffet_id = $row1['hallbuffet_id'];
                                                        $price = $row1['price'];
                                                        $days = $row1['days'];
                                                        $buffetcharge = $days * $people * $price;
                                                        $buffettotal = $buffettotal + $buffetcharge;
                                                    }
                                                }
                                                
                                                $totalservices = 0;
                                                $getservices = mysqli_query($con, "SELECT * FROM hallservices WHERE hallreservation_id='$hallreservation_id'");
                                                if (mysqli_num_rows($getservices) > 0) {
                                                    while ($row5 = mysqli_fetch_array($getservices)) {
                                                        $service = $row5['service'];
                                                        $quantity = $row5['quantity'];
                                                        $price = $row5['price'];
                                                        $days = $row5['days'];
                                                        $servicecharge = $price * $days * $quantity;
                                                        $totalservices = $servicecharge + $totalservices;
                                                    }
                                                }

                                                $totalservices2 = 0;
                                                $getservices2 = mysqli_query($con, "SELECT * FROM hallservices2 WHERE hallreservation_id='$hallreservation_id'");
                                                if (mysqli_num_rows($getservices2) > 0) {
                                                    while ($row6 = mysqli_fetch_array($getservices2)) {
                                                        $service = $row6['service'];
                                                        $price = $row6['price'];
                                                        $totalservices2 += $price;
                                                    }
                                                }

                                                $totalcharge = $roomtotal + $buffettotal + $totalservices + $totalservices2;
                                                $balance = $totalcharge - $totalhallincome;
                                                if ($balance > 0) {
                                            ?>

                                                    <tr class="gradeA">
                                                        <td><?php echo $fullname; ?></td>
                                                        <td><?php echo $people; ?></td>
                                                        <td><?php echo date('d/m/Y', $checkin) . ' to ' . date('d/m/Y', $checkout); ?></td>
                                                        
                                                        <td><?php echo number_format($totalcharge); ?></td>
                                                        <td><?php echo number_format($totalhallincome); ?></td>
                                                        
                                                        <td>
                                                         <a href="hallinvoice?id=<?php echo $hallreservation_id; ?>" class="btn btn-xs btn-success">View</a>
                                                         <a href="hallpayment?id=<?php echo $hallreservation_id; ?>" class="btn btn-xs btn-primary">Edit</a>
                                                        <?php   if ($_SESSION['sysrole'] == 'manager') { ?>
                                                            <a href="confirmhallreservation?id=<?php echo $hallreservation_id; ?>" class="btn btn-xs btn-info" 
                                                            <?php if ($totalcharge > $totalhallincome) { ?> disabled <?php   } ?> 
                                                            onclick="return confirm_reservation<?php echo $hallreservation_id; ?>()">Confirm</a>
                                                            <?php } ?>
                                                                <a href="removehallreservation?id=<?php echo $hallreservation_id;?>" 
                                                            class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $hallreservation_id; ?>()">
                                                            <i class="fa fa-delete"></i>Cancel</a>
                                                            <script type="text/javascript">
                                                                function confirm_delete<?php echo $hallreservation_id; ?>() {
                                                                return confirm('You are about To Remove this Request. Are you sure you want to proceed?');
                                                                }
                                                                function confirm_reservation<?php echo $hallreservation_id; ?>() {
                                                                return confirm('You are about To Confirm this Request. Are you sure you want to proceed?');
                                                                }
                                                            </script>                                                         
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
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