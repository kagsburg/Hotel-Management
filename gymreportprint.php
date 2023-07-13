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

    <title>Gym and Pool Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/gymreportprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>


                </div>
                <h1 class="text-center">Gym and Pool Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h1>


                <div class="table-responsive m-t">
                    <?php
                    $totalcosts = 0;
                    $subscriptions = mysqli_query($con, "SELECT * FROM gymsubscriptions WHERE status='1'  AND timestamp>='$start' AND timestamp<='$end'");
                    if (mysqli_num_rows($subscriptions) > 0) {
                    ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>phone</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Bouquet</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row =  mysqli_fetch_array($subscriptions)) {
                                    $gymsubscription_id = $row['gymsubscription_id'];
                                    $fullname = $row['fullname'];
                                    $startdate = $row['startdate'];
                                    $enddate = $row['enddate'];
                                    $phone = $row['phone'];
                                    $charge = $row['charge'];
                                    $creator = $row['creator'];
                                    $bouquet = $row['bouquet'];
                                    $getbouquet = mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1' AND gymbouquet_id='$bouquet'");
                                    $row1 = mysqli_fetch_array($getbouquet);
                                    $gymbouquet_id = $row1['gymbouquet_id'];
                                    $gymbouquet = $row1['gymbouquet'];
                                    if (strlen($gymsubscription_id) == 1) {
                                        $pin = '000' . $gymsubscription_id;
                                    }
                                    if (strlen($gymsubscription_id) == 2) {
                                        $pin = '00' . $gymsubscription_id;
                                    }
                                    if (strlen($gymsubscription_id) == 3) {
                                        $pin = '0' . $gymsubscription_id;
                                    }
                                    if (strlen($gymsubscription_id) >= 4) {
                                        $pin = $gymsubscription_id;
                                    }
                                    $totalcosts = $charge + $totalcosts;
                                ?>
                                    <tr>
                                        <td><?php echo $pin; ?></td>
                                        <td><?php echo $fullname; ?></td>
                                        <td><?php echo $phone; ?></td>
                                        <td><?php echo date('d/m/Y', $startdate); ?></td>
                                        <td><?php echo date('d/m/Y', $enddate); ?></td>
                                        <td><?php echo $gymbouquet; ?></td>
                                        <td><?php echo $charge; ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    <?php } ?>
                </div><!-- /table-responsive -->
                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td><strong><?php echo number_format($totalcosts); ?></strong></td>
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