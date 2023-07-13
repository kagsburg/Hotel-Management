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

    <title>Expense Report | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/costreportprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>


                </div>
                <h1 class="text-center">Expense Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h1>


                <div class="table-responsive m-t">
                    <?php
                    $totalcosts = 0;
                    $costs = mysqli_query($con, "SELECT * FROM costs WHERE status='1' AND date>='$start' AND date<='$end'") or die(mysqli_errno($con));
                    if (mysqli_num_rows($costs) > 0) {
                    ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Expense</th>
                                    <th>Cost</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($costs)) {
                                    $cost_id = $row['cost_id'];
                                    $cost_item = $row['cost_item'];
                                    $amount = $row['amount'];
                                    $date = $row['date'];
                                    $creator = $row['creator'];
                                    $totalcosts = $amount + $totalcosts;
                                ?>
                                    <tr>
                                        <td> <?php echo date('d/m/Y', $date); ?> </td>
                                        <td>
                                            <?php echo $cost_item; ?>

                                        </td>

                                        <td><?php echo number_format($amount); ?></td>
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
                <?php } else{ ?>
                    <div class="alert alert-warning">No expenses found</div>
                <?php } ?>
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