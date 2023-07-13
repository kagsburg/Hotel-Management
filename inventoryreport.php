<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = strtotime($_GET['start'] . ' ' . $_GET['stt']);
$en = strtotime($_GET['end'] . ' ' . $_GET['ent']);
$stdate = explode('/', $_GET['start']);
$endate = explode('/', $_GET['end']);
$st = $stdate[1] . '/' . $stdate[0] . '/' . $stdate[2] . ' ' . $_GET['stt'];
$en = $endate[1] . '/' . $endate[0] . '/' . $endate[2] . ' ' . $_GET['ent'];
$st = strtotime($st);
$en = strtotime($en);

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventory Report - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/stockreport.php';
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
                        <h2>Inventory Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="getstockreport"><i class="fa fa-calendar"></i> Get Report</a> </li>
                            <li class="active">
                                <strong>Inventory Report</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <a href="inventoryreportprint?st=<?php echo $st; ?>&en=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Print PDF</a>&nbsp;
                                <a href="inventoryreportexcel?st=<?php echo $st; ?>&en=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Export to Excel</a>
                            </div>
                            <br>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Inventory Report</h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if ($st > $en) {
                                        $errors[] = 'Start Date Cant be later than End Date';
                                    }
                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                    ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php
                                        }
                                    } else {  ?>
                                        <div class="table-responsive m-t">
                                            <?php
                                            $total = 0;
                                            ?>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>In Stock</th>
                                                        <th>Quantity Added</th>
                                                        <th>Quantity Issued</th>
                                                        <th>Quantity Lossed</th>
                                                        <th>Quantity Remained</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $totalin = 0;
                                                    $totaladded = 0;
                                                    $totalissued = 0;
                                                    $totallossed = 0;
                                                    $totalremained = 0;

                                                    $amntin = 0;
                                                    $amntadded = 0;
                                                    $amntissued = 0;
                                                    $amntlossed = 0;
                                                    $amntremained = 0;

                                                    $items = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1 ");
                                                    while ($row = mysqli_fetch_array($items)) {                                                        
                                                        $item = $row['stock_item'];
                                                        $measure = $row['measurement'];
                                                        $stockitem_id = $row['stockitem_id'];
                                                        $cat_id = $row['category_id'];
                                                        $stockitem = $row['stock_item'];
                                                        $minstock = $row['minstock'];
                                                        $price = $row['price'];
                                                        $measurement = $row['measurement'];
                                                        $status = $row['status'];

                                                        $gettotadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems AS q LEFT JOIN addedstock AS o ON o.addedstock_id = q.addedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                                        $rowtota = mysqli_fetch_array($gettotadded);
                                                        $totaddedstock = $rowtota['addedstock'];
                                                        $gettotissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems AS q LEFT JOIN issuedstock AS o ON o.issuedstock_id = q.issuedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                                        $rowtoti = mysqli_fetch_array($gettotissued);
                                                        $totissuedstock = $rowtoti['issuedstock'];
                                                        $gettotlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems AS q LEFT JOIN itemlosses AS o ON o.itemloss_id = q.itemloss_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                                        $rowtotl = mysqli_fetch_array($gettotlossed);
                                                        $totlossedstock = $rowtotl['lossedstock'];

                                                        $instock = $totaddedstock - $totissuedstock - $totlossedstock;


                                                        $getadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems AS q left JOIN addedstock AS o ON o.addedstock_id = q.addedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                                        $rowa = mysqli_fetch_array($getadded);
                                                        $addedstock = $rowa['addedstock'];
                                                        $getissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems AS q left JOIN issuedstock AS o ON o.issuedstock_id = q.issuedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                                        $rowi = mysqli_fetch_array($getissued);
                                                        $issuedstock = $rowi['issuedstock'];
                                                        $getlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems AS q left JOIN itemlosses AS o ON o.itemloss_id = q.itemloss_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                                        $rowl = mysqli_fetch_array($getlossed);
                                                        $lossedstock = $rowl['lossedstock'];
                                                        // $getkitchenitems = mysqli_query($con, "SELECT SUM(quantity) AS kitchenstock FROM kitchenstockitems  WHERE stockitem_id='$stockitem_id'") or die(mysqli_error($con));
                                                        // $rowc = mysqli_fetch_array($getkitchenitems);
                                                        // $totalconsumed = $rowc["kitchenstock"];

                                                        $stockleft = $addedstock - $issuedstock - $lossedstock;
                                                        $totalin += $instock;
                                                        $totaladded += $addedstock;
                                                        $totalissued += $issuedstock;
                                                        $totallossed += $lossedstock;
                                                        $totalremained += $stockleft;

                                                        $amntin += $instock * $price;
                                                        $amntadded += $addedstock * $price;
                                                        $amntissued += $issuedstock * $price;
                                                        $amntlossed += $lossedstock * $price;
                                                        $amntremained += $stockleft * $price;
                                                        // only show items with stock
                                                        if ($instock > 0) {

                                                    
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $item; ?></td>
                                                            <td><?php echo number_format($instock); ?></td>
                                                            <td><?php echo number_format($addedstock); ?></td>
                                                            <td><?php echo number_format($issuedstock); ?></td>
                                                            <td><?php echo number_format($lossedstock); ?></td>
                                                            <td><?php echo number_format($stockleft); ?></td>
                                                        </tr>
                                                        <?php
                                                        }?>
                                                    <?php } ?>

                                                    <tr>
                                                        <th>TOTAL</th>
                                                        <th><?php echo number_format($totalin); ?></th>
                                                        <th><?php echo number_format($totaladded); ?></th>
                                                        <th><?php echo number_format($totalissued); ?></th>
                                                        <th><?php echo number_format($totallossed); ?></th>
                                                        <th><?php echo number_format($totalremained); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th>AMOUNT</th>
                                                        <th><?php echo number_format($amntin); ?></th>
                                                        <th><?php echo number_format($amntadded); ?></th>
                                                        <th><?php echo number_format($amntissued); ?></th>
                                                        <th><?php echo number_format($amntlossed); ?></th>
                                                        <th><?php echo number_format($amntremained); ?></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- /table-responsive -->




                                        <div class="d-flex">
                                            <div class="ml-auto">
                                                <p class="fs-16" style="margin-bottom: 40px;">
                                                    Created By:
                                                    <?php
                                                    $empid = $_SESSION['emp_id'];
                                                    $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$empid'");
                                                    $row = mysqli_fetch_array($employee);
                                                    // $employee_id = $row['employee_id'];
                                                    $fullname = $row['fullname'] ?? "";
                                                    echo $fullname;
                                                    ?>
                                                </p>
                                                <p class="fs-12">
                                                    <?php echo date('d/m/Y'); ?>
                                                </p>
                                            </div>
                                        </div>
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

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
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