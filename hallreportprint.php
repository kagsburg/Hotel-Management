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

    <title>Conference Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/hallreportprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                </div>
                <h1 class="text-center">Conference Room Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h1>


                <div class="table-responsive m-t">
                    <?php
                    $totalcosts = 0;
                    $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE status IN(1,2) AND timestamp>='$start' AND timestamp<='$end'");
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
                                    $purpose = $row['purpose'] ?? "";
                                    $description = $row['description'];
                                    $country = $row['country'];
                                    $charge = $row['charge'];
                                    $creator = $row['creator'];
                                    $vat = 10;
                                    $getdays = (($checkout - $checkin) / (24 * 3600)) + 1;
                                    $vatamount = ($getdays * $charge * $vat) / 100;
                                    $hallcost = ($charge * $getdays) + $vatamount;
                                    $totalcosts += $hallcost;
                                ?>
                                    <tr>
                                        <td><?php echo $fullname; ?></td>
                                        <td><?php echo $people; ?></td>
                                        <td><?php echo date('d/m/Y', $checkin) . ' to ' . date('d/m/Y', $checkout);; ?></td>
                                        <td>
                                            <?php
                                            if (!empty($purpose)) {
                                                $purposes = mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
                                                $row3 = mysqli_fetch_array($purposes);
                                                $hallpurpose_id = $row3['hallpurpose_id'];
                                                $hallpurpose = $row3['hallpurpose'];
                                                echo $hallpurpose;
                                            }
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
            <?php
                    }

            ?>
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