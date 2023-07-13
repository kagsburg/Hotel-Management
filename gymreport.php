<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$st = $_GET['start'] . ' ' . $_GET['stt'];
$en = $_GET['end'] . ' ' . $_GET['ent'];
$start = strtotime($_GET['start'] . ' ' . $_GET['stt']);
$end = strtotime($_GET['end'] . ' ' . $_GET['ent']);
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gym and Pool Report - Hotel Manager</title>
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
        include 'fr/gymreport.php';
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
                        <h2>Gym and Pool Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>Gym and Pool Report</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="gymreportprint?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Print PDF</a><br /><br />
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Generated Gym and Pool Report</h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if ($start > $end) {
                                        $errors[] = 'Start Date Cant be later than End Date';
                                    }
                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                    ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php
                                        }
                                    } else {  ?>
                                        <h2 class="text-center">GYM AND POOL REPORT</h2>
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