<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant' && $_SESSION['sysrole']!='Kitchen Exploitation Officer')) {
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

    <title>Restaurant Ordered Items Report | Hotel Manager</title>

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
                        <h2>Restaurant Ordered Items Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?></h2>
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
                                    <h5>Ordered Items Report</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $restorders = mysqli_query($con, "SELECT food_id,foodprice,SUM(quantity) AS totalqty,FROM_UNIXTIME(timestamp,'%d/%m/%Y') AS date  FROM restaurantorders AS r JOIN orders AS o ON o.order_id = r.order_id JOIN menuitems AS m ON m.menuitem_id = r.food_id WHERE o.status IN (1, 2) AND m.type = '$type' AND timestamp>='$st' AND timestamp < '$end' GROUP BY r.food_id,date,foodprice") or die(mysqli_error($con));
                                    if (mysqli_num_rows($restorders) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $total = 0;
                                                while ($row =  mysqli_fetch_array($restorders)) {

                                                    $food_id = $row['food_id'];
                                                    $foodprice = $row['foodprice'];
                                                    $totalqty = $row['totalqty'];
                                                    $totalprice = $foodprice * $totalqty;
                                                    $total += $totalprice;
                                                    $timestamp = $row['date'];
                                                    $getfooditem = mysqli_query($con, "SELECT * FROM menuitems WHERE status='1' AND menuitem_id='$food_id'");
                                                    $row1 =  mysqli_fetch_array($getfooditem);
                                                    $food = $row1["menuitem"];
                                                ?>
                                                    <tr class="gradeA">

                                                        <td><?php echo $timestamp; ?></td>
                                                        <td><?php echo $food; ?></td>
                                                        <td><?php echo $totalqty; ?></td>
                                                        <td><?php echo number_format($foodprice); ?></td>
                                                        <td><?php echo number_format($totalprice); ?></td>
                                                    </tr>
                                                <?php
                                                } ?>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-4 pull-right">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>TOTAL</th>
                                                        <th><?php echo number_format($total); ?></th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
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