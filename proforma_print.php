<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}


$getsettings = mysqli_query($con, "SELECT * FROM settings");
$settings = mysqli_fetch_array($getsettings);
$hotelname = $settings['hotelname'];

$id = $_GET['id'];
$reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
$row =  mysqli_fetch_array($reservation);
$firstname1 = $row['firstname'];
$lastname1 = $row['lastname'];
$currency = $row['currency'];
$advance = $row['advance'];
$currencyrate = 1;
$companyname = $row['companyname'];

// if (!empty($currency) && $currency !== "USD") {
//     $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status='1'");
//     $curow = mysqli_fetch_array($getcurrencies);
//     $currencyrate = $curow["rate"];
// }
// function getForexConvertedAmount($currencyrate, $amount)
// {
//     return intval($amount) * floatval($currencyrate);
// }

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $firstname1 . ' ' . $lastname1; ?> Proforma | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .wrapper {
            display: flex;
            flex-direction: column;
        }
        .big-footer {
            margin-top: auto;
        }
        .zhead span {
            font-size: 13px !important;
        }
    </style>
</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/proforma_print.php';
    } else {
    ?><div class="wrapper wrapper-content animated fadeInRight">

            <div class="ibox-content p-xl">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive">
                                    </div>
                                    <div class="col-sm-9 pull-right">
                                        <h2 class="text-center mb-4"><strong><?php echo $hotelname; ?></strong></h2>
                                        <div class="d-flex" style="justify-content: space-between;">
                                            <span></span>
                                            <span>Chato Beach Resort Company Limited</span>
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
                                </div>
                                <div class="row" style="margin-top: 12px;">
                                    <div class="col-sm-6">
                                        <span>
                                            <strong>
                                                Guest Information <br>
                                                Full Names:
                                            </strong>
                            <?php
                            $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
                            $row =  mysqli_fetch_array($reservation);
                            $firstname1 = $row['firstname'];
                            $lastname1 = $row['lastname'];
                            $room = $row['room'];
                            $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room'");
                            $row1 =  mysqli_fetch_array($getnumber);
                            $roomnumber = $row1['roomnumber'];
                            echo $firstname1 . ' ' . $lastname1;

                            ?>
                        </span><br />
                        <!--<span><strong>NIF:</strong></span><br>-->
                                        <span><strong>Room No:</strong> <?php echo $roomnumber; ?></span><br>
                                        <!--<span><strong>Assujetti à la TVA:</strong> Oui Non</span><br>-->
                                        <!--<span><strong>Doit pour ce qui suit:</strong></span><br>-->
                                        <?php if ($companyname!='') { 
                                            $getcompany = mysqli_query($con, "SELECT * FROM sponsors WHERE sponsor_id='$companyname' and status='1'")or die(mysqli_error($con));
                                            $row = mysqli_fetch_array($getcompany);
                                            $company_name = $row['company_name'];
                                            $company_contact = $row['company_contact'];
                                            ?>
                                            <span><strong>Sponsor Name:</strong> <?php echo $company_name; ?></span><br>
                                            <span><strong>Sponsor Contact:</strong> <?php echo $company_contact; ?></span><br>
                                        <?php } ?>
                                        <address>
                                            <span><strong>Date:</strong> <?php echo date('d/m/Y', $timenow); ?></span><br />
                                        </address>


                    </div>

                </div>
                <?php
                $vat=0.18;
                $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
                $row =  mysqli_fetch_array($reservations);
                $reservation_id = $row['reservation_id'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $checkin = $row['checkin'];
                $phone = $row['phone'];
                //$id_number=$row['id_number'];
                $checkout = $row['checkout'];
                $actualcheckout = $row['actualcheckout'];
                $room_id = $row['room'];
                $email = $row['email'];
                $status = $row['status'];
                $creator = $row['creator'];
                $reduction = $row['reduction'];
                $invoice_no = 23 * $id;
                if ($status == 2) {
                    $nights = round(($actualcheckout - $checkin) / (3600 * 24));
                } else {
                    $nights =  round(($checkout - $checkin) / (3600 * 24));
                }
                $totalreduction = intval($reduction) * $nights;
                ?>
                <h2 class="text-center" style="margin-bottom: 8px;"><strong>PROFORMA INVOICE</strong></h2>
                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Type</th>
                                <th>Checkin</th>
                                <th>Checkout</th>
                                <th>Nights</th>
                                <th>Unit Charge</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div><strong>
                                            <?php
                                            $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1 =  mysqli_fetch_array($getnumber);
                                            $roomnumber = $row1['roomnumber'];
                                            $type_id = $row1['type'];
                                            echo $roomnumber; ?>
                                        </strong></div>
                                </td>
                                <td> <?php
                                        $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                        $row1 =  mysqli_fetch_array($roomtypes);
                                        $roomtype = $row1['roomtype'];
                                        $dollarcharge = $row1['charge'];
                                        $charge = $dollarcharge;
                                        $total = $charge * $nights;
                                        $totalvat = ((($total - $totalreduction) * $vat));
                                        $htva = $total - $totalvat - $totalreduction;
                                        $net = $htva + $totalvat;
                                        //if advance is null 
                                        // $advance = empty($advance) ? 0 : $advance;
                                        $getpayments = mysqli_query($con, "SELECT SUM(amount) AS totalpaid FROM payments WHERE reservation_id='$id' and status='1'");
        $payrow = mysqli_fetch_array($getpayments);
        $paidamount = $payrow['totalpaid'];
        $advance = empty($advance) ? $paidamount : ($paidamount==0 ? $advance : $paidamount);
                                        echo $roomtype;
                                        ?></td>
                                <td><?php echo date('d/m/Y', $checkin); ?></td>
                                <td><?php
                                    if ($status == 2) {
                                        echo date('d/m/Y', $actualcheckout);
                                    } else {
                                        echo date('d/m/Y', $checkout);
                                    }
                                    ?></td>
                                <td><?php echo $nights; ?></td>
                                <td><?php echo number_format($charge); ?></td>

                            </tr>


                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                        <?php
                        $totalcharge = $charge * $nights;
                        if (!empty($reduction)) { ?>
                            <tr>
                                <td>SUBTOTAL :</td>
                                <td><?php

                                    echo number_format($totalcharge) . " " . $currency; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>REDUCTION: </td>
                                <td><?php echo number_format($reduction) . " " . $currency; ?></td>
                            </tr>
                        <?php
                            $totalcharge = $dollarCharge * $nights;
                            $totalcharge -= $reduction;
                            // $totalcharge = getForexConvertedAmount($currencyrate, $totalcharge);
                        } ?>
                        <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td><strong><?php echo number_format($totalcharge) . " TSHS"; ?></strong></td>
                        </tr>
                      <!--  <tr>
                                            <td>HTVA :</td>
                                            <td style="text-align: right;"><?php echo number_format($htva); ?></td>
                                        </tr>-->
                                        <tr>
                                            <td>VAT :</td>
                                            <td style="text-align: right;"><?php echo number_format($totalvat) . " TSHS"; ?></td>
                                        </tr>
                        <tr>
                                            <td>PAID :</td>
                                            <td><?php echo number_format( $advance ); ?></td>
                        </tr>
                        <tr>
                                            <td>BALANCE :</td>
                                            <td><strong><?php echo number_format($net - $advance ) . " TSHS"; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                $totalotherservices = 0;
                $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$id' AND status=1") or die(mysqli_error($con));
                if (mysqli_num_rows($getotherservices) > 0) {
                ?>
                    <h2 class="text-center">OTHER SERVICES</h2>
                    <div class="table-responsive m-t">
                        <table class="table invoice-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Charge</th>
                                    <th>Reduction</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($row3 = mysqli_fetch_array($getotherservices)) {
                                    $otherservice_id = $row3['otherservice_id'];
                                    $otherservice = $row3['otherservice'];
                                    $currency = $row3['currency'];
                                    if ($currency == 'USD') {
                                        $rate = $usdtariff;
                                    } else {
                                        $rate = 1;
                                    }
                                    $reduction = intval($row3['reduction']) * $rate;
                                    $price = intval($row3['price']) * $rate;
                                    $timestamp = $row3['timestamp'];
                                    $subtotal = $price - $reduction;
                                    $totalotherservices = $totalotherservices + $subtotal;
                                ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                        <td><?php echo $otherservice;  ?></td>
                                        <td><?php echo $price;  ?></td>
                                        <td><?php echo $reduction;  ?></td>
                                        <td><?php echo $subtotal;  ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->

                    <table class="table invoice-total">
                        <tbody>
                            <tr>
                                <td><strong>TOTAL :</strong></td>
                                <td><strong><?php
                                            echo number_format($totalotherservices); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                <?php
                }
                $totalaccomodation = $totalotherservices + $totalcharge;

                $restbill = 0;
                $restorder = mysqli_query($con, "SELECT * FROM orders WHERE guest='$id' AND status IN(1,2)");
                if (mysqli_num_rows($restorder) > 0) {
                ?>
                    <h2 class="text-center">RESTAURANT ORDERS</h2>
                    <?php


                    while ($row =  mysqli_fetch_array($restorder)) {
                        $order_id = $row['order_id'];
                        $guest = $row['guest'];
                        $timestamp = $row['timestamp'];
                    ?>
                        <div class="table-responsive m-t">

                            <h3><i>Order Taken on <?php echo date('d/m/Y', $timestamp); ?></i></h3>
                            <table class="table invoice-table">
                                <thead>
                                    <tr>
                                        <th>Food Name</th>
                                        <th>Items</th>
                                        <th>Unit Charge</th>
                                        <th>Total Charge</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                                    while ($row3 =  mysqli_fetch_array($foodsordered)) {
                                        $restorder_id = $row3['restorder_id'];
                                        $food_id = $row3['food_id'];
                                        $price =  $row3['foodprice'];
                                        $quantity = $row3['quantity'];
                                        //                      $type=$row3['type'];

                                    ?>
                                        <tr>
                                            <td>
                                                <div><strong>
                                                        <?php

                                                        $foodmenu = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                                                        $row =  mysqli_fetch_array($foodmenu);
                                                        $menuitem_id = $row['menuitem_id'];
                                                        $menuitem = $row['menuitem'];

                                                        echo $menuitem;

                                                        ?>
                                                    </strong></div>
                                            </td>
                                            <td> <?php echo $quantity; ?></td>

                                            <td><?php echo number_format($price); ?></td>
                                            <td><?php echo number_format($price * $quantity); ?></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div><!-- /table-responsive -->

                        <table class="table invoice-total">
                            <tbody>
                                <tr>
                                    <?php
                                    $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                                    $row =  mysqli_fetch_array($totalcharges);
                                    $totalrestcosts = $row['totalcosts'];
                                    $restbill = $totalrestcosts + $restbill;
                                    ?>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($restbill); ?> TSHS</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php
                    }
                }

                $totallaundry = 0;
                $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' ORDER BY timestamp");
                if (mysqli_num_rows($laundry)) {
                    ?>
                    <h2 class="text-center">LAUNDRY WORK</h2>
                    <?php

                    while ($row =  mysqli_fetch_array($laundry)) {
                        $laundry_id = $row['laundry_id'];
                        $reserve_id = $row['reserve_id'];
                        $clothes = $row['clothes'];
                        $package_id = $row['package_id'];
                        $timestamp = $row['timestamp'];
                        $status = $row['status'];
                        $creator = $row['creator'];
                        $invoice_no = 23 * $id;
                        $charge =$row['charge'];
                        $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                        $row2 =  mysqli_fetch_array($reservation);
                        $firstname = $row2['firstname'];
                        $lastname = $row2['lastname'];
                        $room_id = $row2['room'];
                        $phone = $row2['phone'];
                        $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                        $row3 = mysqli_fetch_array($getpackage);
                        $laundrypackage = $row3['laundrypackage'];
                        $totallaundry = 0;
                        $getlaundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE reserve_id='$reserve_id' AND timestamp='$timestamp' AND status='1'");
                        
                        while ($row4 = mysqli_fetch_array($getlaundry2)) {
                            $totallaundry += $row4['clothes'] * $row4['charge'];
                        }
                        $totalvat = ((($totallaundry ) * $vat));
                        $net =  $totallaundry;
                    ?>
                        <div class="table-responsive m-t">
                            <h3><i>Laundry Work on <?php echo date('d/m/Y', $timestamp); ?></i></h3>
                            <table class="table invoice-table">
                                <thead>
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Number of Clothes</th>
                                        <th>Date</th>
                                        <th>Charge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div><strong>
                                                    Laundry Work
                                                </strong></div>
                                        </td>
                                        <td><?php echo $clothes;  ?></td>
                                        <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                        <td><?php echo number_format($charge); ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div><!-- /table-responsive -->

                    <?php }   ?>
                    <table class="table invoice-total">
                        <tbody>
                            <tr>
                                <td><strong>TOTAL :</strong></td>
                                <td><strong><?php echo number_format($totallaundry); ?> TSHS</strong></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }
                $name =  mysqli_query($con, "SELECT * FROM users WHERE user_id='" . $_SESSION['hotelsys'] . "'");
                $row =  mysqli_fetch_array($name);
                $employee = $row['employee'];
                $getemployee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee'");
                $roww = mysqli_fetch_array($getemployee);
                $fullname = $roww['fullname'];
                ?>
                <table class="table table-responsive table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>TOTAL BILL</th>
                            <th style="text-align: right"><?php echo number_format($totallaundry + $restbill + $totalcharge + $totalotherservices) . " " . $currency; ?></th>
                        </tr>
                    </thead>
                </table>
                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td style="padding-bottom: 30px;"><strong>Created by <?php echo $fullname; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                


            </div>
            <div class="big-footer">
                <div class="footer-text__block text-center">
                    <span>Chato, Geita Tanzania• Tel (255) 0758301785 • VAT NO: 400297540</span> <br>
                    <span>Email: info@chatobeachresort.com• Website: www.chatobeachresort.com</span>
                </div>
            </div>
        </div>


    <?php } ?>

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script> -->

    <!-- Custom and plugin javascript -->
    <!-- <script src="js/inspinia.js"></script> -->
    <!-- <script src="js/plugins/pace/pace.min.js"></script> -->
    <script type="text/javascript">
        $(function() {
            setTimeout(() => {
                window.print();
            }, 900)
        })
    </script>

</body>

</html>