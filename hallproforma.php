<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$id = $_GET['id'];
$delivery = mysqli_query($con, "SELECT * FROM halldelivery WHERE hallreservation_id='$id'");
if (mysqli_num_rows($delivery) === 0) {
    $reservetable = "hallreservations";
    $buffetstable = "reservationbuffets";
    $servicestable = "hallservices";
    $services2table = "hallservices2";
} else {
    $reservetable = "halldelivery";
    $buffetstable = "halldelivery_buffets";
    $servicestable = "halldelivery_services";
    $services2table = "halldelivery_services2";
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hall Reservation Proforma | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/hallproforma.php';
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
                        <h2>PROFORMA</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a href="index">Home</a>
                            </li>
                            <li>
                                <a href="halldetails?id=<?php echo $id; ?>">
                                    Hall Reservation
                                </a>
                            </li>
                            <li class="active">
                                <strong>Proforma</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-4">
                        <div class="title-action">
                            <!--                        <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>-->
                            <a href="hallproforma_print?id=<?php echo $id; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>Print Proforma </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wrapper wrapper-content animated fadeInRight">
                            <div class="ibox-content p-xl">
                                <?php
                                $count = 1;
                                $totalvat = 0;
                                $vat = 18;
                                $reservation = mysqli_query($con, "SELECT * FROM $reservetable WHERE  hallreservation_id='$id'");
                                $row =  mysqli_fetch_array($reservation);
                                $hallreservation_id = $row['hallreservation_id'];
                                $fullname = $row['fullname'];
                                $checkin = $row['checkin'];
                                $phone = $row['phone'];
                                $checkout = $row['checkout'];
                                $status = $row['status'];
                                $room_id = $row['room_id'];
                                $charge = $row['charge'];
                                // $vat = $row['vat'];
                                $description = $row['description'];
                                $people = $row['people'];
                                $country = $row['country'];
                                $creator = $row['creator'];
                                $timestamp = $row['timestamp'];
                                $getyear = date('Y', $timestamp);
                                $beforeorders =  mysqli_query($con, "SELECT * FROM hallreservations WHERE status=1  AND hallreservation_id<'$id'") or die(mysqli_error($con));
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
                                $days = ($checkout - $checkin) / (3600 * 24) + 1;
                                $days = number_format($days, 0);
                                $purposes = mysqli_query($con, "SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id'");
                                $rowc = mysqli_fetch_array($purposes);
                                $room = $rowc['room'];
                                $price = $people * $charge;
                                $vatamount = (($price * 18 ) / 100);
                                // $charge = $price;
                                $totalvat += $vatamount;
                                ?>
                                <div class="row" style="display: flex;">
                                    <div class="col-xs-3">
                                        <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive" width="140">
                                    </div>
                                    <div class="col-sm-9 pull-right" style="flex: 1">
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
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-xs-6">
                                        <address>
                                            <strong>
                                                Guest Customer <br>
                                                
                                            </strong>
                                            <?php echo $fullname; ?><br>
                                            <strong>Phone:</strong> <?php echo $phone; ?><br />
                                            <strong>Country: </strong><?php echo $country; ?><br />
                                            <!-- <span><strong>NIF:</strong></span><br> -->
                                            <span><strong>Conference:</strong> <?php echo $room; ?></span><br>
                                            <!-- <span><strong>Assujetti à la TVA:</strong> Oui Non</span><br>
                                            <span><strong>Doit pour ce qui suit:</strong></span><br> -->
                                            <span><strong>Invoice Date : </strong> <?php echo date('d/m/Y', $timenow); ?></span><br />
                                        </address>

                                    </div>

                                    <div class="col-sm-6 text-right">
                                        <h4 class="text-navy"># <?php echo str_pad($hallreservation_id, 6, "0", STR_PAD_LEFT); ?></h4>
                                        <strong>Checkin : </strong><?php echo date('d/m/Y', $checkin); ?><br>
                                        <strong>Checkout : </strong><?php echo date('d/m/Y', $checkout); ?><br>
                                        <strong>People:</strong> <?php echo $people; ?><br />

                                    </div>

                                </div>
                                <h2 style="text-align:center;width: 100%;margin: auto;font-weight: bold">HALL RESERVATION PROFORMA</h2>
                                <div class="table-responsive m-t">
                                    <table class="table invoice-table">
                                        <thead>
                                            <tr>
                                                <th>Item Type</th>
                                                <th>Type Name</th>
                                                <th>Number of People</th>
                                                <th>Unit Charge</th>
                                                <th>VAT</th>
                                                <th>Sub Total</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Room</strong> </td>
                                                <td><?php echo $room;  ?></td>
                                                <td><?php echo $people; ?></td>
                                                <td><?php echo number_format($charge); ?></td>
                                                <td><?php echo number_format($vatamount); ?></td>
                                                <td><?php
                                                    $roomtotal = ($charge * $people);
                                                    echo number_format($roomtotal); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                                $buffettotal = 0;
                                $buffets = mysqli_query($con, "SELECT * FROM $buffetstable WHERE hallbooking_id='$id'") or die(mysqli_error($con));
                                if (mysqli_num_rows($buffets) > 0) {
                                ?>
                                    <h3 style="text-align:center;width: 100%;margin: auto;font-weight: bold">HALL BUFFETS</h3>
                                    <div class="table-responsive m-t">
                                        <table class="table invoice-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Qty</th>
                                                    <th>Days</th>
                                                    <th>Unit Charge</th>
                                                    <th>VAT</th>
                                                    <th>Sub Total</th>

                                                </tr>
                                            </thead>
                                            <tr>
                                                <?php
                                                while ($row1 = mysqli_fetch_array($buffets)) {
                                                    $hallbuffet_id = $row1['hallbuffet_id'];
                                                    $price = $row1['price'];
                                                    $otheritems = $row1['otheritems'];
                                                    $days = $row1['days'];
                                                    $qty = $row1['quantity'];
                                                    $getbuffet = mysqli_query($con, "SELECT * FROM hallbuffets WHERE hallbuffet_id='$hallbuffet_id'");
                                                    $row2 = mysqli_fetch_array($getbuffet);
                                                    $buffetname = $row2['buffet'];
                                                    $split = !empty($otheritems) ? explode(',', $otheritems) : [];
                                                    $itemsarray = array();
                                                    foreach ($split as $item_id) {
                                                        $fooditems = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$item_id'");
                                                        $row2 =  mysqli_fetch_array($fooditems);
                                                        $menuitem = $row2['menuitem'];
                                                        array_push($itemsarray, $menuitem);
                                                    }
                                                    $itemslist = implode(', ', $itemsarray);
                                                    $vatamount = (($price * $vat) / 100) * $days * $qty;
                                                    $totalvat += $vatamount;
                                                    // $price = $price - (($price * $vat) / 100);
                                                ?>
                                                    <td>
                                                        <?php echo $buffetname;  ?>                                                        
                                                    </td>
                                                    <td><?php echo $qty;  ?></td>
                                                    <!-- <td><?php //echo $days * $people;  
                                                                ?></td> -->
                                                    <td><?php echo $days;  ?></td>
                                                    <td><?php if (!empty($price)) {
                                                            echo number_format($price);
                                                        } ?>
                                                        </td>
                                                        <td><?php echo number_format($vatamount); ?></td>
                                                    <td><?php
                                                        $buffetcharge = $days * $qty * $price;
                                                        $buffettotal = $buffettotal + $buffetcharge;                                                        
                                                        echo number_format($buffettotal); ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        </table>
                                    </div><!-- /table-responsive -->

                                <?php
                                }
                                $totalservices = 0;
                                $getservices = mysqli_query($con, "SELECT * FROM $servicestable WHERE hallreservation_id='$id'");
                                if (mysqli_num_rows($getservices) > 0) {
                                ?>
                                    <h3 style="text-align:center;width: 100%;margin: auto;font-weight: bold">OTHER SERVICES</h3>
                                    <div class="table-responsive m-t">
                                        <table class="table invoice-table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <th>Qty</th>
                                                    <th>Days</th>
                                                    <th>Unit Charge</th>
                                                    <th>VAT</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = mysqli_fetch_array($getservices)) {
                                                    $service = $row['service'];
                                                    $quantity = $row['quantity'];
                                                    $price = $row['price'];
                                                    $days = $row['days'];
                                                    $getservice = mysqli_query($con, "SELECT * FROM conferenceotherservices WHERE  conferenceotherservice_id='$service'");
                                                    $roww = mysqli_fetch_array($getservice);
                                                    $servicename = stripslashes($roww['service']);
                                                    $vatamount = (($price * $vat) / 100) * $days * $quantity;
                                                    $totalvat += $vatamount;
                                                    // $price = $price - (($price * $vat) / 100);

                                                    $servicecharge = $price * $days * $quantity;
                                                    $totalservices = $servicecharge + $totalservices;

                                                ?>
                                                    <tr>
                                                        <td><strong><?php echo $servicename;  ?></strong> </td>
                                                        <td><?php echo $quantity;  ?></td>
                                                        <td><?php echo $days;  ?></td>
                                                        <td><?php echo number_format($price); ?></td>
                                                        <td><?php echo number_format($vatamount); ?></td>
                                                        <td><?php echo number_format($servicecharge ); ?></td>
                                                    </tr>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php }
                                $totalservices2 = 0;
                                $getservices2 = mysqli_query($con, "SELECT * FROM $services2table WHERE hallreservation_id='$id'");
                                if (mysqli_num_rows($getservices2) > 0) {
                                ?>
                                    <h3 style="text-align:center;width: 100%;margin: auto;font-weight: bold">OTHER SERVICES 2</h3>
                                    <div class="table-responsive m-t">
                                        <table class="table invoice-table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <th>Charge</th>
                                                    <th>VAT</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = mysqli_fetch_array($getservices2)) {
                                                    $service = $row['service'];
                                                    $price = $row['price'];
                                                    $vatamount = (($price * $vat) / 100);
                                                    $totalvat += $vatamount;
                                                    // $price = $price - (($price * $vat) / 100);

                                                    $totalservices2 += $price;
                                                ?>
                                                    <tr>
                                                        <td><strong><?php echo $service;  ?></strong> </td>
                                                        <td><?php echo number_format($price); ?></td>
                                                        <td><?php echo number_format($vatamount); ?></td>
                                                        <td><?php echo number_format($price); ?></td>
                                                    </tr>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                <?php } ?>
                                <table class="table invoice-total">
                                    <tbody>
                                        <tr>
                                            <td>TOTAL :</td>
                                            <td>

                                                <?php
                                                $totalcharge = $roomtotal + $buffettotal + $totalservices + $totalservices2;
                                                echo number_format($totalcharge); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>VAT:</td>
                                            <td>

                                                <?php
                                                $totalcharge = $totalvat;
                                                echo number_format($totalvat); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>VAT INCLUDED TOTAL :</strong></td>
                                            <td>
                                                <strong>
                                                    <?php
                                                    $totalcharge = $roomtotal + $buffettotal + $totalservices + $totalservices2;
                                                    echo number_format($totalcharge + $totalvat); ?>
                                                </strong>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <p><?php echo $description; ?></p>
                                <div class="well m-t">
                                    <strong style="font-style: italic">Thanks for Visiting Our Hotel <strong>
                                </div>

                                <?php
                                $name =  mysqli_query($con, "SELECT * FROM users WHERE user_id='" . $_SESSION['hotelsys'] . "'");
                                $row =  mysqli_fetch_array($name);
                                $employee = $row['employee'];
                                $getemployee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee'");
                                $roww = mysqli_fetch_array($getemployee);
                                $fullname = $roww['fullname'];
                                ?>
                                <table class="table invoice-total">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom: 50px;"><strong>Created by <?php echo $fullname; ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
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