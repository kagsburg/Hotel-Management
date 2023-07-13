<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Store Attendant')) {
    header('Location:login');
}
$id = $_GET['id'];
$stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$id' ");
$row =  mysqli_fetch_array($stock);
$item = $row['stock_item'];
$measure = $row['measurement'];
$measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measure'");
$row2 = mysqli_fetch_array($measurements);
$measurement = $row2['measurement'];
$getadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems WHERE item_id='$id'") or die(mysqli_error($con));
$rowa = mysqli_fetch_array($getadded);
$addedstock = $rowa['addedstock'];
$getissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems WHERE item_id='$id'") or die(mysqli_error($con));
$rowi = mysqli_fetch_array($getissued);
$issuedstock = $rowi['issuedstock'];
$getlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems WHERE item_id='$id'") or die(mysqli_error($con));
$rowl = mysqli_fetch_array($getlossed);
$lossedstock = $rowl['lossedstock'];
// $getkitchenitems = mysqli_query($con, "SELECT SUM(quantity) AS kitchenstock FROM kitchenstockitems  WHERE item_id='$id'") or die(mysqli_error($con));
// $rowc = mysqli_fetch_array($getkitchenitems);
// $totalconsumed = $rowc["kitchenstock"];

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $item; ?> Stock - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/itemdetails.php';
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
                        <h2><?php echo $item; ?> Stock </h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="stockitems">Stock</a> </li>
                            <li class="active">
                                <strong><?php echo $item; ?> Stock</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="widget style1 lazur-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Available in Stock</span>
                                        <h2 class="font-bold"><?php echo $addedstock - $issuedstock - $lossedstock . ' ' . $measurement; ?></h2 </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 blue-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-share fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Stock Issued</span>
                                        <h2 class="font-bold"><?php echo $issuedstock . ' ' . $measurement; ?></h2 </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 red-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-thumbs-down fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Lost in Stock</span>
                                        <h2 class="font-bold"><?php echo $lossedstock . ' ' . $measurement; ?></h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab-1">Stock Added</a></li>

                                <li class=""><a data-toggle="tab" href="#tab-2">Stock Issued</a></li>

                                <li class=""><a data-toggle="tab" href="#tab-3">Stock Lost</a></li>

                            </ul>
                        </div>

                        <div class="ibox-content">

                            <div class="tab-content">

                                <div id="tab-1" class="tab-pane active">

                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Quantity (<?php echo $measurement; ?>)</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getadded = mysqli_query($con, "SELECT * FROM stockitems WHERE item_id='$id' AND status=1");
                                            while ($row =  mysqli_fetch_array($getadded)) {
                                                $quantity = $row['quantity'];
                                                $addedstock_id = $row['addedstock_id'];
                                                $addedstock = mysqli_query($con, "SELECT * FROM addedstock WHERE addedstock_id='$addedstock_id'");
                                                $row2 = mysqli_fetch_array($addedstock);
                                                $date = $row2['date'];

                                            ?>

                                                <tr class="gradeA">
                                                    <td><?php echo date('d/m/Y', $date); ?></td>
                                                    <td><?php echo $quantity; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Quantity (<?php echo $measurement; ?>)</th>
                                                <th>Department</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getissued = mysqli_query($con, "SELECT * FROM issueditems WHERE item_id='$id' AND status=1");
                                            while ($row =  mysqli_fetch_array($getissued)) {
                                                $quantity = $row['quantity'];
                                                $issuedstock_id = $row['issuedstock_id'];
                                                $issuedstock = mysqli_query($con, "SELECT * FROM issuedstock WHERE issuedstock_id='$issuedstock_id'");
                                                $row2 = mysqli_fetch_array($issuedstock);
                                                $date = $row2['date'];
                                                $department_id = $row2['department_id'];
                                                if ($department_id == "-2") {
                                                    $dept = "Small Stock";
                                                } else {
                                                    $depts =  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$department_id'");
                                                    $rowd = mysqli_fetch_array($depts);
                                                    $dept = $rowd['department'];
                                                }
                                            ?>

                                                <tr class="gradeA">
                                                    <td><?php echo date('d/m/Y', $date); ?></td>
                                                    <td><?php echo $quantity; ?></td>
                                                    <td><?php echo $dept; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="tab-3" class="tab-pane">

                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getitems = mysqli_query($con, "SELECT * FROM losseditems WHERE status=1 AND item_id='$id'");
                                            while ($product = mysqli_fetch_array($getitems)) {
                                                $itemloss_id = $product['itemloss_id'];
                                                $losseditem_id = $product["losseditem_id"];
                                                $item_id = $product["item_id"];
                                                $quantity = $product["quantity"];
                                                $list = mysqli_query($con, "SELECT * FROM itemlosses WHERE status=1 AND itemloss_id='$itemloss_id'");
                                                $row3 =  mysqli_fetch_array($list);
                                                $date = $row3['date'];

                                            ?>

                                                <tr class="gradeA">
                                                    <td><?php echo date('d/m/Y', $date); ?></td>

                                                    <td><?php echo $quantity; ?></td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>
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

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
    $('.dataTables-example').dataTable();
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
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
</script>