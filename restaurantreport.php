<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = strtotime($_GET['st'] . ' ' . $_GET['stt']);
$en = strtotime($_GET['en'] . ' ' . $_GET['ent']);
$cat = $_GET['cat'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restaurant Report - Hotel Manager</title>
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
        include 'fr/restaurantreport.php';
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
                        <h2>Restaurant Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="getrestaurantreport"><i class="fa fa-bars"></i> Get Report</a> </li>

                            <li class="active">
                                <strong>Restaurant Report</strong>
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
                                <a href="restaurantreportprint?st=<?php echo $st; ?>&&en=<?php echo $en; ?>&&cat=<?php echo $cat; ?>" target="_blank" class="btn btn-success ">Print PDF</a>&nbsp;
                                <a href="restaurantreportexcel?st=<?php echo $st; ?>&&en=<?php echo $en; ?>&&cat=<?php echo $cat; ?>" target="_blank" class="btn btn-success ">Export to Excel</a>
                            </div>
                            <br>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Generated Restaurant Report</h5>
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
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ITEM</th>
                                                        <th>QUANTITY</th>
                                                        <th>PRICE</th>
                                                        <!-- <th>TVA</th> -->
                                                        <th>TOTAL</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $totalitems = 0;
                                                    $totalcharge = 0;
                                                    $totalvat = 0;
                                                    $totalnet = 0;


                                                    $ordereditems =  mysqli_query($con, "SELECT food_id FROM restaurantorders  GROUP BY food_id") or die(mysqli_error($con));
                                                    while ($row3 =  mysqli_fetch_array($ordereditems)) {
                                                        $food_id = $row3['food_id'];
                                                        $getquery = "SELECT * FROM menuitems WHERE menuitem_id='$food_id'";
                                                        if ($cat != 'all') {
                                                            $getquery .= "AND menucategory='$cat'";
                                                        }
                                                        $getfoodmenu = mysqli_query($con, $getquery) or die(mysqli_error($con));
                                                        if (mysqli_num_rows($getfoodmenu) > 0) {
                                                            $rowf =  mysqli_fetch_array($getfoodmenu);
                                                            $menuitem = $rowf['menuitem'];

                                                            $items = 0;
                                                            $totaltax = 0;
                                                            $total = 0;
                                                            $net = 0;

                                                            $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND timestamp>='$st' AND timestamp<='$en' ");
                                                            if (mysqli_num_rows($restorders) > 0) {
                                                                while ($row =  mysqli_fetch_array($restorders)) {
                                                                    $order_id = $row['order_id'];
                                                                    $guest = $row['guest'];
                                                                    $rtable = $row['rtable'];
                                                                    // $vat = $row['vat'];
                                                                    $vat= 18;
                                                                    $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE food_id='$food_id'  AND order_id='$order_id'");
                                                                    if (mysqli_num_rows($foodsordered) > 0) {
                                                                        $row4 =  mysqli_fetch_array($foodsordered);
                                                                        $price = $row4['foodprice'];
                                                                        $quantity = $row4['quantity'];
                                                                        $tax = $row4['tax'];
                                                                        if ($tax == 1) {
                                                                            $puhtva = round($price / (($vat / 100) + 1));
                                                                            $tva = $price - $puhtva;
                                                                        } else {
                                                                            $tva = 0;
                                                                            $puhtva = $price;
                                                                        }
                                                                        $pthtva = $puhtva * $quantity;
                                                                        $total += $price;
                                                                        $vatamount = $tva * $quantity;
                                                                        $totaltax = $totaltax + $vatamount;
                                                                        $items = $items + $quantity;
                                                                       
                                                                    }
                                                                    // $net += $price * $items;
                                                                }
                                                            }
                                                            if ($items > 0) {
                                                    ?>
                                                                <tr class="gradeA">
                                                                    <td> <?php echo $menuitem; ?></td>
                                                                    <td><?php echo $items; ?></td>
                                                                    <td><?php echo number_format($price); ?></td>
                                                                    <!-- <td><?php echo number_format($totaltax); ?></td> -->
                                                                    <td><?php echo number_format($price * $items); ?></td>
                                                                </tr>

                                                    <?php
                                                                 $net += $price * $items;
                                                                $totalitems = $totalitems + $items;
                                                                $totalcharge = $totalcharge + $total;
                                                                $totalvat = $totalvat + $totaltax;
                                                                $totalnet = $totalnet + $net;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tr class="gradeA">
                                                    <th>TOTAL</th>
                                                    <th><?php echo number_format($totalitems); ?></th>
                                                    <th><?php echo number_format($totalcharge); ?></th>
                                                    <!-- <th><?php echo number_format($totalvat); ?></th> -->
                                                    <th><?php echo number_format($totalnet); ?></th>
                                                </tr>

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
                                    <?php
                                    }

                                    ?>

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