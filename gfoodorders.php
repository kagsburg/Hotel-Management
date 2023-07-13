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

    <title>Orders | Hotel Manager</title>

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
        include 'fr/gfoodorders.php';
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
                        <h2>Hotel Orders From Reserved Guests</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

                            <li>
                                <a>Menu</a>
                            </li>
                            <li class="active">
                                <strong> Orders</strong>
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
                                    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND guest>'0' ORDER BY order_id DESC");
                                    if (mysqli_num_rows($restorders) > 0) {
                                    ?>
                                        <form action="archiverestaurant" method="post">
                                            <table class="table table-striped table-bordered table-hover dataTables-example" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Order Id</th>
                                                        <th>Order items</th>
                                                        <th>Charge</th>
                                                        <th>Guest Name</th>
                                                        <th>Waiter</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND guest>'0' ORDER BY order_id DESC");
                                                    while ($row =  mysqli_fetch_array($restorders)) {
                                                        $order_id = $row['order_id'];
                                                        $guest = $row['guest'];
                                                        $waiter = $row['waiter'];
                                                        $vat = $row['vat'];
                                                        $creator = $row['creator'];
                                                        $orderstatus = $row['orderstatus'];
                                                        $timestamp = $row['timestamp'];
                                                        $getyear = date('Y', $timestamp);
                                                        $count = 1;
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
                                                        $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                                                    ?>
                                                        <tr class="gradeA">
                                                            <td> <?php echo $invoice_no; ?></td>
                                                            <td><?php
                                                                while ($row3 =  mysqli_fetch_array($foodsordered)) {
                                                                    $restorder_id = $row3['restorder_id'];
                                                                    $food_id = $row3['food_id'];
                                                                    $price = $row3['foodprice'];
                                                                    $quantity = $row3['quantity'];

                                                                    $foodmenu = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                                                                    $row =  mysqli_fetch_array($foodmenu);
                                                                    $menuitem_id = $row['menuitem_id'];
                                                                    $menuitem = $row['menuitem'];

                                                                    echo $quantity . ' ' . $menuitem . '<br/>';
                                                                }
                                                                ?></td>
                                                            <td class="center">
                                                                <?php
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
                                                                        $puhtva = round($price / (($vat / 100) + 1));
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
                                                                // $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                                                                // $row =  mysqli_fetch_array($totalcharges);
                                                                // $totalcosts = $row['totalcosts'];
                                                                echo number_format($totaltax + $total);
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php

                                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                                                                if (mysqli_num_rows($reservation) > 0) {
                                                                    $row =  mysqli_fetch_array($reservation);
                                                                    $firstname1 = $row['firstname'];
                                                                    $lastname1 = $row['lastname'];
                                                                    $room_id = $row['room'];
                                                                    $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                                    $row1 =  mysqli_fetch_array($roomtypes);
                                                                    $roomnumber = $row1['roomnumber'];
                                                                    echo $firstname1 . ' ' . $lastname1 . ' (' . $roomnumber . ')';
                                                                }    ?>
                                                            </td>
                                                            <td><?php echo $waiter; ?></td>
                                                            <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                                            <td><?php echo $orderstatus; ?></td>
                                                            <td>

                                                                <a href="restinvoice_print?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success" target="_blank">View Invoice</a>
                                                                <a href="restorder_print?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success" target="_blank">Purchase order</a>
                                                                <a data-toggle="modal" href="#modal-form<?php echo $order_id; ?>" class="btn btn-primary btn-xs">Change Status</a>
                                                                
                                                                    <a href="editrestorder?id=<?php echo $order_id; ?>" class="btn btn-xs btn-info">Edit</a>
                                                                    <a href="hiderestorder?id=<?php echo $order_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $order_id; ?>()">Cancel</a>
                                                                
                                                                <a href="loserestorder?id=<?php echo $order_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_loss<?php echo $order_id; ?>()">Loss</a>
                                                                <script type="text/javascript">
                                                                    function confirm_delete<?php echo $order_id; ?>() {
                                                                        return confirm('You are about To Remove this Order. Are you sure you want to proceed?');
                                                                    }
                                                                    function confirm_loss<?php echo $order_id; ?>() {
                                                                        return confirm('You are about To mark this order as a loss. Are you sure you want to proceed?');
                                                                    }
                                                                </script>
                                                            </td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </form>
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
        <?php
        $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND guest>'0' ORDER BY order_id DESC");
        while ($row =  mysqli_fetch_array($restorders)) {
            $order_id = $row['order_id'];
            $orderstatus = $row['orderstatus'];
        ?>
            <div id="modal-form<?php echo $order_id; ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form role="form" method="POST" action="changeorderstatus?id=<?php echo $order_id; ?>" enctype="multipart/form-data">
                                        <div class="form-group" id="data_1">
                                            <label class="">Select New Status</label>
                                            <div class="form-group">
                                                <select name="status" class="form-control">
                                                   
                                                    <option value="<?php echo $orderstatus; ?>" selected="selected"><?php echo $orderstatus; ?></option>
                                                    <option value="Received">Received</option>
                                                    <option value="In Preparation">In Preparation</option>
                                                    <option value="Ready">Ready</option>
                                                    <option value="Delivered">Delivered</option>
                                                </select>
                                            </div>

                                        </div>
                                        <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Change</strong></button>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    <?php }
    } ?>
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