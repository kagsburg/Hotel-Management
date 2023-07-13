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

    <title>Gym and Swimming Pool Bouquets | Hotel Manager</title>
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
        include 'fr/gymbouquets.php';
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
                        <h2>Gym and Swimming Pool Bouquets</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>Gym and Pool Bouquets</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Add Bouquet</h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['bouquet'], $_POST['charge'], $_POST['days'])) {
                                        $bouquet = mysqli_real_escape_string($con, trim($_POST['bouquet']));
                                        $charge =  mysqli_real_escape_string($con, trim($_POST['charge']));
                                        $days =  mysqli_real_escape_string($con, trim($_POST['days']));
                                        if ((empty($bouquet)) || (empty($charge)) || (empty($days))) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                        }
                                        if (is_numeric($charge) == FALSE) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Charge should be An Integer</div>';
                                        } else {

                                            mysqli_query($con, "INSERT INTO gymbouquets(gymbouquet,charge,days,creator,timestamp,status) VALUES('$bouquet','$charge','$days','" . $_SESSION['emp_id'] . "',UNIX_TIMESTAMP(),'1')") or die(mysqli_error($con));

                                            echo '<div class="alert alert-success"><i class="fa fa-check"></i>Reservation Purpose successfully added</div>';
                                        }
                                    }
                                    ?>
                                    <form method="post" class="form" action='' name="form" enctype="multipart/form-data">
                                        <div class="form-group"><label class="control-label">Bouquet Name</label>
                                            <input type="text" class="form-control" name='bouquet' placeholder="Enter Bouquet" required='required'>
                                        </div>

                                        <div class="form-group"><label class="control-label">Number of Days</label>
                                            <input type="number" class="form-control" name="days" placeholder="Enter Days " required='required'>
                                        </div>

                                        <div class="form-group"><label class="control-label">Charge</label>
                                            <input type="text" class="form-control" name='charge' placeholder="Enter  Charge" required='required'>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-success btn-sm" name="submit" type="submit">Submit</button>

                                        </div>
                                    </form>


                                </div>


                            </div>

                        </div>
                        <div class="col-lg-7">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Bouquets</h5>

                                </div>
                                <div class="ibox-content">
                                    <table class="table table-striped  table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Charge</th>
                                                <th>Days</th>
                                                <th>Added by</th>
                                                <th>&nbsp;</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr> <?php
                                                    $gymbouquets = mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1'");
                                                    if (mysqli_num_rows($gymbouquets) > 0) {
                                                        while ($row = mysqli_fetch_array($gymbouquets)) {
                                                            $gymbouquet_id = $row['gymbouquet_id'];
                                                            $gymbouquet = $row['gymbouquet'];
                                                            $charge = $row['charge'];
                                                            $days = $row['days'];
                                                            $creator = $row['creator'];
                                                            $timestamp = $row['timestamp'];
                                                            $status = $row['status'];
                                                    ?>

                                            <tr>
                                                <td><?php echo $gymbouquet; ?></td>
                                                <td><?php echo $charge; ?></td>
                                                <td><?php echo $days; ?></td>

                                                <td>
                                                    <div class="tooltip-demo">

                                                        <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile" data-toggle="tooltip" data-placement="bottom" title="">
                                                            <?php
                                                            $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                            $row2 = mysqli_fetch_array($employee);
                                                            $employee_id = $row2['employee_id'];
                                                            $fullname = $row2['fullname'];
                                                            echo $fullname;  ?></a>
                                                    </div>
                                                </td>

                                                <td>
                                                    <?php
                                                            if (($_SESSION['hotelsyslevel'] == 1)) {
                                                    ?>
                                                        <a href="editbouquet?id=<?php echo $gymbouquet_id; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="hidebouquet?id=<?php echo $gymbouquet_id; ?>" onclick="return cdelete<?php echo $gymbouquet_id; ?>()" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                                        <script type="text/javascript">
                                                            function cdelete<?php echo $gymbouquet_id; ?>() {
                                                                return confirm('You are about To Delete this item. Do you want to proceed?');
                                                            }
                                                        </script>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                    <?php
                                                        }
                                                    } else {
                                                        echo "<div class='alert alert-danger'>No Bouquet Added Yet</div>";
                                                    }
                                    ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>




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



</body>


</html>