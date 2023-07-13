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
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Get Income Report - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/incomereport.php';
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
                    <div class="col-lg-10">
                        <h2>Income Report between <?php echo date('d/m/Y', $start); ?> and <?php echo date('d/m/Y', $end); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="getincomereport">Generate Income Report</a> </li>
                            <li class="active">
                                <strong>Income Report</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-10">
                            <a href="incomereportprint?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Print PDF</a><br /><br />
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Generated Income Report <small>All fields marked (*) shouldn't be left blank</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if ($_GET['start'] > $_GET['end']) {
                                        $errors[] = 'Start Date Cant be later than End Date';
                                    }

                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                    ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php
                                        }
                                    } else {  ?>
                                        <h2 class="text-center">HOTEL INCOME</h2>
                                        <div class="table-responsive m-t">

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



                                    <?php
                                    }

                                    ?>


                                </div>
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
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
</script>