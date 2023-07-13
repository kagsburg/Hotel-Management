<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
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

    <title>Hotel Costs</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/costsprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>



                </div>
                <h1 class="text-center">All Hotel costs</h1>
                <div class="table-responsive m-t">

                    <table class="table table-bordered invoice-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Cost</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalcosts = 0;
                            $costs = mysqli_query($con, "SELECT * FROM costs WHERE status='1'") or die(mysqli_errno($con));
                            while ($row = mysqli_fetch_array($costs)) {
                                $cost_id = $row['cost_id'];
                                $cost_item = $row['cost_item'];
                                $amount = $row['amount'];
                                $description = $row['description'];
                                $date = $row['date'];
                                $creator = $row['creator'];
                                $totalcosts = $totalcosts + $amount;
                            ?>
                                <tr class="gradeA">
                                    <td><?php echo date('d/m/Y', $date); ?> </td>
                                    <td><?php echo $cost_item; ?></td>
                                    <td><?php echo $description; ?></td>
                                    <td><?php echo $amount; ?> </td>

                                </tr> <?php } ?>
                                <tr>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <td><strong><?php echo $totalcosts; ?></strong></td>
                                </tr>
                        </tbody>
                        <tfoot>
                            <tr></tr>
                        </tfoot>
                    </table>
                </div><!-- /table-responsive -->



                <div class="well m-t">
                    <strong style="font-style: italic">@<?php echo date('Y', $timenow); ?> All Rights Reserved To Kings Conference</strong>
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

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>