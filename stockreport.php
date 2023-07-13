<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = strtotime($_GET['st'] . ' ' . $_GET['stt']);
$en = strtotime($_GET['en'] . ' ' . $_GET['ent']);
$ty = $_GET['ty'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $ty; ?> Stock Report - Hotel Manager</title>
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
                        <h2><?php echo $ty; ?> Stock Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="getstockreport"><i class="fa fa-calendar"></i> Get Report</a> </li>
                            <li class="active">
                                <strong>Stock Report</strong>
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
                                <a href="stockreportprint?st=<?php echo $st; ?>&en=<?php echo $en; ?>&ty=<?php echo $ty; ?>" target="_blank" class="btn btn-success ">Print PDF</a>&nbsp;
                                <a href="stockreportexcel?st=<?php echo $st; ?>&en=<?php echo $en; ?>&ty=<?php echo $ty; ?>" target="_blank" class="btn btn-success ">Export to Excel</a>
                            </div>
                            <br>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><?php echo $ty; ?> Stock Report</h5>

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
                                            if ($ty == 'Added' || $ty == "all") {

                                            ?>
                                                <?php if($ty == "all") echo "<h3>Added Stock</h3>"; ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Item</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $totalq = 0;
                                                        $addedstock = mysqli_query($con, "SELECT * FROM addedstock WHERE  date>='$st' AND date<='$en' AND status=1");
                                                        while ($row = mysqli_fetch_array($addedstock)) {
                                                            $date = $row['date'];
                                                            $addedstock_id = $row['addedstock_id'];
                                                            $getadded = mysqli_query($con, "SELECT * FROM stockitems WHERE  status=1  AND addedstock_id='$addedstock_id'");
                                                            $row2 =  mysqli_fetch_array($getadded);
                                                            $quantity = $row2['quantity'];
                                                            $item_id = $row2['item_id'];
                                                            $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id' ");
                                                            $row3 =  mysqli_fetch_array($stock);
                                                            $item = $row3['stock_item'];
                                                            $measure = $row3['measurement'];
                                                            $measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measure'");
                                                            $row4 = mysqli_fetch_array($measurements);
                                                            $measurement = $row4['measurement'];

                                                            $totalq += $quantity;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo date('d/m/Y', $date); ?></td>
                                                                <td><?php echo $item . ' (' . $measurement . ')'; ?></td>
                                                                <td><?php echo $quantity; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th>TOTAL</th>
                                                            <th></th>
                                                            <th><?php echo number_format($totalq); ?></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <?php }
                                            if ($ty == 'Lost' || $ty == "all") {

                                            ?>
                                                <?php if($ty == "all") echo "<h3>Lossed Stock</h3>"; ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Item</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $totalq = 0;
                                                        $stocklossed = mysqli_query($con, "SELECT * FROM itemlosses WHERE status=1  AND date>='$st' AND date<='$en'");
                                                        while ($row = mysqli_fetch_array($stocklossed)) {
                                                            $date = $row['date'];
                                                            $itemloss_id = $row['itemloss_id'];
                                                            $getlossed = mysqli_query($con, "SELECT * FROM losseditems WHERE  status=1  AND itemloss_id='$itemloss_id'");
                                                            $row2 =  mysqli_fetch_array($getlossed);
                                                            $quantity = $row2['quantity'];
                                                            $item_id = $row2['item_id'];
                                                            $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id' ");
                                                            $row3 =  mysqli_fetch_array($stock);
                                                            $item = $row3['stock_item'];
                                                            $measure = $row3['measurement'];
                                                            $measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measure'");
                                                            $row4 = mysqli_fetch_array($measurements);
                                                            $measurement = $row4['measurement'];

                                                            $totalq += $quantity;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo date('d/m/Y', $date); ?></td>
                                                                <td><?php echo $item . ' (' . $measurement . ')'; ?></td>
                                                                <td><?php echo $quantity; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th>TOTAL</th>
                                                            <th></th>
                                                            <th><?php echo number_format($totalq); ?></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <?php
                                            }
                                            if ($ty == 'Issued' || $ty == "all") {
                                            ?>
                                                <?php if($ty == "all") echo "<h3>Issued Stock</h3>"; ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Item</th>
                                                            <th>Quantity</th>
                                                            <th>Department</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $totalq = 0;
                                                        $issuedstock = mysqli_query($con, "SELECT * FROM issuedstock WHERE status=1  AND date>='$st' AND date<='$en'");
                                                        while ($row = mysqli_fetch_array($issuedstock)) {
                                                            $date = $row['date'];
                                                            $issuedstock_id = $row['issuedstock_id'];
                                                            $department_id = $row['department_id'];
                                                            $getissued = mysqli_query($con, "SELECT * FROM issueditems WHERE  status=1  AND issuedstock_id='$issuedstock_id'");
                                                            $row2 =  mysqli_fetch_array($getissued);
                                                            $quantity = $row2['quantity'];
                                                            $item_id = $row2['item_id'];
                                                            $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id' ");
                                                            $row3 =  mysqli_fetch_array($stock);
                                                            $item = $row3['stock_item'];
                                                            $measure = $row3['measurement'];
                                                            $measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measure'");
                                                            $row4 = mysqli_fetch_array($measurements);
                                                            $measurement = $row4['measurement'];
                                                            if ($department_id === "-2") {
                                                                $dept = "Small Stock";
                                                            } else {
                                                                $depts =  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$department_id'");
                                                                $rowd = mysqli_fetch_array($depts);
                                                                $dept = $rowd['department'];
                                                            }

                                                            $totalq += $quantity;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo date('d/m/Y', $date); ?></td>
                                                                <td><?php echo $item . ' (' . $measurement . ')'; ?></td>
                                                                <td><?php echo $quantity; ?></td>
                                                                <td><?php echo $dept; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th>TOTAL</th>
                                                            <th></th>
                                                            <th><?php echo number_format($totalq); ?></th>
                                                            <th></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div><!-- /table-responsive -->



                                    <?php
                                    }

                                    ?>
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