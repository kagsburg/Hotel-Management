<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Gym and Swimming Pool Subscription - Hotel Manager</title>
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
        include 'fr/addgymsubscription.php';
    } else {
    ?>

        <div id="wrapper">

            <?php
            include 'nav.php';
            ?>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                            <li><a href="switchlanguage?lan=en">English</a> </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Add New Gym and Pool Subscription</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="gymsubscriptions">Subscriptions</a> </li>
                            <li class="active">
                                <strong>Add Subscription</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Add New Subscription <small>All fields marked (*) shouldn't be left blank</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['bouquet'], $_POST['startdate'])) {
                                        $reserve_id = mysqli_real_escape_string($con, trim($_POST['reserve']));
                                        $fullname = mysqli_real_escape_string($con, trim($_POST['fullname']));
                                        $phone = mysqli_real_escape_string($con, trim($_POST['number']));
                                        $startdate = mysqli_real_escape_string($con,  strtotime($_POST['startdate']));
                                        $bouquet = mysqli_real_escape_string($con, trim($_POST['bouquet']));
                                        if (!isset($reserve_id) && (empty($fullname)) || (empty($phone)) || (empty($startdate)) || (empty($bouquet))) {
                                            $errors[] = 'All Fields Marked * shouldnt be blank';
                                        }
                                        $split = explode('_', $bouquet);
                                        $bouquet_id = $split[0];
                                        $days = ($split[1]) - 1;
                                        $charge = $split[2];
                                        $enddate = $startdate + (24 * 3600 * $days);
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                    ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php
                                            }
                                        } else {

                                            mysqli_query($con, "INSERT INTO gymsubscriptions(reserve_id,fullname,phone,bouquet,charge,startdate,enddate,timestamp,creator,status) VALUES('$reserve_id','$fullname','$phone','$bouquet_id','$charge','$startdate','$enddate',UNIX_TIMESTAMP(),'" . $_SESSION['emp_id'] . "','1')") or die(mysqli_error($con));
                                            ?>
                                            ><div class="alert alert-success"><i class="fa fa-check"></i>Gym Subscription Successfully Added. </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <form method="post" name='form' class="form" action="" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="linked" id="resident">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Is Customer a hotel resident?
                                                </label>
                                            </div>
                                        </div>


                                        <div class="nonresidents">
                                            <div class="form-group">
                                                <label class="control-label">* Full Name</label>
                                                <div class="">
                                                    <input type="text" name='fullname' class="form-control" placeholder="Enter Full Name" required="required">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label">* Contact Number</label>
                                                <div class="">
                                                    <input type="text" name="number" class="form-control" placeholder="Enter your contact  Number" required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group forresidents" style="display:none"><label class="control-label">*Select Resident</label>
                                            <select name="reserve" class="form-control">
                                                <option value="0" selected="selected">Select Resident</option>
                                                <?php
                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE status='1' ORDER BY firstname");
                                                while ($row =  mysqli_fetch_array($reservation)) {
                                                    $firstname1 = $row['firstname'];
                                                    $lastname1 = $row['lastname'];
                                                    $room_id = $row['room'];
                                                    $reservation_id = $row['reservation_id'];
                                                    $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                    $row1 =  mysqli_fetch_array($roomtypes);
                                                    $roomnumber = $row1['roomnumber'];

                                                ?>
                                                    <option value="<?php echo $reservation_id; ?>"><?php echo $firstname1 . ' ' . $lastname1 . ' (' . $roomnumber . ')';  ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>

                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <label class="control-label">* Select Bouquet</label>
                                            <div class="" style="">
                                                <select class="form-control" name='bouquet'>
                                                    <option value="" selected="selected">Select Bouquet</option>
                                                    <?php
                                                    $gymbouquets = mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1'");
                                                    while ($row = mysqli_fetch_array($gymbouquets)) {
                                                        $gymbouquet_id = $row['gymbouquet_id'];
                                                        $gymbouquet = $row['gymbouquet'];
                                                        $charge = $row['charge'];
                                                        $days = $row['days'];
                                                    ?>
                                                        <option value="<?php echo $gymbouquet_id . '_' . $days . '_' . $charge; ?>"><?php echo $gymbouquet; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label class="control-label">Start Date</label>
                                            <div class="">
                                                <input type="date" name='startdate' class="form-control" placeholder="Enter Date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">

                                                <button class="btn btn-primary" type="submit">Add Subscription</button>
                                            </div>
                                        </div>
                                    </form>
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
    $(document).ready(function() {

        $('#resident').click(function() {
            if ($(this).prop("checked") === true) {
                $('.forresidents').show();
                $('.nonresidents').hide();
            } else {
                $('.forresidents').hide();
                $('.nonresidents').show();
            }
        });
    });
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