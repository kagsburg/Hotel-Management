<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant' && $_SESSION['sysrole'] != 'Marketing and Events')) {
    header('Location:login.php');
    exit();
}
$st = strtotime($_GET['st'].' '.$_GET['stt']);
$en = strtotime($_GET['en'].' '.$_GET['ent']);
$end = $en;
$at = $_GET['at'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restaurant Invoices Report | Hotel Manager</title>

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
        include 'fr/restinvoicesreport.php';
    } else {
        $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$at'");
        $row = mysqli_fetch_array($employee);
        $employeename = $row['fullname'];
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
                        <h2>Restaurant Invoices Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?> for <?php echo $employeename; ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="getrestinvoicesreport">Get Report</a>
                            </li>
                            <li class="active">
                                <strong>Report</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <a href="restinvoicesreportprint?st=<?php echo $st; ?>&&en=<?php echo $en; ?>&&at=<?php echo $at; ?>" target="_blank" class="btn btn-success">Print</a>
                    <a href="restinvoicesreportexcel?st=<?php echo $st; ?>&&en=<?php echo $en; ?>&&at=<?php echo $at; ?>" target="_blank" class="btn btn-info">Export to Excel</a>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Invoices Report</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1, 2) AND timestamp>='$st' AND timestamp <= '$end' AND creator='$at'");
                                    if (mysqli_num_rows($restorders) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Invoice Id</th>
                                                    <th>Date</th>
                                                    <th>Guest</th>
                                                    <th>Total Bill</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $totalsells = 0;
                                                $totalcreditpaid = 0;
                                                $totalcreditbalance = 0;
                                                $totalbonus = 0;
                                                $totalcash = 0;
                                                $residentspaid = 0;
                                                $residentsunpaid = 0;
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


                                                ?>
                                                    <tr class="gradeA">
                                                        <td><?php echo $invoice_no; ?></td>
                                                        <td><?php echo date('d/m/Y', $timestamp); ?></td>
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
                                                                echo $firstname1 . ' ' . $lastname1 . ' (' . $roomnumber . ')';
                                                            } else {
                                                                echo 'Non Resident';
                                                            }
                                                            ?></td>
                                                        <td><?php
                                                            // $totaltax = 0;
                                                            // $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id' ");
                                                            // while ($row3 =  mysqli_fetch_array($foodsordered)) {
                                                            //     $restorder_id = $row3['restorder_id'];
                                                            //     $food_id = $row3['food_id'];
                                                            //     $price = $row3['foodprice'];
                                                            //     $quantity = $row3['quantity'];
                                                            //     $tax = $row3['tax'];
                                                            //     $subprice = $price * $quantity;
                                                            //     if ($tax == 1) {
                                                            //         $taxamount = ($subprice * $vat) / 100;
                                                            //         $totaltax = $totaltax + $taxamount;
                                                            //     } else {
                                                            //         $taxamount = 0;
                                                            //     }
                                                            // }
                                                            // $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                                                            // $row =  mysqli_fetch_array($totalcharges);
                                                            // $totalcosts = $row['totalcosts'];
                                                            // $net = $totaltax + $totalcosts;
                                                            $totaltax = 0;
                                                            $total = 0;
                                                            $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                                                            while ($row3 =  mysqli_fetch_array($foodsordered)) {
                                                                $restorder_id = $row3['restorder_id'];
                                                                $food_id = $row3['food_id'];
                                                                $price = $row3['foodprice'];
                                                                $quantity = $row3['quantity'];
                                                                $tax = $row3['tax'];
                                                                if ($tax == 1) {
                                                                    //                 $tva=($price*$vat)/100;
                                                                    //                 $puhtva=$price-$tva;
                                                                    $puhtva = round($price / (($vat / 110) + 1));
                                                                    $tva = $price - $puhtva;
                                                                } else {
                                                                    $tva = 0;
                                                                    $puhtva = $price;
                                                                }
                                                                $pthtva = $puhtva * $quantity;
                                                                $total = ($total + $pthtva);
                                                                $vatamount = $tva * $quantity;
                                                                $totaltax = $totaltax + $vatamount;
                                                            }
                                                            $net = $total + $totaltax; 
                                                            echo number_format($net);
                                                            if ($guest > 0) {
                                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                                                                $rowg = mysqli_fetch_array($reservation);
                                                                $status = $rowg['status'];
                                                                if ($status == 2) {
                                                                    $residentspaid = $residentspaid + $net;
                                                                } else {
                                                                    $residentsunpaid = $residentsunpaid + $net;
                                                                }
                                                            } else {
                                                                if ($mode == 'Credit') {
                                                                    $checkcredit = mysqli_query($con, "SELECT * FROM creditpayments WHERE order_id='$order_id'") or die(mysqli_error($con));
                                                                    $rowc = mysqli_fetch_array($checkcredit);
                                                                    $cstatus = $rowc['status'];
                                                                    if ($cstatus == 0) {
                                                                        $totalcreditbalance = $totalcreditbalance + $net;
                                                                    } else {
                                                                        $totalcreditpaid = $totalcreditpaid + $net;
                                                                    }
                                                                }
                                                                if ($mode == 'Cash') {
                                                                    $totalcash = $totalcash + $net;
                                                                }
                                                                if ($mode == 'Bonus') {
                                                                    $totalbonus = $totalbonus + $net;
                                                                }
                                                            }
                                                            $totalsells = $totalsells + $net;
                                                            $total = ($totalsells - ($totalcreditbalance + $residentsunpaid));
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                } ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>TOTAL SELL</th>
                                                <th><?php echo $totalsells; ?></th>
                                            </tr>
                                            <tr>
                                                <th>TOTAL CASH</th>
                                                <th><?php echo $totalcash; ?></th>
                                            </tr>
                                            <tr>
                                                <th>TOTAL BONUS</th>
                                                <th><?php echo $totalbonus; ?></th>
                                            </tr>
                                            <tr>
                                                <th>TOTAL CREDIT PAID</th>
                                                <th><?php echo $totalcreditpaid; ?></th>
                                            </tr>
                                            <tr>
                                                <th>RESIDENTS BILLS PAID</th>
                                                <th><?php echo $residentspaid; ?></th>
                                            </tr>
                                            <tr>
                                                <th>TOTAL CREDIT UNPAID</th>
                                                <th><?php echo $totalcreditbalance; ?></th>
                                            </tr>
                                            <tr>
                                                <th>RESIDENTS BILLS UNPAID</th>
                                                <th><?php echo $residentsunpaid; ?></th>
                                            </tr>
                                            <tr>
                                                <th>TOTAL</th>
                                                <th><?php echo number_format($total); ?></th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert alert-danger">No Invoices Added Yet</div>
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