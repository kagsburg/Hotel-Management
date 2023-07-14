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
    <title>Laundry Work Invoice | Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/laundryinvoice_print.php';
    } else {
        ?>
        <div class="wrapper wrapper-content p-xl" style="padding:0px;max-width:300px;margin: 0px auto">
            <div class="col-sm-12" style="padding:0px;">
                <div class="row" style="margin-left: 0;">
                    <?php
                        $vat = 18;
                        $check=  mysqli_query ($con,"SELECT * FROM laundry WHERE laundry_id='$id'") ;
        
        $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND laundry_id='$id'");
        $totalcharge=0;
        $row =  mysqli_fetch_array($laundry);
        $laundry_id = $row['laundry_id'];
        $reserve_id = $row['reserve_id'];
        $clothes = $row['clothes'];
        $package_id = $row['package_id'];
        $timestamp = $row['timestamp'];
        $customername = $row['customername'];
        // print ($customername);
        $phone = $row['phone'];
        $status = $row['status'];
        $charge = $row['charge'];
        $creator = $row['creator'];
        $getyear = date('Y', $timestamp);
        $count = 1;
        $beforeorders =  mysqli_query($con, "SELECT * FROM laundry WHERE status=1  AND  laundry_id<'$id'") or die(mysqli_error($con));
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
            // print($row2);
            $firstname = $row2['firstname'];
            $lastname = $row2['lastname'];
            $room_id = $row2['room'];
            $phone = $row2['phone'];
            $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
            $row1 =  mysqli_fetch_array($roomtypes);
            $roomnumber = $row1['roomnumber'];
            $customername = $firstname . ' ' . $lastname;
            $getlaundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE reserve_id='$reserve_id' AND timestamp='$timestamp' AND status='1'");
            $totalcharge = 0;
            while ($row4 = mysqli_fetch_array($getlaundry2)) {
                $totalcharge += $row4['clothes'] * $row4['charge'];
            }
            // print($customername);
        }else{
            // calculate total charge for laundry for non-residents
            $getlaundry3 = mysqli_query($con, "SELECT * FROM laundry WHERE customername='$customername' AND timestamp='$timestamp' AND status='1'");
            $totalcharge = 0;
            while ($row4 = mysqli_fetch_array($getlaundry3)) {
                $totalcharge += $row4['clothes'] * $row4['charge'];
            }
            $customername = $customername;
            $phone = $phone;
        }
        $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
        $row3 = mysqli_fetch_array($getpackage);
        $laundrypackage = $row3['laundrypackage'];
        // $totalcharge += $clothes * $charge;        
        
        $totalvat = (($totalcharge * $vat) / 100);
        // $htva = $totalcharge - $totalvat;
        // $net = $totalcharge + $totalvat;
        $net = $totalcharge
        ?>
                    <div class="col-sm-12" style="font-size:10px;font-family: times new roman">
                        <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive" width="60">
                        <div class="w-100" style="margin-top: 6px;">
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
                        <h4 class="text-navy">Invoice # <?php echo $invoice_no; ?></h4>
                        <address>
                            <strong>
                                Guest Name : <?php echo $customername; ?> <br/>
                            </strong>
                            <strong>Tel :</strong> <?php echo $phone; ?><br />
                            <!-- <span><strong>NIF:</strong></span><br> -->
                            <span><strong>Room No:</strong> <?php echo $roomnumber ?? ""; ?></span><br>
                            <!-- <span><strong>Assujetti à la TVA:</strong> Oui Non</span><br>
                            <span><strong>Doit pour ce qui suit:</strong></span><br> -->
                            <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y', $timenow); ?></span><br />
                        </address>
                    </div>
                </div>
                <h2 style="text-align:center;width: 100%;margin: auto;font-weight: bold">LAUNDRY INVOICE</h2>
                <div class="table-responsive m-t">
                    <table class="table invoice-table" style="width:100%;font-size:10px;font-family:times new roman">
                        <thead>
                            <tr>
                                <th>Package</th>
                                <th>Clothes</th>
                                <th>Date</th>
                                <th>Unit Charge</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php
                            if ($reserve_id != 0) {
                                $laundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE reserve_id='$reserve_id' AND timestamp='$timestamp' AND status='1'");
                            } else {
                                $laundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE customername='$customername' AND timestamp='$timestamp' AND status='1'");
                            }
                            // $laundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND timestamp='$id'");
                              while ($row4 =  mysqli_fetch_array($laundry2)) {
                                $clothe= $row4['clothes'];
                                $time = $row4['timestamp'];
                                $charges= $row4['charge'];
                                $package = $row4['package_id'];
                                $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package'");
                                $row3 = mysqli_fetch_array($getpackage);
                                $laundrypackages = $row3['laundrypackage'];
                                ?>
                                 <tr>
                                    <td>
                                        <div><strong>
                                                <?php echo $laundrypackages; ?>
                                            </strong></div>
                                    </td>
                                    <td><?php echo $clothe;  ?></td>
                                    <td><?php echo date('d/m/Y', $time); ?></td>
                                    <td><?php echo number_format($charges); ?></td>
                                </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->
                <table class="table invoice-total">
                    <tbody>
                        <!-- <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td><strong><?php echo number_format($totalcharge); ?></strong></td>
                        </tr> -->
                        <!-- <tr>
                            <td>HTVA :</td>
                            <td style="text-align: right;"><?php echo number_format($htva); ?></td>
                        </tr> -->
                        <tr>
                            <td>VAT :</td>
                            <td style="text-align: right;"><?php echo number_format($totalvat); ?></td>
                        </tr>
                        <tr>
                            <td><strong>NET TOTAL :</strong></td>
                            <td style="text-align: right;"><strong><?php echo number_format($net); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="well m-t">
                    <strong style="font-style: italic; display: block; text-align: center;">Thanks for Visiting our Hotel <strong>
                </div>
                <div class="d-flex m-t">
                    <div class="ml-auto">
                        <p class="fs-12" style="padding-bottom: 40px;">
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