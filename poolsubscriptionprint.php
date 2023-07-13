<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym & Pool Subscription Card | Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .invoice-table td {
            padding: 6px !important;
        }
    </style>
    <style type="text/css" media="print">
        html,
        div,
        body,
        td,
        tr,
        table {
            overflow-x: hidden !important;
        }

        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0;
            /* this affects the margin in the printer settings */
            font-size: 20px;
            font-family: times new roman;
        }

        @media print {

            .invoice-table thead>tr>th:last-child,
            .invoice-table thead>tr>th:nth-child(4),
            .invoice-table thead>tr>th:nth-child(3),
            .invoice-table thead>tr>th:nth-child(2) {
                text-align: left;
            }

            .invoice-table tbody>tr>td:last-child,
            .invoice-table tbody>tr>td:nth-child(4),
            .invoice-table tbody>tr>td:nth-child(3),
            .invoice-table tbody>tr>td:nth-child(2) {
                text-align: left;
            }

            .invoice-total>tbody>tr>td:last-child {
                width: 30%;
                text-align: left;
            }

            .invoice-table tbody>tr>td:first-child {
                width: 80px;
            }

            .invoice-table tbody>tr>td:first-child span {
                word-break: break-all;
            }
        }

        #sizer {
            width: 300px;
        }
    </style>
</head>
<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/poolsubscriptionprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl" style="padding:0px;max-width:310px;margin: 0px auto;">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-12" style="font-size:10px;font-family: times new roman">
                        <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive" width="60">
                        <div class="w-100" style="margin-top: 6px;">
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
                        <div class="col-xs-4"> </div>
                        <?php
                        $vat = 10;
                        $subscriptions = mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE poolsubscription_id='$id'");
                        $row =  mysqli_fetch_array($subscriptions);
                        $poolsubscription_id = $row['poolsubscription_id'];
                        $firstname = $row['firstname'];
                        $lastname = $row['lastname'];
                        $startdate = $row['startdate'];
                        $enddate = $row['enddate'];
                        $reduction = $row['reduction'];
                        $charge = $row['charge'];
                        $creator = $row['creator'];
                        $package = $row['package'];
                        $reserve_id = $row['reserve_id'];
                        $timestamp = $row['timestamp'];
                        $getyear = date('Y', $timestamp);
                        $customername = $firstname . ' ' . $lastname;
                        $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                        if (mysqli_num_rows($reservation) > 0) {
                            $row2 =  mysqli_fetch_array($reservation);
                            $firstname = $row2['firstname'];
                            $lastname = $row2['lastname'];
                            $room_id = $row2['room'];
                            $contact = $row2['phone'];
                            $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                            $row1 =  mysqli_fetch_array($roomtypes);
                            $roomnumber = $row1['roomnumber'];
                            $customername = $firstname . ' ' . $lastname . ' (' . $roomnumber . ')';
                        }
                        $count = 1;
                        $beforeorders =  mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status=1  AND  poolsubscription_id<'$id'") or die(mysqli_error($con));
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
                        $getpackage = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
                        $row1 = mysqli_fetch_array($getpackage);
                        $poolpackage = $row1['poolpackage'];
                        $days = $row1['days'] - 1;
                        $enddate = strtotime("+{$days} days", $startdate);
                        $reduction = empty($reduction) ? 0: $reduction;
                        $totalvat = ((($charge - $reduction) * $vat) / 110);

                        $htva = $charge - $totalvat - $reduction;
                        $net = $htva + $totalvat;
                        //$charge = $charge - $totalvat;
                        ?>
                        <div class="col-xs-12 text-right" style="padding-right: 0;">
                            <h4>Card No. <span class="text-navy"><?php echo $invoice_no; ?></span> </h4>
                            <span>To:</span>
                            <address>
                                <strong><?php echo $customername; ?></strong><br>
                                <span><strong>Creation Date:</strong> <?php echo date('d/m/Y', $timenow); ?></span><br />
                            </address>
                        </div>
                    </div>
                </div>

                <h4 style="text-align:center;width: 100%;margin: auto;font-weight: bold; font-size: 12px;">GYM & POOL SUBSCRIPTION CARD</h4>
                <div class="table-responsive m-t">
                    <table class="table invoice-table" style="font-size:10px; font-family:times new roman; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th>Package</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Charge</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div>
                                        <strong>
                                            <?php echo $poolpackage; ?>
                                        </strong>
                                    </div>
                                </td>
                                <td><?php echo date('d/m/Y', $startdate); ?></td>
                                <td><?php echo date('d/m/Y', $enddate); ?></td>
                                <td><?php echo number_format($charge); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /table-responsive -->
                <table class="table invoice-total" style="font-size: 12px;">
                    <tbody>
                        <tr>
                            <td>TOTAL :</td>
                            <td style="text-align: right;"><?php echo number_format($charge); ?></td>
                        </tr>
                        <?php
                        
                        if (!empty($reduction)) {
                        ?>
                            <tr>
                                <td>Reduction :</td>
                                <td style="text-align: right;"><?php echo number_format($reduction); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>HTVA :</td>
                            <td style="text-align: right;"><?php echo number_format($htva); ?></td>
                        </tr>
                        <tr>
                            <td>VAT :</td>
                            <td style="text-align: right;"><?php echo number_format($totalvat); ?></td>
                        </tr>
                        <tr>
                            <td><strong>NET TOTAL :</strong></td>
                            <td style="text-align: right;"><strong>
                                <?php echo number_format($net); ?>
                            </strong>
                        </td>
                        </tr>
                    </tbody>
                </table>
                <div class="well m-t">
                    <strong style="font-style: italic;font-size:12px">Thanks for Visiting our Hotel <strong>
                </div>
            </div>
            <div class="big-footer">
                <div class="footer-text__block text-center">
                    <span>Av, du large, Ndamukiza-kinindo• BP: 5970 kinindo• Bujumbura-Burundi• Tel (257) 22 27 36 36 /22274114/61155555</span> <br>
                    <span>Email: info@kccburundi.org• Website: www.kccburundi.org• Compte Bancaire : 00301-0036242-01-01B­ANCOBU</span>
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
    <script type="text/javascript">
        window.print();
    </script>


</body>

</html>