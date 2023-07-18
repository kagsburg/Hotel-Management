<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != "Restaurant Attendant")&& ($_SESSION['sysrole'] != 'Kitchen Exploitation Officer')&& ($_SESSION['sysrole'] != 'Accountant')) {
    header('Location:login.php');
}
$waiter = $_GET['waiter'];
//   $instructions=$_GET['instructions'];
$guest = $_GET['guest'];
//   $vat=$_GET['vat'];
//       $customer=$_GET['customer'];
//      $discount=$_GET['discount'];
$ordertype = 1;
$rtable = $_GET['rtable'];
$table = mysqli_query($con, "SELECT * FROM hoteltables WHERE hoteltable_id='$rtable' AND status='1'");
$rowt =  mysqli_fetch_array($table);
$table_no = $rowt['table_no'];
$gettax = mysqli_query($con, "SELECT * FROM taxes WHERE tax_id=2");
$rowt = mysqli_fetch_array($gettax);
$vat = $rowt['rate'];

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Restaurant Order- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/restorderdetails.php';
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
                        <h2>Restaurant Order Details</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="addrestaurantorder">Add Order</a> </li>
                            <li class="active">
                                <strong>Order Details</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-5">

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Order Details</h5>

                                </div>
                                <div class="ibox-content">
                                    <div class="feed-activity-list">

                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Attendant</strong> : <?php echo $waiter; ?> <br>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Table</strong> : <?php echo $table_no; ?> <br>
                                            </div>
                                        </div>
                                        <!--                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Instructions</strong>  : <?php //echo $instructions; 
                                                                                                                    ?> <br>
                                             </div>
                                    </div>-->
                                    </div>
                                </div>
                            </div>
                            <a href="cancelrestorder" class="btn btn-danger"><i class="fa fa-trash"></i> Cancel</a>
                            <a href="addrestorder?waiter=<?php echo $waiter; ?>&&guest=<?php echo $guest; ?>&&ordertype=<?php echo $ordertype; ?>&&vat=<?php echo $vat; ?>&&table=<?php echo $rtable; ?>" class="btn btn-success"><i class="fa fa-save"></i> Save Order</a>
                        </div>

                        <div class="col-lg-7">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Guest ordered items</h5>
                                    <label class="label label-info pull-right" id="label-info">
                                        <?php
                                        if (isset($_SESSION["rproducts"])) {
                                            echo count($_SESSION["rproducts"]);
                                        } else {
                                            echo 0;
                                        }
                                        ?>
                                    </label>
                                </div>
                                <div class="ibox-content ">
                                    <?php

                                    if (isset($_SESSION["rproducts"]) && count($_SESSION["rproducts"]) > 0) { //if we have session variable
                                        //		$cart_box = '<ul class="cart-products-loaded">';
                                        $total = 0;


                                    ?>

                                        <div class="table-responsive m-t">

                                            <table class="table invoice-table">
                                                <thead>
                                                    <tr>
                                                        <th>ITEM</th>
                                                        <th>QTY</th>
                                                        <th>PUHTVA</th>
                                                        <th>TVA</th>
                                                        <th>PTHTVA</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $totaltax = 0;
                                                    $total = 0;
                                                    foreach ($_SESSION["rproducts"] as $product) { //loop though items and prepare html content

                                                        //set variables to use them in HTML content below
                                                        $menuitem = $product["menuitem"];
                                                        $itemprice = $product["itemprice"];
                                                        $item_id = $product["item_id"];
                                                        $product_qty = $product["product_qty"];

                                                        $getfooditem = mysqli_query($con, "SELECT * FROM menuitems WHERE status='1' AND menuitem_id='$item_id'");
                                                        $row =  mysqli_fetch_array($getfooditem);
                                                        $taxed = $row['taxed'];
                                                        if ($taxed == 'yes') {
                                                            $puhtva = round($itemprice / (($vat / 100) + 1));
                                                            $tva = $itemprice - $puhtva;
                                                        } else {
                                                            $tva = 0;
                                                            $puhtva = $itemprice;
                                                        }
                                                        $pthtva = $puhtva * $product_qty;
                                                        $total = ($total + $pthtva);
                                                        $vatamount = $tva * $product_qty;
                                                        $totaltax = $totaltax + $vatamount;
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <div><strong>
                                                                        <?php echo $menuitem; ?>
                                                                    </strong></div>
                                                            </td>
                                                            <td> <?php echo $product_qty; ?></td>
                                                            <td><?php echo $puhtva; ?></td>
                                                            <td><?php echo $tva; ?></td>
                                                            <td><?php echo $pthtva; ?></td>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div><!-- /table-responsive -->

                                        <table class="table invoice-total">
                                            <tbody>
                                                <tr>
                                                    <td><strong>TOTAL :</strong></td>
                                                    <td><strong><?php echo number_format($total); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>VAT :</strong></td>
                                                    <td><strong><?php echo number_format($totaltax); ?></strong></td>
                                                </tr>
                                                <tr>

                                                    <td><strong>NET :</strong></td>
                                                    <td><strong><?php echo number_format($totaltax + $total); ?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?php

                                    } else {
                                        echo "<div class='alert alert-danger'>No Ordered items added yet</div>"; //we have empty cart
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

    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
</body>

</html>