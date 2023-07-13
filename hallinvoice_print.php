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

    <title>Hall Reservation Invoice Print</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/hallinvoice_print.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <?php
                $count = 1;
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
                $vat = floatval($row['vat'] ?? 0);
                $description = $row['description'];
                $people = $row['people'];
                $country = $row['country'];
                $creator = $row['creator'];
                $timestamp = $row['timestamp'];
                $getyear = date('Y', $timestamp);
                $vat = 10;
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
                $vatamount = ($days * $charge * $vat) / 100;
                ?>
                <div class="row" style="display: flex;">
                    <div class="col-xs-3">
                        <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive">
                    </div>
                    <div class="col-sm-9 pull-right" style="flex: 1">
                        <h2 class="text-center mb-4"><strong>KING’S CONFERENCE CENTRE</strong></h2>
                        <div class="d-flex" style="justify-content: space-between;">
                            <span>NIF: 4000058109</span>
                            <span>Centre fiscal: DGC</span>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;">
                            <span>R.C:82336</span>
                            <span>Secteur d’activités: Hôtellerie</span>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;">
                            <span>BP: 5970 kinindo</span>
                            <span>Forme juridique: SURL</span>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;">
                            <span>Tel: +257 61 15 55 55</span>
                            <span>Assujetti à la TVA: Oui</span>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;">
                            <span>Commune Muha, Zone Kinindo</span>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;">
                            <span>Av: Av, du large, Ndamukiza-kinindo</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-6">
                        <address>
                            <strong>
                                Le client <br>
                                Nom et prénom ou Raison Social:
                            </strong>
                            <?php echo $fullname; ?><br>
                            <strong>Phone:</strong> <?php echo $phone; ?><br />
                            <strong>Country: </strong><?php echo $country; ?><br />
                            <span><strong>NIF:</strong></span><br>
                            <span><strong>Salle:</strong> <?php echo $room; ?></span><br>
                            <span><strong>Assujetti à la TVA:</strong> Oui Non</span><br>
                            <span><strong>Doit pour ce qui suit:</strong></span><br>
                            <span><strong>Invoice Date : </strong> <?php echo date('d/m/Y', $timenow); ?></span><br />
                        </address>

                    </div>

                    <div class="col-sm-6 text-right">

                        <strong>Checkin : </strong><?php echo date('d/m/Y', $checkin); ?><br>
                        <strong>Checkout : </strong><?php echo date('d/m/Y', $checkout); ?><br>
                        <strong>People:</strong> <?php echo $people; ?><br />

                    </div>



                </div>
                <h2 style="text-align:center;width: 100%;margin: auto;font-weight: bold">HALL RESERVATION INVOICE</h2>
                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th>Item Type</th>
                                <th>Type Name</th>
                                <th>Days</th>
                                <th>Unit Charge</th>
                                <th>VAT</th>
                                <th>Sub Total</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Room</strong> </td>
                                <td><?php echo $room;  ?></td>
                                <td><?php echo $days; ?></td>
                                <td><?php echo number_format($charge); ?></td>
                                <td><?php echo $vatamount; ?></td>
                                <td><?php
                                    $roomtotal = ($charge * $days) + $vatamount;
                                    echo number_format($roomtotal); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                $buffettotal = 0;
                $buffets = mysqli_query($con, "SELECT * FROM reservationbuffets WHERE hallbooking_id='$id'") or die(mysqli_error($con));
                // $buffets = mysqli_query($con, "SELECT * FROM $buffetstable WHERE hallbooking_id='$id'") or die(mysqli_error($con));
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
                                    $qty = $row1['quantity'];
                                    $days = $row1['days'];
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

                                    $buffetcharge = $days * $qty * $price;
                                    $vatamount = (($price * $vat) / 100) * $days * $qty;
                                    $buffetcharge += $vatamount;
                                ?>
                                    <td><?php echo $buffetname;  ?></td>
                                    <td><?php echo $qty;  ?></td>
                                    <td><?php echo $days;  ?></td>
                                    <td>
                                        <?php if (!empty($price)) {
                                            echo number_format($price);
                                        } ?>
                                    </td>
                                    <td><?php echo number_format($vatamount); ?></td>
                                    <td><?php
                                        $buffettotal = $buffettotal + $buffetcharge;
                                        echo number_format($buffetcharge); ?></td>
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
                                    $servicecharge = $price * $days * $quantity;
                                    $vatamount = (($price * $vat) / 100) * $days * $quantity;
                                    $servicecharge += $vatamount;
                                    $totalservices = $servicecharge + $totalservices;
                                ?>
                                    <tr>
                                        <td><strong><?php echo $servicename;  ?></strong> </td>
                                        <td><?php echo $quantity;  ?></td>
                                        <td><?php echo $days;  ?></td>
                                        <td><?php echo number_format($price); ?></td>
                                        <td><?php echo number_format($vatamount); ?></td>
                                        <td><?php echo number_format($servicecharge); ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
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
                                    $scharge = $price + $vatamount;
                                    $totalservices2 += $scharge;
                                ?>
                                    <tr>
                                        <td><strong><?php echo $service;  ?></strong> </td>
                                        <td><?php echo number_format($price); ?></td>
                                        <td><?php echo number_format($vatamount); ?></td>
                                        <td><?php echo number_format($scharge); ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td><strong><?php
                                        $totalcharge = $roomtotal + $buffettotal + $totalservices + $totalservices2;
                                        echo number_format($totalcharge); ?></strong></td>
                        </tr>

                        <tr>
                            <td><strong>PAID :</strong></td>
                            <td><strong><?php
                                        $hallincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalhallincome FROM hallpayments WHERE hallbooking_id='$id'");
                                        $row =  mysqli_fetch_array($hallincome);
                                        $totalhallincome = $row['totalhallincome'];
                                        echo number_format($totalhallincome); ?></strong></td>
                        </tr>
                        <tr>
                                            <?php
            $htva = $totalcharge - $vatamount; // - $reduction;
        ?>
                                            <td><strong>HTVA :</strong></td>
                                            <td style="text-align: right;"><?php echo number_format($htva); ?></td>
                                        </tr>
                                        <tr>
                                            <?php
                                            $totalvat = (($totalcharge * $vat)/110)?>
                                            <td><strong>VAT :</strong></td>
                                            <td style="text-align: right;"><?php echo number_format($totalvat/* $vatamount */); ?></td>
                                        </tr>
                        <tr>
                            <td><strong>BALANCE :</strong></td>
                            <td><strong><?php echo number_format($totalcharge - $totalhallincome); ?></strong></td>
                        </tr>

                    </tbody>
                </table>

                <p><?php echo $description; ?></p>
                <div class="well m-t">
                    <strong style="font-style: italic">Thanks for Visiting Our Hotel <strong>
                </div>
            </div>
            <div class="big-footer">
                <div class="footer-text__block text-center">
                    <span>Av, du large, Ndamukiza-kinindo• BP: 5970 kinindo• Bujumbura-Burundi• Tel (257) 22 27 36 36 /22274114/61155555</span> <br>
                    <span>Email: info@kccburundi.org• Website: www.kccburundi.org• Compte Bancaire : 00301-0036242-01-01B­ANCOBU</span>
                </div>
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