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
                        <h2>Hotel Orders From Non Reserved guests</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

                            <li>
                                <a>Menu</a>
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
                                    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN(1,2) AND guest='0' ORDER BY order_id DESC");
                                    if (mysqli_num_rows($restorders) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th>Order Id</th>
                                                    <th>Order items</th>
                                                    <th>Total Bill</th>
                                                    <th>Table</th>
                                                    <th>Waiter</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Payment</th>
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
                                                        <td><?php echo $invoice_no; ?></td>
                                                        <td><?php
                                                            $totaltax = 0;
                                                            while ($row3 =  mysqli_fetch_array($foodsordered)) {
                                                                $restorder_id = $row3['restorder_id'];
                                                                $food_id = $row3['food_id'];
                                                                $price = $row3['foodprice'];
                                                                $quantity = $row3['quantity'];
                                                                $tax = $row3['tax'];
                                                                $subprice = $price * $quantity;
                                                                if ($tax == 1) {
                                                                    $taxamount = ($subprice * $vat) / 100;
                                                                    $totaltax = $totaltax + $taxamount;
                                                                } else {
                                                                    $taxamount = 0;
                                                                }
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
                                                            $net = $totaltax + $total;
                                                            echo number_format($net);
                                                            ?>
                                                        </td>
                                                        <td> <?php echo $rtable;  ?></td>
                                                        <td><?php echo $waiter;  ?></td>
                                                        <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                                        <td><?php echo $orderstatus; ?></td>
                                                        <td style="font-weight: bold">
                                                            <?php
                                                            if ($status == 1) {
                                                                if ($mode == 'Credit') {
                                                                    $checkcredit = mysqli_query($con, "SELECT * FROM creditpayments WHERE order_id='$order_id'") or die(mysqli_error($con));
                                                                    $rowc = mysqli_fetch_array($checkcredit);
                                                                    $cstatus = $rowc['status'];
                                                                    if ($cstatus == 0) {
                                                                        echo '<span class="text-warning">CREDIT PENDING</span>';
                                                                    } else {
                                                                        echo '<span class="text-info">PAID</span> (' . $mode . ')';
                                                                    }
                                                                } else {
                                                                    echo '<span class="text-info">PAID</span> (' . $mode . ')';
                                                                }
                                                            } else {
                                                                echo '<span class="text-warning">PENDING</span>';
                                                            }  ?></td>

                                                        <td>

                                                            <a href="restinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success">View Invoice</a>
                                                            <a href="restorder_print?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success" target="_blank">Purchase order</a>
                                                            <a data-toggle="modal" href="#modal-form<?php echo $order_id; ?>" class="btn btn-primary btn-xs">Change Status</a>
                                                            <?php if ($status != 1) { ?>
                                                                <a href="editrestorder?id=<?php echo $order_id; ?>" class="btn btn-xs btn-info">Edit</a>
                                                            <?php } ?>
                                                            <?php
                                                            if (($mode == 'Credit') && ($cstatus == 0)) {
                                                            ?>
                                                                <a href="addcreditpayment?id=<?php echo $order_id; ?>" class="btn btn-xs btn-warning" onclick="return confirm_credit<?php echo $order_id; ?>()">Credit Payment</a>
                                                                <button data-toggle="modal" data-target="#creditcontacts<?php echo $order_id; ?>" class="btn btn-xs btn-success">Credit Contacts</button>

                                                            <?php    }
                                                            if ($status == 2) {
                                                            ?>
                                                                <button data-toggle="modal" data-target="#basicModal<?php echo $order_id; ?>" class="btn btn-xs btn-warning">Approve Payment</button>

                                                                <!--<a href="restorderpayment?id=<?php echo $order_id; ?>" class="btn btn-xs btn-info" onclick="return confirm_payment<?php echo $order_id; ?>()">Approve Payment</a><br>-->
                                                            <?php } ?>
                                                            <?php if ($status != 1) { ?>
                                                                <!-- <a href="hiderestorder?id=<?php echo $order_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $order_id; ?>()">Cancel</a> -->
                                                            <?php } ?>
                                                            <a href="hiderestorder?id=<?php echo $order_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $order_id; ?>()">Cancel</a>
                                                            <a href="loserestorder?id=<?php echo $order_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_loss<?php echo $order_id; ?>()">Loss</a>
                                                            <script type="text/javascript">
                                                                function confirm_payment<?php echo $order_id; ?>() {
                                                                    return confirm('You are about To confirm Payment. Are you sure you want to proceed?');
                                                                }

                                                                function confirm_credit<?php echo $order_id; ?>() {
                                                                    return confirm('You are about To confirm Credit Payment. Are you sure you want to proceed?');
                                                                }

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
        $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN(1,2) AND guest='0' ORDER BY order_id DESC");
        while ($row =  mysqli_fetch_array($restorders)) {
            $order_id = $row['order_id'];
            $orderstatus = $row['orderstatus'];
        ?>
            <div id="creditcontacts<?php echo $order_id; ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h4>Customer Contacts</h4>
                            <?php
                            $getcontacts = mysqli_query($con, "SELECT * FROM creditpayments WHERE order_id='$order_id'") or die(mysqli_error($con));
                            if (mysqli_num_rows($getcontacts) > 0) {
                                $row = mysqli_fetch_array($getcontacts);
                                $fullname = $row['fullname'];
                                $phone = $row['phone'];
                                $comment = $row['comment'];
                                echo '<p><strong>FULLNAME : </strong>' . $fullname . '</p>';
                                echo '<p><strong>PHONE : </strong>' . $phone . '</p>';
                                echo '<p><strong>COMMENT : </strong>' . $comment . '</p>';
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
            <div id="basicModal<?php echo $order_id; ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="restorderpayment?id=<?php echo $order_id; ?>" method="POST">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select name="mode" class="form-control mode">
                                        <option value="" selected="selected">Select Mode</option>
                                        <option value="Bonus">Bonus</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Credit">Credit</option>
                                        <option value="Cheque">Cheque</option> 
                                        <option value="Visa Card">Visa Card</option> 
                                        <option value="Lumicash">Lumicash</option>
                                        <option value="Ecocash">Ecocash</option>
                                    </select>
                                </div>
                                <div class="forcredit" style="display:none">
                                    <div class="form-group">
                                        <label>Fullname</label>
                                        <input type="text" name="fullname" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea name="comment" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

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
        $('.mode').on('change', function() {
            var getselect = $(this).val();
            if (['Credit', 'Cheque', 'Visa Card', 'Lumicash', 'Ecocash'].includes($getselect)) {
                $('.forcredit').show();
            } else {
                $('.forcredit').hide();
            }
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