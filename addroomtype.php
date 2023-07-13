<?php
include 'includes/conn.php';

if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Type | Hotel Manager</title>
    <script src="ckeditor/ckeditor.js"></script>
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/roomtypes.php';
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
                        <h2>Room Types</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="roomtypes">Room Types</a>
                            </li>
                            <li class="active">
                                <strong>Add Room Type</strong>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <?php
                        if (($_SESSION['hotelsyslevel'] == 1)) {
                        ?>
                            <div class="col-lg-8">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">

                                        <h5>Add Room type <small>Ensure to fill all necessary fields</small></h5>

                                    </div>
                                    <div class="ibox-content">
                                        <?php

                                        if (isset($_POST['type'], $_POST['charge'])) {
                                            $type =  mysqli_real_escape_string($con, trim($_POST['type']));
                                            $charge =  mysqli_real_escape_string($con, trim($_POST['charge']));
                                            $sharecharge =  $charge; //mysqli_real_escape_string($con, trim($_POST['sharecharge']));
                                            $mealplans = []; //$_POST['mealplans'];
                                            if ((empty($type) || (empty($charge)))) {
                                                echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                            }
                                            if (is_numeric($charge) == FALSE) {
                                                echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Room Charge should be An Integer</div>';
                                            } else {

                                                mysqli_query($con, "INSERT INTO roomtypes(roomtype,charge,sharecharge,status) VALUES('$type','$charge','$sharecharge','1')") or die(mysqli_errno($con));
                                                $last_id = mysqli_insert_id($con);
                                                foreach ($mealplans as $mealplan) {
                                                    mysqli_query($con, "INSERT INTO roommealplans(mealplan_id,roomtype_id,status) VALUES('$mealplan','$last_id',1)");
                                                }
                                                echo '<div class="alert alert-success"><i class="fa fa-check"></i>Room type successfully added</div>';
                                            }
                                        }



                                        ?>
                                        <form method="post" class="form" action='' name="form">
                                            <div class="form-group"><label class="control-label">Type Name</label>
                                                <input type="text" class="form-control" name='type' placeholder="Enter Room Type" required='required'>
                                            </div>
                                            <div class="form-group"><label class="control-label">Room Charge</label>
                                                <input type="text" class="form-control" name='charge' placeholder="Enter Room Charge" required='required'>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <label class="control-label">Co-Share Room Charge</label>
                                                <input type="number" class="form-control" name='sharecharge' placeholder="Enter Co-share Room Charge">
                                            </div>

                                            <div class="form-group"><label class="control-label">Meal Plans </label>
                                                <select data-placeholder="Choose mealplans..." name="mealplans[]" class="chosen-select" style="width:100%;" tabindex="2" multiple>
                                                    <?php
                                                    $getplans =  mysqli_query($con, "SELECT * FROM mealplans WHERE status=1");
                                                    while ($row = mysqli_fetch_array($getplans)) {
                                                        $mealplan_id = $row['mealplan_id'];
                                                        $mealplan = $row['mealplan'];
                                                    ?>
                                                        <option value="<?php echo $mealplan_id; ?>"><?php echo $mealplan; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <button class="btn btn-primary" name="submit" type="submit">Add Room type</button>

                                            </div>
                                        </form>


                                    </div>


                                </div>

                            </div>
                        <?php } ?>





                    </div>
                <?php } ?>
                <!-- Mainly scripts -->
                <script src="js/jquery-1.10.2.js"></script>
                <script src="js/bootstrap.min.js"></script>

                <!-- Custom and plugin javascript -->
                <script src="js/inspinia.js"></script>
                <script src="js/plugins/pace/pace.min.js"></script>

                <!-- Chosen -->
                <script src="js/plugins/chosen/chosen.jquery.js"></script>

                <!-- Input Mask-->
                <!--<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>-->

                <!-- Data picker -->
                <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>


                <!-- iCheck -->
                <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

                <!-- MENU -->
                <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

                <script>
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
                </script>

</body>


</html>