<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$stdate = explode('/', $_GET['start']);
$endate = explode('/', $_GET['end']);
$st = $stdate[1].'/'.$stdate[0].'/'. $stdate[2] . ' ' . $_GET['stt'];
$en = $endate[1].'/'.$endate[0].'/'. $endate[2] . ' ' . $_GET['ent'];
$start = strtotime($st);
$end = strtotime($en);

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Conference Room Report - Hotel Manager</title>
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
        include 'fr/hallreport.php';
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
                        <h2>Conference Room Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>Room Report</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <a href="hallreportprint?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Print PDF</a>&nbsp;
                                <a href="hallreportexcel?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Export to Excel</a>
                            </div>
                            <br>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Generated Conference Room Report</h5>
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
                                        <h2 class="text-center">CONFERENCE ROOM REPORT</h2>
                                        <div class="table-responsive m-t">
                                            <?php
                                            $totalcosts = 0;
                                            $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE status IN(1,2) AND checkin>='$start' AND checkin<='$end'");
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
                                                            $purpose = $row['reason'] . ' ' . $row['description'];
                                                            $description = $row['description'];
                                                            $country = $row['country'];
                                                            $charge = $row['charge'];
                                                            $creator = $row['creator'];
                                                            $vat = 18;
                                                            $getdays = (($checkout - $checkin) / (24 * 3600)) + 1;
                                                            // round up the days
                                                            $getdays = floor($getdays);
                                                            $vatamount = ($people * $charge * $vat) / 100;
                                                            $hallcost = ($charge * $people);
                                                            // round up to 2 decimal places
                                                            // $hallcost = round($hallcost, 2);
                                                            $totalcosts += $hallcost;

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $fullname; ?></td>
                                                                <td>
                                                                    <?php echo $people; ?>
                                                                </td>
                                                                <td><?php echo date('d/m/Y', $checkin) . ' to ' . date('d/m/Y', $checkout);  ?></td>
                                                                <td><?php
                                                                    echo $purpose;
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
                                        <?php } else { ?>
                                            <div class="alert alert-danger">No Reservations Found</div>
                                            <?php } ?>
                                        

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