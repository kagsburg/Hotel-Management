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
    <title>Add Laundry - Hotel Manager</title>
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
        include 'fr/addlaundry.php';
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
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Add New Laundry Work</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="laundrywork">Laundry</a> </li>
                            <li class="active">
                                <strong>Add laundry</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Add New Laundry Work <small>All fields marked (*) shouldn't be left blank</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                if (isset($_POST['clothes'], $_POST['package'])) {
                                    $reserve_id = $_POST['reserve'];
                                    $customername = $_POST['customername'];
                                    $phone = $_POST['phone'];
                                    $a_clothes = $_POST['clothes'];
                                    $a_package = $_POST['package'];
                                    foreach ($a_clothes as $key => $clothes) {
                                        $errors = [];
                                        $package = $a_package[$key];
                                        if ((empty($clothes)) || (empty($package))) {
                                            $errors[] = 'All Fields Marked with * should be filled';
                                        }
                                        if (is_numeric($clothes) == false) {
                                            $errors[] = 'Number of Clothes Should Be an Integer';
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {                                    ?>
                                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                          <?php
                                            }
                                        } else {
                                            $split = explode('_', $package);
                                            $package_id = current($split);
                                            $charge = end($split);
                                            mysqli_query($con, "INSERT INTO laundry(customername,phone,reserve_id,clothes,package_id,charge,creator,timestamp,status)VALUES('$customername','$phone','$reserve_id','$clothes','$package_id','$charge','" . $_SESSION['hotelsys'] . "',UNIX_TIMESTAMP(),'0')") or die(mysqli_errno($con));
                                        }
                                    }
                                    ?>
                                        <div class="alert alert-success"><i class="fa fa-check"></i> Laundry work Successfully Added</div>
                                    <?php

                                }
        ?>
                                    <form method="post" name='form' id="form" class="form" action="" enctype="multipart/form-data">
                                        <div class="single-load">
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
                                                    <label class="control-label">*Customer Name</label>
                                                    <input type="text" name='customername' class="form-control" placeholder="Enter Fullname">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">*Phone Number</label>
                                                    <input type="text" name='phone' class="form-control" placeholder="Enter Phone">
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                            <div class="form-group col-sm-6 data_5">
                                                <label class="control-label">* Start Date</label>
                                                <div class="input-daterange">
                                                    <input type="text" class="form-control" name="start" autocomplete="off" placeholder="start date" required="required" style="text-align: left;" />
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">* Start Time</label>
                                                <input type="time" class="form-control" name="stt" placeholder="start time" required="required" />
                                            </div>
                                        </div> -->
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
                                            <div class="form-group"><label class="control-label">* Number of Clothes</label>
                                                <input type="number" name='clothes[]' class="form-control" placeholder="Enter number of clothes" required="required" min="1">
                                            </div>
                                            <div class="form-group"><label class="control-label">* Charge</label>
                                                <select name="package[]" class="form-control">
                                                    <option value="" selected="selected"> Select ...</option>
                                                    <?php
            $getpackages = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1'");
        while ($row = mysqli_fetch_array($getpackages)) {
            $laundrypackage_id = $row['laundrypackage_id'];
            $laundrypackage = $row['laundrypackage'];
            $charge = $row['charge'];
            ?>
                                                        <option value="<?php echo $laundrypackage_id . '_' . $charge; ?>"> <?php echo $laundrypackage . ' (' . $charge . ')'; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="other-loads"></div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <button class="btn btn-default" id="addloadbtn">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Add Laundry</button>
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
        $('#form').on('click', '#resident', function() {
            var $load = $(this).closest('.single-load');
            if ($(this).prop("checked") === true) {
                $load.find('.forresidents').show();
                $load.find('.nonresidents').hide();
            } else {
                $load.find('.forresidents').hide();
                $load.find('.nonresidents').show();
            }
        });

        $('#form').on('click', '.rmload', function() {
            var $load = $(this).closest('.single-load');
            $load.remove();
        })
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
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    $('.data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",
    });

    $('#addloadbtn').on('click', function() {
        var loadhtml = `        
        <div class="single-load">
        <hr style="border-color: #5d5d5d;" />
        <div class="pull-right">
            <button class="btn btn-danger rmload">x</button>
        </div>        
        <div class="form-group"><label class="control-label">* Number of Clothes</label>
            <input type="number" name='clothes[]' class="form-control" placeholder="Enter number of clothes" required="required" min="1">
        </div>
        <div class="form-group"><label class="control-label">* Charge</label>
            <select name="package[]" class="form-control">
                <option value="" selected="selected"> Select ...</option>
                <?php
                $getpackages = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1'");
while ($row = mysqli_fetch_array($getpackages)) {
    $laundrypackage_id = $row['laundrypackage_id'];
    $laundrypackage = $row['laundrypackage'];
    $charge = $row['charge'];
    ?>
                    <option value="<?php echo $laundrypackage_id . '_' . $charge; ?>"> <?php echo $laundrypackage . ' (' . $charge . ')'; ?></option>
                <?php } ?>
            </select>

        </div>
        </div>
        `;

        $('#other-loads').append(loadhtml);
    })
</script>