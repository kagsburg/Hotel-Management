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

    <title>Add room | Hotel Manager</title>
    <script src="ckeditor/ckeditor.js"></script>
    <script language="JavaScript" src="../js/gen_validatorv4.js" type="text/javascript"></script>
    <link rel="stylesheet" href="ckeditor/samples/sample.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/addroom.php';
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
                        <h2>Add New Room</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="rooms">Room</a> </li>
                            <li class="active">
                                <strong>Add Room</strong>
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
                                    <h5>Add New Room <small>Ensure to fill all neccesary fields</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['number'], $_POST['type'])) {
                                        if ((!empty($_POST['number'])) || (!empty($_POST['type']))) {
                                            $number =  mysqli_real_escape_string($con, trim($_POST['number']));
                                            $type = mysqli_real_escape_string($con, trim($_POST['type']));
                                            $item = $_POST['item'];
                                            $check =  mysqli_query($con, "SELECT * FROM rooms WHERE roomnumber='$number' AND status=1");
                                            if (mysqli_num_rows($check) > 0) {
                                                echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Room Number Already Exists</div>';
                                            } else {


                                                mysqli_query($con, "INSERT INTO rooms(roomnumber,type,creator,status) VALUES('$number','$type','" . $_SESSION['emp_id'] . "','1')") or die(mysqli_errno($con));
                                                $last_id = mysqli_insert_id($con);
                                                foreach ($item as $item) {
                                                    if (!empty($item)) {
                                                        mysqli_query($con, "INSERT INTO roomitems(room_id,item_id,status) VALUES('$last_id','$item',1)");
                                                    }
                                                }
                                                echo '<div class="alert alert-success"><i class="fa fa-check"></i> Room successfully Added</div>';
                                            }
                                        } else {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>All Fields Required</div>';
                                        }
                                    }
                                    ?>

                                    <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                                        <div class="form-group"><label class="control-label">Room Number</label>
                                            <input type="text" name="number" class="form-control" placeholder="Enter Room Number" required="required">
                                        </div>
                                        <div class="form-group"><label class="control-label">Room Type</label>
                                            <select name="type" class="form-control">
                                                <option value="" selected="selected">select room type...</option>
                                                <?php
                                                $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE status=1");
                                                while ($row = mysqli_fetch_array($roomtypes)) {
                                                    $roomtype_id = $row['roomtype_id'];
                                                    $roomtype = $row['roomtype'];
                                                    $charge = $row['charge'];
                                                    $status = $row['status'];
                                                ?>
                                                    <option value="<?php echo $roomtype_id; ?>"><?php echo $roomtype; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Add Room</button>

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
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
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