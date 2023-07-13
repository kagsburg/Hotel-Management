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

    <title> Bouquets | Hotel Manager</title>
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
        include 'fr/poolpackages.php';
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
                        <h2>Gym & Pool Bouquets</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li class="active">
                                <strong>Gym & Pool Bouquets</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Add Bouquet <small>Ensure to fill all necessary fields</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['package'], $_POST['charge'], $_POST["days"])) {
                                        $package =  mysqli_real_escape_string($con, trim($_POST['package']));
                                        $charge =  mysqli_real_escape_string($con, trim($_POST['charge']));
                                        $days =  mysqli_real_escape_string($con, trim($_POST['days']));
                                        if ((empty($package) || (empty($charge)))) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                        }
                                        if (is_numeric($charge) == FALSE) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Charge should be An Integer</div>';
                                        } else {
                                            mysqli_query($con, "INSERT INTO poolpackages(poolpackage,charge,days,creator,status) VALUES('$package','$charge','$days','" . $_SESSION['emp_id'] . "','1')") or die(mysqli_error($con));

                                            echo '<div class="alert alert-success"><i class="fa fa-check"></i>Bouquet successfully added</div>';
                                        }
                                    }
                                    ?>
                                    <form method="post" class="form" action="" name="form" enctype="multipart/form-data">
                                        <div class="form-group"><label class="control-label">Bouquet</label>
                                            <input type="text" class="form-control" name='package' placeholder="Enter Bouquet" required='required'>
                                        </div>

                                        <div class="form-group"><label class="control-label">Number of Days</label>
                                            <input type="number" class="form-control" name="days" placeholder="Enter Days " required='required'>
                                        </div>

                                        <div class="form-group"><label class="control-label">Charge</label>
                                            <input type="text" class="form-control" name='charge' placeholder="Enter  Charge" required='required'>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-success btn-sm" name="submit" type="submit">Add Bouquet</button>
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
                                                <th>Bouquet</th>
                                                <th>Charge</th>
                                                <th>Days</th>
                                                <th>&nbsp;</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr> <?php
                                                    $getpackages = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1'");
                                                    if (mysqli_num_rows($getpackages) > 0) {
                                                        while ($row = mysqli_fetch_array($getpackages)) {
                                                            $poolpackage_id = $row['poolpackage_id'];
                                                            $poolpackage = $row['poolpackage'];
                                                            $charge = $row['charge'];
                                                            $creator = $row['creator'];
                                                            $days = $row['days'];
                                                            $status = $row['status'];
                                                    ?>

                                            <tr>
                                                <td><?php echo $poolpackage; ?></td>
                                                <td><?php echo $charge; ?></td>
                                                <td><?php echo $days; ?></td>

                                                <td>
                                                    <?php
                                                            if (($_SESSION['hotelsyslevel'] == 1)) {
                                                    ?>
                                                        <a data-toggle="modal" class="btn btn-info btn-xs" href="#modal-form<?php echo $poolpackage_id; ?>"><i class="fa fa-edit"></i> Edit</a>

                                                        <a href="hidepoolpackage?id=<?php echo $poolpackage_id; ?>" onclick="return cdelete<?php echo $poolpackage_id; ?>()" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                                        <script type="text/javascript">
                                                            function cdelete<?php echo $poolpackage_id; ?>() {
                                                                return confirm('You are about To Delete a Bouquet. Do you want to proceed?');
                                                            }
                                                        </script>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                    <?php
                                                        }
                                                    } else {
                                                        echo "<div class='alert alert-danger'>No Bouquets Added Yet</div>";
                                                    }
                                    ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
        <?php
        $getpackages = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1'");
        while ($row = mysqli_fetch_array($getpackages)) {
            $poolpackage_id = $row['poolpackage_id'];
            $poolpackage = $row['poolpackage'];
            $charge = $row['charge'];
            $days = $row['days'];
        ?>
            <div id="modal-form<?php echo $poolpackage_id; ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="post" class="form" action="editpoolpackage?id=<?php echo $poolpackage_id; ?>" name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Bouquet</label>
                                    <input type="text" class="form-control" name='package' placeholder="Enter Bouquet" required='required' value="<?php echo $poolpackage; ?>">
                                </div>

                                <div class="form-group"><label class="control-label">Number of Days</label>
                                    <input type="number" class="form-control" name="days" placeholder="Enter Days " required='required' value="<?php echo $days; ?>">
                                </div>

                                <div class="form-group"><label class="control-label">Charge</label>
                                    <input type="text" class="form-control" name='charge' placeholder="Enter  Charge" required='required' value="<?php echo $charge; ?>">
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success btn-sm" name="submit" type="submit">Edit Bouquet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    } ?>
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