<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = $_GET['st'];
$en = $_GET['en'];
$end = $en;
$at = $_GET['at'];
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

    <title>Restaurant Invoices Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/restinvoicesreportprint.php';
    } else {
        $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$at'");
        $row = mysqli_fetch_array($employee);
        $employeename = $row['fullname'];
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>


                </div>
                <h1 class="text-center">Restaurant Invoices Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?> for <?php echo $employeename; ?></h1>
                <div class="table-responsive m-t">
                    <?php
                    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1, 2) AND timestamp>='$st' AND timestamp <= '$end' AND creator='$at'");
                    if (mysqli_num_rows($restorders) > 0) {
                    ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Invoice Id</th>
                                    <th>Date</th>
                                    <th>Guest</th>
                                    <th>Total Bill</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalsells = 0;
                                $totalcreditpaid = 0;
                                $totalcreditbalance = 0;
                                $totalbonus = 0;
                                $totalcash = 0;
                                $residentspaid = 0;
                                $residentsunpaid = 0;
                                while ($row =  mysqli_fetch_array($restorders)) {
                                    $order_id = $row['order_id'];
                                    $guest = $row['guest'];
                                    $rtable = $row['rtable'];
                                    $vat = $row['vat'];
                                    $waiter = $row['waiter'];
                                    $status = $row['status'];
                                    $mode = $row['mode'];
                                    $timestamp = $row['timestamp'];
                                    $getyear = date('Y', $timestamp);
                                    $count = 1;
                                    $creator = $row['creator'];
                                    $beforeorders =  mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2)  AND  order_id<'$order_id'") or die(mysqli_error($con));
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
                                    <tr class="gradeA">
                                        <td><?php echo $invoice_no; ?></td>
                                        <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                        <td><?php
                                            $roomnumber = '';
                                            if ($guest > 0) {
                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                                                $row =  mysqli_fetch_array($reservation);
                                                $firstname1 = $row['firstname'];
                                                $lastname1 = $row['lastname'];
                                                $room_id = $row['room'];
                                                $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                $row1 =  mysqli_fetch_array($roomtypes);
                                                $roomnumber = $row1['roomnumber'];
                                                echo $firstname1 . ' ' . $lastname1 . ' (' . $roomnumber . ')';
                                            } else {
                                                echo 'Non Resident';
                                            }
                                            ?></td>
                                        <td><?php
                                            $totaltax = 0;
                                            $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id' ");
                                            while ($row3 =  mysqli_fetch_array($foodsordered)) {
                                                $restorder_id = $row3['restorder_id'];
                                                $food_id = $row3['food_id'];
                                                $price = $row3['foodprice'];
                                                $quantity = $row3['quantity'];
                                                $tax = $row3['tax'];
                                                $subprice = $price * $quantity;
                                                if ($tax == 1) {
                                                    $taxamount = ($subprice * $vat) / 110;
                                                    $totaltax = $totaltax + $taxamount;
                                                } else {
                                                    $taxamount = 0;
                                                }
                                            }
                                            $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                                            $row =  mysqli_fetch_array($totalcharges);
                                            $totalcosts = $row['totalcosts'];
                                            $net = $totaltax + $totalcosts;
                                            echo number_format($net);
                                            if ($guest > 0) {
                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                                                $rowg = mysqli_fetch_array($reservation);
                                                $status = $rowg['status'];
                                                if ($status == 2) {
                                                    $residentspaid = $residentspaid + $net;
                                                } else {
                                                    $residentsunpaid = $residentsunpaid + $net;
                                                }
                                            } else {
                                                if ($mode == 'Credit') {
                                                    $checkcredit = mysqli_query($con, "SELECT * FROM creditpayments WHERE order_id='$order_id'") or die(mysqli_error($con));
                                                    $rowc = mysqli_fetch_array($checkcredit);
                                                    $cstatus = $rowc['status'];
                                                    if ($cstatus == 0) {
                                                        $totalcreditbalance = $totalcreditbalance + $net;
                                                    } else {
                                                        $totalcreditpaid = $totalcreditpaid + $net;
                                                    }
                                                }
                                                if ($mode == 'Cash') {
                                                    $totalcash = $totalcash + $net;
                                                }
                                                if ($mode == 'Bonus') {
                                                    $totalbonus = $totalbonus + $net;
                                                }
                                            }
                                            $totalsells = $totalsells + $net;
                                            $total = ($totalsells - ($totalcreditbalance + $residentsunpaid));
                                            ?>
                                        </td>


                                    </tr>
                                <?php
                                } ?>
                            </tbody>

                        </table>
                        <table class="table table-bordered">
                            <tr>
                                <th>TOTAL SELL</th>
                                <th><?php echo $totalsells; ?></th>
                            </tr>
                            <tr>
                                <th>TOTAL CASH</th>
                                <th><?php echo $totalcash; ?></th>
                            </tr>
                            <tr>
                                <th>TOTAL BONUS</th>
                                <th><?php echo $totalbonus; ?></th>
                            </tr>
                            <tr>
                                <th>TOTAL CREDIT PAID</th>
                                <th><?php echo $totalcreditpaid; ?></th>
                            </tr>
                            <tr>
                                <th>RESIDENTS BILLS PAID</th>
                                <th><?php echo $residentspaid; ?></th>
                            </tr>
                            <tr>
                                <th>TOTAL CREDIT UNPAID</th>
                                <th><?php echo $totalcreditbalance; ?></th>
                            </tr>
                            <tr>
                                <th>RESIDENTS BILLS UNPAID</th>
                                <th><?php echo $residentsunpaid; ?></th>
                            </tr>
                            <tr>
                                <th>TOTAL</th>
                                <th><?php echo number_format($total); ?></th>
                            </tr>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <div class="alert alert-danger">No Invoices Added Yet</div>
                    <?php } ?>

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