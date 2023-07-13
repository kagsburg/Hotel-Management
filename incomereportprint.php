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

    <title>Income Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <div class="wrapper wrapper-content p-xl">
        <div class="ibox-content p-xl">
            <div class="row">
                <div class="col-sm-2"><img src="assets/demo/usingilologo.png" class="img img-responsive"></div>
                <div class="col-sm-4">
                    <address>
                        <h3></h3>
                        <strong>USUNGILO CITY HOTEL</strong><br>
                        P.O Box 3060<br>
                        Mbeya, Tanzania<br>
                        <strong>Manager : </strong>+255 684 356 814<br />
                        <strong>Reception : </strong>+255 765 753 332<br />
                        Email: info@usungirocityhotel.co.tz<br />
                        Website:usungirocityhotel.co.tz<br />

                    </address>

                </div>



            </div>
            <h1 class="text-center">Income Report between <?php echo date('d/m/Y', $start); ?> and <?php echo date('d/m/Y', $end); ?></h1>

            <table class="table invoice-table">
                <thead>
                    <tr>
                        <th>Item</th>

                        <th>Revenue</th>

                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td> Income from Bar (from guests not reserved)</td>
                        <td>
                            <?php
                            $barincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalbarincome FROM barpayments WHERE timestamp>='$start' AND timestamp<='$end'");
                            $row =  mysqli_fetch_array($barincome);
                            $totalbarincome = $row['totalbarincome'];
                            echo number_format($totalbarincome);
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td> Income from Restaurant (from guests not reserved)</td>
                        <td>
                            <?php
                            $restincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalrestincome FROM restpayments WHERE timestamp>='$start' AND timestamp<='$end'");
                            $row =  mysqli_fetch_array($restincome);
                            $totalrestincome = $row['totalrestincome'];
                            echo number_format($totalrestincome);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Income from Guests Checking out </td>
                        <td>
                            <?php
                            $totalpaid = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalpaid FROM checkoutpayments WHERE timestamp>='$start' AND timestamp<='$end'");
                            $row =  mysqli_fetch_array($totalpaid);
                            $paidtotal = $row['totalpaid'];
                            echo number_format($paidtotal);
                            ?>
                        </td>
                    </tr>
                    <td> Income from Hall Reservations (from guests not reserved)</td>
                    <td>
                        <?php
                        $thallincome = 0;
                        $checkreserved =  mysqli_query($con, "SELECT * FROM hallreservations WHERE guest='0' AND status!='0'");
                        while ($row =  mysqli_fetch_array($checkreserved)) {
                            $hallreservation_id = $row['hallreservation_id'];
                            $hallincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalhallincome FROM hallpayments WHERE hallbooking_id='$hallreservation_id' AND timestamp>='$start' AND timestamp<='$end'");
                            $row =  mysqli_fetch_array($hallincome);
                            $totalhallincome = $row['totalhallincome'];
                            $thallincome = $thallincome + $totalhallincome;
                        }
                        echo number_format($thallincome);
                        ?>

                    </td>
                    </tr>
                </tbody>
            </table>

        </div><!-- /table-responsive -->

        <table class="table invoice-total">
            <tbody>
                <tr>
                    <td><strong>TOTAL :</strong></td>
                    <td><strong>
                            <?php
                            $totalincome = $paidtotal + $totalrestincome + $totalbarincome + $thallincome;
                            echo number_format($totalincome);
                            ?>
                        </strong></td>
                </tr>
            </tbody>
        </table>

    </div>

    </div>

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