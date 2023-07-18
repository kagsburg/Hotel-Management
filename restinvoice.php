<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant') && ($_SESSION['sysrole'] != 'Accountant' && $_SESSION['sysrole'] != 'Marketing and Events'&& $_SESSION['sysrole'] != 'Kitchen Exploitation Officer')) {
    header('Location:login.php');
}
$order_id = $_GET['id'];
$restorder = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) and order_id='$order_id'");
if (mysqli_num_rows($restorder) == 0) {
    header('Location:getrestaurantreport');
    exit();
}
$row =  mysqli_fetch_array($restorder);
$order_id = $row['order_id'];
$guest = $row['guest'];
$mode = $row['mode'];
$rtable = $row['rtable'];
$vat = $row['vat'];
$customer = $row['customer'];
$waiter = $row['waiter'];
$creator = $row['creator'];
$timestamp = $row['timestamp'];
$getyear = date('Y', $timestamp);
$count = 1;
// get table name 
$table = mysqli_query($con, "SELECT * FROM hoteltables WHERE hoteltable_id='$rtable' AND status='1'");
$rowt = mysqli_fetch_array($table);
$tablename = $rowt['table_no'];
$beforeorders =  mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND  order_id<'$order_id'") or die(mysqli_error($con));
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
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restaurant Order Invoice | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/restinvoice.php';
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
                    <div class="col-lg-8">
                        <h2>Restaurant Order Invoice</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a href="index">Home</a>
                            </li>
                            <li>
                                Restaurant
                            </li>
                            <li class="active">
                                <strong>Invoice</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-4">
                        <div class="title-action">
                            <!--                        <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>-->
                            <a href="restinvoice_print?id=<?php echo $order_id; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wrapper wrapper-content animated fadeInRight">
                            <div class="ibox-content p-xl">
                                <div class="row">

                                    <div class="col-sm-12" style="font-size:20px;font-family: times new roman">
                                        <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive" width="200">
                                        <div class="w-100">
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>Chato Beach Resort</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>TIN: 136073761</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>P.O Box 54 Chato, Geita</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>Tel: +255758301785</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                            </div>
                                        </div>
                                        <h4 class="text-navy"># <?php echo $invoice_no; ?></h4>
                                        <?php
                                        if ($customer == 1) { ?>
                                            <span>
                                                <strong>
                                                    Guest Information <br>
                                                    Full Names:
                                                </strong>
                                                <?php
                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                                                if (mysqli_num_rows($reservation) > 0){
                                                    $row =  mysqli_fetch_array($reservation);
                                                    $firstname1 = $row['firstname'];
                                                    $lastname1 = $row['lastname'];
                                                    echo $firstname1 . ' ' . $lastname1;

                                                }else{
                                                    echo " Guest";
                                                }

                                                ?>
                                            </span><br />
                                            <!-- <span>NIF:</span><br>
                                            <span>Salle: 100</span><br>
                                            <span>Assujetti à la TVA: Oui Non</span><br>
                                            <span>Doit pour ce qui suit:</span><br> -->
                                        <?php }
                                        if ($customer == 2) { ?>                                        
                                            <span>
                                                <strong>Customer Name:</strong>
                                                <?php
                                                $customers = mysqli_query($con, "SELECT * FROM customers WHERE status='1' AND customer_id='$guest'") or die(mysqli_errno($con));
                                                $row = mysqli_fetch_array($customers);

                                                $customername = $row['customername'];
                                                echo $customername;
                                                ?></span><br />
                                        <?php } ?>

                                        <address>
                                            <span><strong>Order Date:</strong> <?php echo date('d/m/Y', $timestamp); ?></span><br />
                                            <span><strong>Table:</strong> <?php echo $tablename; ?></span><br>
                                            <span><strong>Waiter:</strong> <?php echo $waiter; ?></span><br />
                                            
                                            <?php
                                            if (!empty($mode)) {
                                            ?>
                                                <span><strong>Payment:</strong> <?php echo $mode; ?></span><br>
                                            <?php }
                                            $checkcredit = mysqli_query($con, "SELECT * FROM creditpayments WHERE order_id='$order_id'") or die(mysqli_error($con));
                                            if (mysqli_num_rows($checkcredit) > 0) {
                                                $rowc = mysqli_fetch_array($checkcredit);
                                                $cstatus = $rowc['status'];
                                                $fullname = $rowc['fullname'];
                                                $phone = $rowc['phone'];
                                            ?>
                                                <span><strong>Customer : </strong> <?php echo $fullname; ?></span><br />
                                                <span><strong>Phone : </strong> <?php echo $phone; ?></span>
                                            <?php }
                                            ?>
                                        </address>


                                    </div>

                                    <div class="col-sm-6 text-right">


                                    </div>

                                </div>

                                <div class="table-responsive m-t">

                                    <table class="table invoice-table" style="font-size:20px; font-family:times new roman">
                                        <thead>
                                            <tr>
                                                <th>ITEM</th>
                                                <th>QTY</th>
                                                <th>Unit Price</th>
                                                <!-- <th>TVA</th> -->
                                                <th>Sub Total</th>

                                            </tr>
                                        </thead>
                                        <tbody>
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
                                                    //                 $tva=($price*$vat)/100;
                                                    //                 $puhtva=$price-$tva;
                                                    $puhtva = round($price / (($vat / 110) + 1));
                                                    $tva = $price - $puhtva;
                                                } else {
                                                    $tva = 0;
                                                    $puhtva = $price;
                                                }
                                                $pthtva = $puhtva * $quantity;
                                                $total = ($total + $pthtva);
                                                $vatamount = $tva * $quantity;
                                                $totaltax = ($total * 0.18);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <strong>
                                                                <?php
                                                                $foodmenu = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                                                                $row =  mysqli_fetch_array($foodmenu);
                                                                $menuitem_id = $row['menuitem_id'];
                                                                $menuitem = $row['menuitem'];
                                                                echo $menuitem;
                                                                ?>
                                                            </strong>
                                                        </div>
                                                    </td>
                                                    <td> <?php echo $quantity; ?></td>
                                                    <td><?php echo $puhtva; ?></td>
                                                    <!-- <td><?php echo $tva; ?></td> -->
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
                                            <td><strong><?php echo number_format($total); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="well m-t">
                                    <strong style="font-style: italic;font-size: 20px">Thanks for Spending Time at our Restaurant</strong>
                                </div>
                                <div class="d-flex">
                                    <div class="ml-auto">
                                        <?php if (!empty($mode) && $mode == "Credit") { ?>
                                            <p class="fs-16" style="margin-bottom: 30px;">
                                                Signature:
                                            </p>
                                        <?php } ?>
                                        <p class="fs-16">
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


</body>

</html>