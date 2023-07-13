<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = $_GET['start'];
$en = $_GET['end'];
$start = strtotime($_GET['start']);
$end = strtotime($_GET['end'])
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

    <title>Reservations Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/reservationsreportprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>


                </div>
                <h1 class="text-center">Reservations Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h1>


                <div class="table-responsive m-t">

                    <?php
                    // $checkedouts =  mysqli_query($con, "SELECT * FROM checkoutdetails WHERE timestamp>='$start' AND timestamp<='$end'");


                    $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status IN(0,1,2)");

                    if (mysqli_num_rows($reservations) > 0) {
                    ?>
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Guest</th>
                                    <th>Room Number</th>
                                    <th>No. Occupants</th>
                                    <th>Origin</th>
                                    <th>Business</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Charge</th>
                                    <th>Amount paid</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dtotalcharge = 0;
                                $totaladvance = 0;

                                function getForexConvertedAmount($currencyrate, $amount)
                                {
                                    return intval($amount) * floatval($currencyrate);
                                }

                                while ($row =  mysqli_fetch_array($reservations)) {
                                    // $row =  mysqli_fetch_array($reservations);

                                    $reserve_id = $row['reservation_id'];
                                    $firstname = $row['firstname'];
                                    $lastname = $row['lastname'];
                                    $checkin = $row['checkin'];
                                    $phone = $row['phone'];
                                    $checkout = $row['checkout'];
                                    $room_id = $row['room'];
                                    $email = $row['email'];
                                    $adults = $row['adults'] ?? 0;
                                    $kids = $row['kids'] ?? 0;
                                    $business = $row['business'];
                                    $origin = $row['origin'];
                                    $status = $row['status'];
                                    $creator = $row['creator'];
                                    $status = $row['status'];
                                    $charge = $row['charge'];
                                    $advance = $row['advance'];


                                    if ($status == 2) {
                                        $checkedouts = mysqli_query($con, "SELECT * FROM checkoutdetails WHERE reserve_id='$reserve_id'");
                                        $row2 = mysqli_fetch_array($checkedouts);
                                        // $checkoutdetails_id = $row2['checkoutdetails_id'];
                                        // $reserve_id = $row2['reserve_id'];
                                        $paidamount = $row2['paidamount'] ?? 0;
                                        $totalbill = $row2['totalbill'] ?? 0;
                                    } else {
                                        $getpayments = mysqli_query($con, "SELECT SUM(amount) AS totalpaid FROM payments WHERE reservation_id='$reserve_id'");
                                        $payrow = mysqli_fetch_array($getpayments);
                                        $paidamount = $payrow['totalpaid'];
                                    }
                                    $checkout = $row['checkout'];
                                    $actualcheckout = $row['actualcheckout'];
                                    $reduction = $row['reduction'];
                                    $room_id = $row['room'];
                                    $email = $row['email'];
                                    $status = $row['status'];
                                    $adults = $row['adults'];
                                    $country = $row['origin'];
                                    $creator = $row['creator'];

                                    $currency = $row['currency'];
                                    $currencyrate = 1;
                                    if (!empty($currency) && $currency !== "USD") {
                                        $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status='1'");
                                        $curow = mysqli_fetch_array($getcurrencies);
                                        $currencyrate = $curow["rate"];
                                    }

                                    if ($status == 2) {
                                        $nights = round(($actualcheckout - $checkin) / (3600 * 24));
                                    } else {
                                        $nights =  round(($checkout - $checkin) / (3600 * 24));
                                    }

                                    $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                    $row1 =  mysqli_fetch_array($getnumber);
                                    $roomnumber = $row1['roomnumber'];
                                    $type_id = $row1['type'];

                                    $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                    $row1 =  mysqli_fetch_array($roomtypes);
                                    $roomtype = $row1['roomtype'];
                                    $dollarCharge =  $row1['charge'];
                                    $charge = getForexConvertedAmount($currencyrate, $dollarCharge);

                                    $totalcharge = $dollarCharge * $nights;
                                    if (!empty($reduction))
                                        $totalcharge -= $reduction;
                                    $totalcharge = getForexConvertedAmount($currencyrate, $totalcharge);
                                    // $totalotherservices = 0;
                                    // $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$reserve_id' AND status=1") or die(mysqli_error($con));
                                    // if (mysqli_num_rows($getotherservices) > 0) {
                                    //     while ($row3 = mysqli_fetch_array($getotherservices)) {
                                    //         $otherservice_id = $row3['otherservice_id'];
                                    //         $otherservice = $row3['otherservice'];
                                    //         $currency = $row3['currency'];
                                    //         if ($currency == 'USD') {
                                    //             $rate = $usdtariff;
                                    //         } else {
                                    //             $rate = 1;
                                    //         }
                                    //         $reduction = $row3['reduction'] * $rate;
                                    //         $price = $row3['price'] * $rate;
                                    //         $timestamp = $row3['timestamp'];
                                    //         $subtotal = $price - $reduction;
                                    //         $totalotherservices = $totalotherservices + $subtotal;
                                    //     }
                                    // }

                                    // $restbill = 0;
                                    // $restorder = mysqli_query($con, "SELECT * FROM orders WHERE guest='$reserve_id' AND status IN(1,2)");
                                    // if (mysqli_num_rows($restorder) > 0) {
                                    //     while ($row =  mysqli_fetch_array($restorder)) {
                                    //         $order_id = $row['order_id'];
                                    //         $guest = $row['guest'];
                                    //         $timestamp = $row['timestamp'];
                                    //         $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                                    //         $row =  mysqli_fetch_array($totalcharges);
                                    //         $totalrestcosts = getForexConvertedAmount(1, $row['totalcosts']);
                                    //         $restbill = $totalrestcosts + $restbill;
                                    //     }
                                    // }

                                    // $totallaundry = 0;
                                    // $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND reserve_id='$reserve_id' ORDER BY timestamp");
                                    // if (mysqli_num_rows($laundry)) {
                                    //     while ($row =  mysqli_fetch_array($laundry)) {
                                    //         $laundry_id = $row['laundry_id'];
                                    //         $reserve_id = $row['reserve_id'];
                                    //         $clothes = $row['clothes'];
                                    //         $package_id = $row['package_id'];
                                    //         $timestamp = $row['timestamp'];
                                    //         $status = $row['status'];
                                    //         $creator = $row['creator'];
                                    //         $invoice_no = 23 * $reserve_id;
                                    //         $charge = getForexConvertedAmount(1, $row['charge']);
                                    //         $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                    //         $row2 =  mysqli_fetch_array($reservation);
                                    //         $firstname = $row2['firstname'];
                                    //         $lastname = $row2['lastname'];
                                    //         $room_id = $row2['room'];
                                    //         $phone = $row2['phone'];

                                    //         $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                                    //         $row3 = mysqli_fetch_array($getpackage);
                                    //         $laundrypackage = $row3['laundrypackage'];
                                    //         $totallaundry = $totallaundry + $charge;
                                    //     }
                                    // }

                                    // $totalbill = $totallaundry + $restbill + $totalcharge + $totalotherservices;

                                    $advance = $paidamount;
                                    $dtotalcharge += $totalcharge;
                                    $totaladvance += $advance;

                                ?>

                                    <tr class="gradeA">
                                        <td><?php echo $firstname . ' ' . $lastname; ?></td>

                                        <td class="center">
                                            <?php
                                            $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1 =  mysqli_fetch_array($roomtypes);
                                            $roomtype = $row1['roomnumber'];
                                            echo $roomtype; ?>
                                        </td>
                                        <td><?php echo $adults + $kids; ?></td>
                                        <td><?php echo $origin; ?></td>
                                        <td><?php echo $business; ?></td>
                                        <td><?php echo date('d/m/Y', $checkin); ?></td>
                                        <td><?php echo date('d/m/Y', $checkout); ?></td>
                                        <td><?php echo number_format($totalcharge); ?></td>
                                        <td><?php echo number_format($advance); ?></td>
                                        <td><?php if ($status == 0) {
                                                echo 'Pending';
                                            }
                                            if ($status == 1) {
                                                echo 'Guest In';
                                            }
                                            if ($status == 2) {
                                                echo 'Guest Out';
                                            } ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <th colspan="2">TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo number_format($dtotalcharge); ?></th>
                                    <th><?php echo number_format($totaladvance); ?></th>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div><!-- /table-responsive -->
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