<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = $_GET['st'];
$en = $_GET['en'];
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

    <title>Inventory Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/stockreportprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo;  ?>" class="img img-responsive"></div>


                </div>
                <h1 class="text-center">Inventory Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?></h1>
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


                                $getadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems AS q LEFT JOIN addedstock AS o ON o.addedstock_id = q.addedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                $rowa = mysqli_fetch_array($getadded);
                                $addedstock = $rowa['addedstock'];
                                $getissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems AS q LEFT JOIN issuedstock AS o ON o.issuedstock_id = q.issuedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
                                $rowi = mysqli_fetch_array($getissued);
                                $issuedstock = $rowi['issuedstock'];
                                $getlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems AS q LEFT JOIN itemlosses AS o ON o.itemloss_id = q.itemloss_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
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

                            
                            ?>
                                <tr>
                                    <td><?php echo $item; ?></td>
                                    <td><?php echo number_format($instock); ?></td>
                                    <td><?php echo number_format($addedstock); ?></td>
                                    <td><?php echo number_format($issuedstock); ?></td>
                                    <td><?php echo number_format($lossedstock); ?></td>
                                    <td><?php echo number_format($stockleft); ?></td>
                                </tr>
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
        window.print();
    </script>

</body>

</html>