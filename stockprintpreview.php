<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
?>
<!DOCTYPE html>
<html>

<head>
    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0;
            /* this affects the margin in the printer settings */
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hotel Stock Items</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/stockprint.php';
    } else {
    ?>
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
                    <h2>Stock Items</h2>
                    <ol class="breadcrumb">
                        <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                        <li class="active">
                            <strong>Stock Items Print</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                <div class="title-action">
                    <a href="stockprint" target="_blank" class="btn btn-warning">Print PDF</a>
                </div>
                </div>
            </div>
            <div class="wrapper wrapper-content p-xl">
                <div class="ibox-content p-xl">
                    <div class="row">
                        <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
                        <div class="col-xs-4">
                        </div>



                    </div>
                    <h1 class="text-center">All Stock Items</h1>
                    <div class="table-responsive m-t">

                        <table class="table invoice-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Stock Item</th>
                                    <th>Min Stock</th>
                                    <th>In Stock</th>
                                    <th>Unit</th>
                                    <th>Category</th>
                                    <th>Stock Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                                while ($row =  mysqli_fetch_array($stock)) {
                                    $stockitem_id = $row['stockitem_id'];
                                    $cat_id = $row['category_id'];
                                    $stockitem = $row['stock_item'];
                                    $minstock = $row['minstock'];
                                    $measurement = $row['measurement'];
                                    $status = $row['status'];
                                    $getadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_array($getadded);
                                    $addedstock = $rowa['addedstock'];
                                    $getissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                                    $rowi = mysqli_fetch_array($getissued);
                                    $issuedstock = $rowi['issuedstock'];
                                    $getlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                                    $rowl = mysqli_fetch_array($getlossed);
                                    $lossedstock = $rowl['lossedstock'];
                                    $stockleft = $addedstock - $issuedstock - $lossedstock;
                                ?>

                                    <tr class="gradeA">
                                        <td><?php echo $stockitem_id; ?></td>
                                        <td><?php echo $stockitem; ?></td>
                                        <td><?php echo $minstock; ?></td>
                                        <td><?php echo $stockleft; ?></td>
                                        <td>
                                            <div class="tooltip-demo">
                                                <?php
                                                $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                $row2 =  mysqli_fetch_array($getmeasure);
                                                $measurement2 = $row2['measurement'];
                                                echo $measurement2; ?> </div>
                                        </td>
                                        <td><?php
                                            $getcat =  mysqli_query($con, "SELECT * FROM categories WHERE status=1 AND category_id='$cat_id'");
                                            $row1 =  mysqli_fetch_array($getcat);
                                            $category_id = $row1['category_id'];
                                            $category = $row1['category'];
                                            echo $category;
                                            ?></td>
                                        <td><?php if ($stockleft <= $minstock) {
                                                echo '<div class="text-danger">LOW</div>';
                                            } else {
                                                echo 'HIGH';
                                            } ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->



                    <div class="well m-t">
                        <strong style="font-style: italic">@<?php echo date('Y', $timenow); ?> All Rights Reserved<strong>
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

        <script type="text/javascript">
            // window.print();
        </script>

</body>

</html>