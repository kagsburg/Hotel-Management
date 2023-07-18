<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = $_GET['start'];
$en = $_GET['end'];
$start = strtotime($_GET['start']);
$end = strtotime($_GET['end']);
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

    <title>Pool Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if (false && (isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/poolreportprint.php';
    } else {
        ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>


                </div>
                <h1 class="text-center">Gym and Pool Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h1>


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
                                <th>Contact</th>
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
                $contact = $row['phone'];
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
                                   <td><?php echo $contact; ?></td>
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
                                   <th><?php echo number_format($totalcosts); ?></th>
                                </tr>
                          </tbody>

                       </table>
                    <?php } ?>
                </div><!-- /table-responsive -->
                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td><strong><?php echo number_format($total); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>REDUCTION :</strong></td>
                            <td><strong><?php echo number_format($totalred); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>NET TOTAL :</strong></td>
                            <td><strong><?php echo number_format($totalcosts); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
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