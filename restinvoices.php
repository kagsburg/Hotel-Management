<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant')) {
    header('Location:login.php');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Approved Restaurant Invoices | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/foodorders.php';
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
                    <div class="col-lg-12">
                        <h2>Approved Restaurant Invoices</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="foodorders">Orders</a>
                            </li>
                            <li class="active">
                                <strong>Orders</strong>
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
                                    <h5>All Orders <small>Sort, search</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status=1 ORDER BY order_id DESC");
                                    if (mysqli_num_rows($restorders) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th>Invoice Id</th>
                                                    <th>Guest</th>
                                                    <th>Room No</th>
                                                    <th>Added By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($restorders)) {
                                                    $order_id = $row['order_id'];
                                                    $guest = $row['guest'];
                                                    $rtable = $row['rtable'];
                                                    $vat = $row['vat'];
                                                    $waiter = $row['waiter'];
                                                    $status = $row['status'];
                                                    $mode = $row['mode'];
                                                    $timestamp = $row['timestamp'];
                                                    $getyear = date('Y', $timestamp);
                                                    $count = 1;
                                                    $creator = $row['creator'];
                                                    $beforeorders =  mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2)  AND  order_id<'$order_id'") or die(mysqli_error($con));
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
                                                    $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id' AND status=1");

                                                ?>
                                                    <tr class="gradeA">
                                                        <td><?php echo $invoice_no; ?></td>
                                                        <td><?php
                                                            $roomnumber = '';
                                                            if ($guest > 0) {
                                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                                                                $row =  mysqli_fetch_array($reservation);
                                                                $firstname1 = $row['firstname'];
                                                                $lastname1 = $row['lastname'];
                                                                $room_id = $row['room'];
                                                                $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                                $row1 =  mysqli_fetch_array($roomtypes);
                                                                $roomnumber = $row1['roomnumber'];
                                                                echo $firstname1 . ' ' . $lastname1;
                                                            } else {
                                                                echo 'Non Resident';
                                                            }
                                                            ?></td>
                                                        <td class="center">
                                                            <?php
                                                            echo $roomnumber;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                            $row = mysqli_fetch_array($employee);
                                                            // $employee_id = $row['employee_id'];
                                                            $fullname = $row['fullname'] ?? "";
                                                            echo $fullname;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="restinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success">View Invoice</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert alert-danger">No Restaurant Orders Added Yet</div>
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
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
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
            $('.resident').click(function() {
                if ($(this).prop("checked") === true) {
                    $('.forresidents').show();
                } else {
                    $('.forresidents').hide();
                }
            });
        });
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {
                allow_single_deselect: true
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!'
            },
            '.chosen-select-width': {
                width: "95%"
            }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
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
    <script>
        var checkboxe = $("#datatable input[type='checkbox']"),
            submitButt = $("#hid");

        checkboxe.click(function() {
            submitButt.attr("disabled", !checkboxe.is(":checked"));
        });
    </script>
</body>

</html>