<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}

$getsettings = mysqli_query($con, "SELECT * FROM settings");
$row = mysqli_fetch_array($getsettings);
$annual_leave = $row['annual_leave'];

$first = strtotime('1 January');
$last = strtotime('1 January next year');

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Leave - Hotel Manager</title>
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
        include 'fr/addleave.php';
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
                        <h2>Add Leave</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="pendingleaves">Pending Leaves</a> </li>
                            <li class="active">
                                <strong>Add Leave</strong>
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
                                    <h5>Add New Leave<small>All fields marked (*) shouldn't be left blank</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['employee'], $_POST['enddate'], $_POST['startdate'])) {
                                        $employee = $_POST['employee'];
                                        $leave_type = mysqli_real_escape_string($con, $_POST['leave_type']);
                                        $st_date = mysqli_real_escape_string($con, $_POST['startdate']);
                                        $en_date = mysqli_real_escape_string($con, $_POST['enddate']);
                                        $startdate = strtotime($st_date);
                                        $enddate = strtotime($en_date);
                                        if ((empty($employee)) || empty($leave_type) || (empty($startdate)) || (empty($enddate))) {
                                            $errors[] = 'All Fields Marked * shouldnt be blank';
                                        }
                                        if ($leave_type === "annual") {

                                            $query = "SELECT SUM(DATEDIFF(FROM_UNIXTIME(enddate),FROM_UNIXTIME(startdate))) AS days FROM leaves WHERE startdate >= '$first' AND startdate < '$last' AND employee_id='$employee_id' AND status='1'";
                                            $getleaves = mysqli_query($con, $query) or die($query);
                                            $row = mysqli_fetch_array($getleaves);
                                            $days_used = $row["days"];


                                            $interval = date_diff(date_create($st_date), date_create($en_date));
                                            $days_requested = $interval->format("%d");

                                            if (($days_requested + $days_used) > $annual_leave) {
                                                $errors[] = "Days for the leave exceed those left for the employees annual annual leave";
                                            }
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                    ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php
                                            }
                                        } else {
                                            mysqli_query($con, "INSERT INTO leaves(employee_id,leave_type,startdate,enddate,returndate,timestamp,creator,status) VALUES('$employee','$leave_type','$startdate','$enddate','',UNIX_TIMESTAMP(),'" . $_SESSION['emp_id'] . "','0')") or die(mysqli_error($con));
                                            ?>
                                            <div class="alert alert-success"><i class="fa fa-check"></i>Leave Successfully Added. </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <form method="post" name='form' class="form-horizontal" action="" enctype="multipart/form-data">
                                        <div class="form-group"><label class="col-sm-2 control-label">*Employee</label>
                                            <div class="col-sm-10">
                                                <select name="employee" class="form-control">
                                                    <option value="" selected="selected">Select Employee ...</option>
                                                    <?php
                                                    $employees = mysqli_query($con, "SELECT * FROM employees WHERE status='1'");
                                                    while ($row = mysqli_fetch_array($employees)) {
                                                        $employee_id = $row['employee_id'];
                                                        $fullname = $row['fullname'];
                                                        $checkleave = mysqli_query($con, "SELECT * FROM leaves WHERE employee_id='$employee_id' AND status=1 AND returndate=''");
                                                        if (mysqli_num_rows($checkleave) == 0) {
                                                            $query = "SELECT SUM(DATEDIFF(FROM_UNIXTIME(enddate),FROM_UNIXTIME(startdate))) AS days FROM leaves WHERE startdate >= '$first' AND startdate < '$last' AND employee_id='$employee_id' AND status='1'";
                                                            $getleaves = mysqli_query($con, $query) or die($query);
                                                            $row = mysqli_fetch_array($getleaves);
                                                            $days_used = $row["days"];

                                                            $remaining = ($annual_leave - $days_used);
                                                    ?>
                                                            <option value="<?php echo $employee_id; ?>"><?php echo $fullname; ?> (<?php echo $remaining; ?> days remaining)</option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">*Leave Type</label>
                                            <div class="col-sm-10">
                                                <select name="leave_type" id="leave_type" class="form-control">
                                                    <option value="annual" selected="selected">Annual</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group" style="display: none;" id="reason-div">
                                            <label class="col-sm-2 control-label">Reason for leave</label>
                                            <div class="col-sm-10">
                                                <textarea name='reason' class="form-control" placeholder="Enter reason for leave"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Leave Start Date</label>
                                            <div class="col-sm-10">
                                                <input type="date" name='startdate' class="form-control" placeholder="Enter Date">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Leave End Date</label>
                                            <div class="col-sm-10">
                                                <input type="date" name='enddate' class="form-control" placeholder="Enter Date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" type="submit">Add Leave</button>
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
    $("#leave_type").on("change", function() {
        var type = $(this).val();

        if (type === "other") {
            $("#reason-div").show();
        } else {
            $("#reason-div").hide();
        }
    })
</script>