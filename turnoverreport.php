<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant')) {
    header('Location:login.php');
}
$st = strtotime($_GET['st'] . ' ' . $_GET['stt']);
$en = strtotime($_GET['en'] . ' ' . $_GET['ent']);
$end = $en;
$type = $_GET["type"];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restaurant Turnover Report | Hotel Manager</title>

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
                        <h2>Restaurant Turnover Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?></h2>
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
                    <?php /*
                    <a href="restinvoicesreportprint?st=<?php echo $st; ?>&&en=<?php echo $en; ?>" target="_blank" class="btn btn-success">Print</a>
                    <a href="restinvoicesreportexcel?st=<?php echo $st; ?>&&en=<?php echo $en; ?>" target="_blank" class="btn btn-info">Export to Excel</a>
                    */ ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Turnover Report</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $restorderdates = mysqli_query($con, "SELECT FROM_UNIXTIME(timestamp,'%Y-%m-%d') AS date  FROM orders AS r WHERE status IN (1, 2) AND timestamp>='$st' AND timestamp < '$end' GROUP BY date") or die(mysqli_error($con));
                                    if (mysqli_num_rows($restorderdates) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Turnover</th>
                                                    <th>Material Cost</th>
                                                    <th>Food Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $totalturnover = 0;
                                                $totalmatcost = 0;
                                                $totalfoodcost = 0;
                                                $hasorders = false;
                                                while ($row =  mysqli_fetch_array($restorderdates)) {

                                                    $date = $row['date'];
                                                    $materialcost = 0;
                                                    $turnover = 0;
                                                    $foodcost = 0;
                                                    $datest = strtotime($date);
                                                    $dateen = strtotime($date . " +1 day");
                                                    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1, 2) AND timestamp>='$datest' AND timestamp < '$dateen'") or die(mysqli_error($con));
                                                    while ($row2 = mysqli_fetch_array($restorders)) {
                                                        $order_id = $row2["order_id"];
                                                        $restordersitems = mysqli_query($con, "SELECT r.* FROM restaurantorders AS r  JOIN menuitems AS m ON m.menuitem_id = r.food_id WHERE order_id='$order_id' AND m.type='$type'");

                                                        while ($menuitem = mysqli_fetch_array($restordersitems)) {
                                                            $food_id = $menuitem["food_id"];
                                                            $foodprice = $menuitem["foodprice"];
                                                            $qtyordered = $menuitem["quantity"];
                                                            $turnover += ($foodprice * $qtyordered);
                                                            $products = mysqli_query($con, "SELECT * FROM menuitemproducts WHERE menuitem_id='$food_id' AND status=1") or die(mysqli_error($con));
                                                            while ($pdtrow = mysqli_fetch_array($products)) {
                                                                $stockitem_id = $pdtrow['stockitem_id'];
                                                                $quantity = $pdtrow['quantity'];
                                                                $stockitem = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$stockitem_id'");
                                                                $pdt =  mysqli_fetch_array($stockitem);
                                                                $price = $pdt["price"];
                                                                $cost = $price * $quantity;
                                                                $materialcost += $cost * $qtyordered;
                                                            }
                                                        }
                                                    }

                                                    if (mysqli_num_rows($restordersitems) == 0) {
                                                        continue;
                                                    }

                                                    $foodcost = ($materialcost * 100) / $turnover;
                                                    $totalfoodcost += $foodcost;
                                                    $totalmatcost += $materialcost;
                                                    $totalturnover += $turnover;

                                                ?>
                                                    <tr class="gradeA">

                                                        <td><?php echo $date; ?></td>
                                                        <td><?php echo number_format($turnover); ?></td>
                                                        <td><?php echo number_format($materialcost); ?></td>
                                                        <td><?php echo number_format($foodcost); ?></td>
                                                    </tr>
                                                <?php
                                                } ?>
                                            <tfoot>
                                                <tr>
                                                    <th><strong>TOTAL</strong></th>
                                                    <th><?php echo number_format($totalturnover); ?></th>
                                                    <th><?php echo number_format($totalmatcost); ?></th>
                                                    <th><?php echo number_format($totalfoodcost); ?></th>
                                                </tr>
                                            </tfoot>
                                            </tbody>
                                        </table>

                                    <?php } else { ?>
                                        <div class="alert alert-danger">No Items Ordered Yet</div>
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