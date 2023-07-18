<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$stdate = explode('/', $_GET['start']);
$endate = explode('/', $_GET['end']);
$st = $stdate[1].'/'.$stdate[0].'/'. $stdate[2] . ' ' . $_GET['stt'];
$en = $endate[1].'/'.$endate[0].'/'. $endate[2] . ' ' . $_GET['ent'];
$start = strtotime($st);
$end = strtotime($en);

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Overall Report - Hotel Manager</title>
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
        include 'fr/hallreport.php';
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
                        <h2>Overall Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>Overall  Report</strong>
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
                                <a href="overallreportprint?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Print PDF</a>&nbsp;
                                <!-- <a href="hallreportexcel?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Export to Excel</a> -->
                            </div>
                            <br>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Generated Overall Report</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $overall_total =0;
                                    $overall_total_vat =0;
                                    $overall_total_reduc=0;
                                    if ($start > $end) {
                                        $errors[] = 'Start Date Cant be later than End Date';
                                    }
                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                    ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php
                                        }
                                    } else {  ?>
                                        <h2 class="text-center">CONFERENCE ROOM REPORT</h2>
                                        <div class="table-responsive m-t">
                                            <?php
                                            $totalcosts = 0;
                                            $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE status IN(1,2) AND checkin>='$start' AND checkin<='$end'");
                                            if (mysqli_num_rows($reservations) > 0) {
                                            ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Customer</th>
                                                            <th>People</th>
                                                            <th>Dates</th>
                                                            <th>Purpose</th>
                                                            <th>Status</th>
                                                            <th>Charge</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row =  mysqli_fetch_array($reservations)) {
                                                            $hallreservation_id = $row['hallreservation_id'];
                                                            $fullname = $row['fullname'];
                                                            $checkin = $row['checkin'];
                                                            $phone = $row['phone'];
                                                            $checkout = $row['checkout'];
                                                            $status = $row['status'];
                                                            $people = $row['people'];
                                                            $purpose = $row['reason'] . ' ' . $row['description'];
                                                            $description = $row['description'];
                                                            $country = $row['country'];
                                                            $charge = $row['charge'];
                                                            $creator = $row['creator'];
                                                            $vat = 18;
                                                            $getdays = (($checkout - $checkin) / (24 * 3600)) + 1;
                                                            // round up the days
                                                            $getdays = floor($getdays);
                                                            $vatamount = ($people * $charge * $vat) / 100;
                                                            $hallcost = ($charge * $people);
                                                            // round up to 2 decimal places
                                                            // $hallcost = round($hallcost, 2);
                                                            $totalcosts += $hallcost;
                                                            $overall_total_vat += $vatamount;

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $fullname; ?></td>
                                                                <td>
                                                                    <?php echo $people; ?>
                                                                </td>
                                                                <td><?php echo date('d/m/Y', $checkin) . ' to ' . date('d/m/Y', $checkout);  ?></td>
                                                                <td><?php
                                                                    echo $purpose;
                                                                     ?>
                                                                </td>


                                                                <td><?php
                                                                    if ($status == 1) {
                                                                        echo 'BOOKED';
                                                                    } else if ($status == 2) {
                                                                        echo 'CHECKED IN';
                                                                    }
                                                                    ?></td>
                                                                <td><?php echo $hallcost;   ?></td>
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
                                                    $overall_total += $totalcosts;
                                                    echo number_format($totalcosts); ?> TSHS</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php } else { ?>
                                            <div class="alert alert-danger">No Conference Hall Reservations Found</div>
                                            <?php } ?>
                                        

                                    <?php
                                    }

                                    ?>
                                     <h2 class="text-center">RESERVATION REPORT</h2>
                                    <?php
                                                                                    // $checkedouts =  mysqli_query($con, "SELECT * FROM checkoutdetails WHERE timestamp>='$start' AND timestamp<='$end'");
                                            $qry = "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status IN(0,1,2)";
                                            $reservations = mysqli_query($con, $qry);
                                            if (mysqli_num_rows($reservations) > 0) {
                                                ?>
                                                <div style="overflow-x:auto;">
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
                                                            <th>Other Services</th>
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
                                                            $charge = $dollarCharge;
                                                            $totalcharge = $dollarCharge * $nights;
                                                            if (!empty($reduction)) {
                                                                $totalcharge -= $reduction;
                                                            }
                                                            // $totalcharge = getForexConvertedAmount($currencyrate, $totalcharge);


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
                                                                                                                <?php
                                                                $totalotherservices = 0;
                                                                $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$reserve_id' AND status=1") or die(mysqli_error($con));
                                                                if (mysqli_num_rows($getotherservices) > 0) {
                                                                    while ($row3 = mysqli_fetch_array($getotherservices)) {
                                                                        print_r($reserve_id);
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
                                                                    }
                                                                }else{
                                                                    $totalotherservices = 0;
                                                                    $otherservice = 0;
                                                                }
                                                                ?>
                                                                </td>
                                                                <td><?php echo $adults + $kids; ?></td>
                                                                <td><?php echo $origin; ?></td>
                                                                <td><?php echo $business; ?></td>
                                                                <td><?php echo date('d/m/Y', $checkin); ?></td>
                                                                <td><?php echo date('d/m/Y', $checkout); ?></td>
                                                                <td><?php echo number_format($totalcharge); ?></td>
                                                                <td><?php echo $otherservice ? $otherservice : 0;?></td>
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
                                                            <th><?php echo number_format($totalotherservices);?></th>
                                                            <th><?php 
                                                            $overall_total +=($totaladvance + $totalotherservices);
                                                            echo number_format($totaladvance); ?></th>
                                                            <th></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                            <?php } else { ?>
                                                <div class="alert  alert-danger">Oops!! No Reservations Added Yet</div>
                                            <?php } ?>
                                            <h2 class="text-center">BAR & RESTAURANT REPORT</h2>
                                            <?php
                                    if ($start > $end) {
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

                                                    $cat='all';
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

                                                            $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND timestamp>='$start' AND timestamp<='$end' ");
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
                                                    <th><?php
                                                    $overall_total += $totalnet;
                                                    echo number_format($totalnet); ?></th>
                                                </tr>

                                            </table>
                                        </div><!-- /table-responsive -->
                                    <?php
                                    }

                                    ?>
                                     <?php
                           if ($start > $end) {
                              $errors[] = 'Start Date Cant be later than End Date';
                           }
                           if (!empty($errors)) {
                              foreach ($errors as $error) {
                           ?>
                                 <div class="alert alert-danger"><?php echo $error; ?></div>
                              <?php
                              }
                           } else {  ?>
                              <h2 class="text-center">LAUNDRY REPORT</h2>
                              <div class="table-responsive m-t">
                                 <?php
                                 $totalcosts = 0;
                                 $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status IN (1,0) AND timestamp>='$start' AND timestamp<='$end'");
                                 if (mysqli_num_rows($laundry) > 0) {
                                 ?>
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th>Items</th>
                                             <th>Quantity</th>
                                             <th>Price</th>
                                             <!-- <th>HTVA</th> -->
                                             <th>VAT</th>
                                             <th>Total Price</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          while ($row =  mysqli_fetch_array($laundry)) {
                                             $vat = 18;
                                             $laundry_id = $row['laundry_id'];
                                             $reserve_id = $row['reserve_id'];
                                             $clothes = $row['clothes'];
                                             $package_id = $row['package_id'];
                                             $charge = $row['charge'];
                                             $customername = $row['customername'];
                                             $phone = $row['phone'];
                                             $timestamp = $row['timestamp'];
                                             $status = $row['status'];
                                             $creator = $row['creator'];
                                             $getyear = date('Y', $timestamp);
                                             $count = 1;
                                             $beforeorders =  mysqli_query($con, "SELECT * FROM laundry WHERE status IN (0,1) AND  laundry_id<'$laundry_id'") or die(mysqli_error($con));
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
                                             $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                             if (mysqli_num_rows($reservation) > 0) {

                                                $row2 =  mysqli_fetch_array($reservation);
                                                $firstname = $row2['firstname'];
                                                $lastname = $row2['lastname'];
                                                $room_id = $row2['room'];
                                                $phone = $row2['phone'];
                                                $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                $row1 =  mysqli_fetch_array($roomtypes);
                                                $roomnumber = $row1['roomnumber'];
                                                $customername = $firstname . ' ' . $lastname . ' (' . $roomnumber . ')';
                                             }
                                             $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                                             $row3 = mysqli_fetch_array($getpackage);
                                             $laundrypackage = $row3['laundrypackage'];

                                             $totalcharge = $charge * $clothes;

                                             $vatamount = (($totalcharge * $vat) / 100);

                                             $htva = $totalcharge - $vatamount;
                                             $net = $htva + $vatamount;

                                             $totalcosts += $totalcharge;
                                          ?>
                                             <tr>
                                                <!-- <td><?php echo $invoice_no; ?></td> -->
                                                <!-- <td><?php echo $customername; ?></td> -->
                                                <!-- <td><?php echo ($reserve_id > 0) ? 'Yes' : 'No'; ?> </td> -->
                                                <td><?php echo $laundrypackage; ?> </td>
                                                <td><?php echo $clothes; ?> </td>
                                                <td><?php echo number_format($charge); ?></td>
                                                <!-- <td>
                                                   <?php
                                                   $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                   $row = mysqli_fetch_array($employee);
                                                   $employee_id = $row['employee_id'];
                                                   $fullname = $row['fullname'];
                                                   echo $fullname;  ?>
                                                </td> -->
                                                <!-- <td><?php echo number_format($htva); ?></td> -->
                                                <td><?php echo number_format($vatamount); ?></td>
                                                <td><?php echo number_format($totalcharge); ?></td>
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
                                       $overall_total += $totalcosts;
                                       echo number_format($totalcosts); ?> TSHS</strong></td>
                                    </tr>
                                 </tbody>
                              </table>
                              <?php } else{?>
                                 <div class="alert  alert-danger">Oops!! No Laundry Added Yet</div>
                                            <?php } ?>
                           <?php
                           }

                           ?>
                            <?php
                           if ($start > $end) {
                              $errors[] = 'Start Date Cant be later than End Date';
                           }
                           if (!empty($errors)) {
                              foreach ($errors as $error) {
                           ?>
                                 <div class="alert alert-danger"><?php echo $error; ?></div>
                              <?php
                              }
                           } else {  ?>
                              <h2 class="text-center">GYM AND POOL REPORT</h2>
                              <div class="table-responsive m-t">
                                 <?php
                                 $totalcosts = 0;
                                 $total = 0;
                                 $totalred = 0;
                                 $totalvat = 0;
                                 $totalhtva = 0;
                                 $subscriptions = mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status='1'  AND timestamp>='$start' AND timestamp<='$end'");
                                 if (mysqli_num_rows($subscriptions) > 0) {
                                 ?>
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th>ID</th>
                                             <th>Client</th>
                                             <th>Start Date</th>
                                             <th>End Date</th>
                                             <th>Created By</th>
                                             <th>Package</th>
                                             <th>Reduction</th>
                                             <th>Charge</th>
                                             <!-- <th>HTVA</th> -->
                                             <th>VAT</th>
                                             <th>NET</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          $vat = 10;
                                          while ($row =  mysqli_fetch_array($subscriptions)) {
                                             $poolsubscription_id = $row['poolsubscription_id'];
                                             $fullname = $row['firstname'] . " " . $row["lastname"];
                                             $startdate = $row['startdate'];
                                             $enddate = $row['enddate'];
                                             $charge = $row['charge'];
                                             $creator = $row['creator'];
                                             $package = $row['package'];
                                             $reduction = empty($row['reduction']) ? 0 : $row['reduction'];
                                             $getpackage = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
                                             $row1 = mysqli_fetch_array($getpackage);
                                             $gymbouquet_id = $row1['poolpackage_id'];
                                             $package = $row1['poolpackage'];
                                             $days = $row1['days'] - 1;
                                             $enddate = strtotime("+{$days} days", $startdate);

                                             if (strlen($poolsubscription_id) == 1) {
                                                $pin = '000' . $poolsubscription_id;
                                             }
                                             if (strlen($poolsubscription_id) == 2) {
                                                $pin = '00' . $poolsubscription_id;
                                             }
                                             if (strlen($poolsubscription_id) == 3) {
                                                $pin = '0' . $poolsubscription_id;
                                             }
                                             if (strlen($poolsubscription_id) >= 4) {
                                                $pin = $poolsubscription_id;
                                             }

                                             $total += $charge;
                                             $totalred += $reduction;

                                             $vatamount = ((($charge - $reduction) * $vat) / 110);

                                             $htva = $charge - $vatamount - $reduction;
                                             $net = $htva + $vatamount;

                                             $totalvat += $vatamount;
                                             $totalhtva += $htva;
                                             $totalcosts += $net;
                                          ?>
                                             <tr>
                                                <td><?php echo $pin; ?></td>
                                                <td><?php echo $fullname; ?></td>
                                                <td><?php echo date('d/m/Y', $startdate); ?></td>
                                                <td><?php echo date('d/m/Y', $enddate); ?></td>
                                                <td>
                                                   <?php
                                                   $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                   $row = mysqli_fetch_array($employee);
                                                   $employee_id = $row['employee_id'];
                                                   $fullname = $row['fullname'];
                                                   echo $fullname;  ?>
                                                </td>
                                                <td><?php echo $package; ?></td>
                                                <td><?php echo $reduction; ?></td>
                                                <td><?php echo $charge; ?></td>
                                                <!-- <td><?php echo number_format($htva); ?></td> -->
                                                <td><?php echo number_format($vatamount); ?></td>
                                                <td><?php echo number_format($net); ?></td>
                                             </tr>
                                          <?php } ?>
                                             <tr>
                                                <th colspan="2">TOTAL</th>
                                             
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo number_format($totalred); ?></th>
                                                <th><?php echo number_format($total); ?></th>
                                                <!-- <th><?php echo number_format($totalhtva); ?></th> -->
                                                <th><?php echo number_format($totalvat); ?></th>
                                                <th><?php 
                                                $overall_total+= $totalcosts;
                                                echo number_format($totalcosts); ?></th>
                                             </tr>
                                       </tbody>

                                    </table>
                                 <?php } else { ?>
                                    <div class="alert alert-danger">
                                       <strong>Sorry!</strong> No Records Found.
                                    </div>
                                 <?php } ?>
                              </div><!-- /table-responsive -->

                              <table class="table invoice-total">
                                 <tbody>
                                    <tr>
                                       <td><strong>GRAND TOTAL SALES :</strong></td>
                                       <td><strong><?php echo number_format($overall_total);  ?> TSHS</strong></td>
                                    </tr>
                                    <!-- <tr>
                                       <td><strong>REDUCTION :</strong></td>
                                       <td><strong><?php echo number_format($totalred); ?></strong></td>
                                    </tr>
                                    <tr>
                                       <td><strong>TOTAL VAT :</strong></td>
                                       <td><strong><?php echo number_format($totalvat); ?></strong></td>
                                    </tr>
                                    <tr>
                                       <td><strong>NET TOTAL :</strong></td>
                                       <td><strong><?php echo number_format($totalcosts); ?></strong></td>
                                    </tr> -->
                                 </tbody>
                              </table>

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